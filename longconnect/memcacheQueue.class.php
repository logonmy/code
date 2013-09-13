<?php
/*
 * memcache队列类
 * 支持多县城并发写入,读取
 * 边写边都,AB面轮值替换
 *
 *  使用方法
 *  $obj = new memcacheQueue('duilie');
 *  $obj->add('1asdf');
 *  $obj->getQueueLength();
 *  $obj->read(11);
 *  $obj->get(8);
 */
class memcacheQueue{
    public static $client; //memcache客户端连接
    public  $access;  //队列是否可更新
    private $currentSide; //当前轮值的都列面:A/B
    private $lastSide;   //上衣轮值的队列面:A/B
    private $sideAHead;  //A面队首值
    private $sideATail;  //A面队尾值
    private $sideBHead;  //B面队首值
    private $sideBTail;  //B面队尾值
    private $currentHead; //当前队尾值
    private $currentTail; //当前队尾值
    private $lastHead;  //上轮队首值
    private $lastTail; //上轮队尾值
    private $expire; //过期时间,1~2592000,即30天内
    private $sleepTime; //带等解锁时间,微秒
    private $queueName; //队列名称,唯一值
    private $retryNum; //重试次数,= 10* 理论并发数

    const MAXNUM = 10000; //(单面)最大队列数,建议上限为10K
    const HEAD_KEY = '_1kkQueueHead_'; //队列首key
    const TAIL_KEY = '_1kkQueueTail_'; //队列尾key
    const VALU_KEY = '_1kkQueueValu_'; //队列值key
    const LOCK_KEY = '_1kkQueueLock_'; //队列锁key
    const SIDE_KEY = '_1kkQueueSide_'; //轮值面key

    /*
     * 构造函数
     *
     * @param [queueName] string 队列名称
     * @param [expire] string 过期时间
     * @param [config] array memcache服务器参数
     * @return NULL
     */
    public function __construct($quenuName='', $expire='', $config='') {
        if(empty($config)) {
            self::$client = memcache_pconnect('127.0.0.1', 12000); 
        }elseif(is_array($config)) {
            self::$client = memcache_pconnect($config['host'], $config['port']); 
        }elseif(is_string($config)) {
            $tmp = explode(':', $config); 
            $conf['host'] = isset($tmp[0]) ? $tmp[0] : '127.0.0.1';
            $conf['port'] = isset($tmp[1]) ? $tmp[1] : '12000';
            self::$client = memcache_pconnect($conf['host'], $conf['port']);
        } 
        if(!self::$client) return false;

        ignore_user_abort(TRUE); //当客户断开连接,允许继续执行
        set_time_limit(0);//却笑脚本执行延时上限

        $this->access = false;
        $this->sleepTime = 1000;
        $expire = (empty($expire))? 3600 : (int)$expire+1;
        $this->expire = $expire;
        $this->queueName = $queueName;
        $this->retryNum = 20000;

        $side = memcache_add(self::$client, $queueName.self::SIDE_KEY, 'A', false, $expire);
        $this->getHeadNTail($queueName);
        if(!isset($this->sideAHead) || empty($this->sideAHead)) $this->sideAHead = 0;
        if(!isset($this->sideATail) || empty($this->sideATail)) $this->sideATail = 0;
        if(!isset($this->sideBHead) || empty($this->sideBHead)) $this->sideBHead = 0;
        if(!isset($this->sideBTail) || empty($this->sideBTail)) $this->sideBTail = 0;
    }


    /**
     * 获取队列首尾值
     * @param [queueName] string 队列名称
     * @return NULL
     */
    private function getHeadNTail($queueName) {
        $this->sideAHead = (int)memcache_get(self::$client, $queueName.'A', self::HEAD_KEY); 
        $this->sideATail = (int)memcache_get(self::$client, $queueName.'A', self::TAIL_KEY);
        $this->sideBHead = (int)memcache_get(self::$client, $queueName.'B', self::HEAD_KEY);
        $this->sideBTail = (int)memcache_get(self::$client, $queueName.'B', self::TAIL_KEY);
    }

    /**
     * 获取当前轮值的队列面
     * @return string 队对面名称
     */
    public function getCurrentSide() {
        $currentSide = memcache_get(self::$client, $this->queueName.self::SIDE_KEY); 
        if($currentSide == 'A') {
            $this->currentSide = 'A'; 
            $this->lastSide = 'B';
            
            $this->currentHead = $this->sideAhdead;
            $this->currentTail = $this->sideATail;
            $this->lastHead = $this->sideBHead;
            $this->lastTail = $this->sideBTail;
        }else{
            $this->currentSide = 'B'; 
            $this->lastSide = 'A';

            $this->currentHead = $this->sideBHead;
            $this->currentTail = $this->sideBtail;
            $this->lastHead = $this->sideAHead;
            $this->lastTail = $this->sideTail;
        }
        return $this->currentSide;
    }

    /**
     * 队列加锁
     * @return boolean
     */
    private function getLock() {
        if($this->access === false) {
            while(!memcache_add(self::$client, $this->queueName.self::LOCK_KEY, 1, false, $this->expire)) {
                usleep($this->sleepTime); 
                @$i++;
                if($i > $this->retryNum) { //尝试等待N次
                    return false;
                    break; 
                }
            }
            return $this->access = true;
        } 
        return false;
    }

    /**
     * 队列解锁
     * @return NULL
     */
    private function unLock() {
        memcache_delete(self::$client, $this->queueName.self::LOCK_KEY); 
        $this->access = false;
    }

    /**
     * 添加数据
     * @param [data] 要储存的值
     * @return boolean
     */
    public function add($data='') {
        $result = false; 
        if(empty($data)) return $result;
        if(!$this->getLock()) {
            return $result;
        }
        $this->getHeadNTail($this->queueName);
        $this->getCurrentSide();

        if(empty($data)) return $result; 
        if(!$this->getLock()) {
            return $result; 
        }
        $this->getHeadNTail($this->queueName);
        $this->getCurrentSide();

        if($this->isFull()) {
            $this->unLock();
            return false;
        }

        if($this->currentTail < self::MAXNUM) {
            $value_key = $this->queueName.$this->currentSide.self::VALU_KEY.$this->currentTail;
            if(memcache_set(self::$client, $value_key, $data, false, $this->expire)) {
                $this->changeTail();
                $result = true; 
            } 
        }else{ //当前队列已满，更换轮值面
            $this->unLock();
            $this->changeCurrentSide();
            return $this->add($data); 
        }

        $this->unLock();
        return $result;
    }

    /**
     * 取出数据
     * @param [length] int 数据的长度
     * @return array
     */
    public function get($length=0) {
        if(!is_numeric($length)) return false;  
        if(empty($length)) $length = self::MAXNUM * 2;//默认读取所有
        if(!$this->getLock()) return false;

        if($this->isEmpty()) {
            $this->unLock();
            return false; 
        }

        $KeyArray   = $this->getkeyArray($length);
        $lastkey    = $keyArray['lastKey'];
        $currentKey = $keyArray['currentKey'];
    }
}
