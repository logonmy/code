<?php
/**
 *memcache构建的简单内存队列
 *
 *
 */
class memList{
    private $memcache; //memcache类
    private $quKeyPrefix;//数据键前缀
    private $startKey;//开始指针键
    private $endKey;//结束指针键

    public function __construct($key) {
        $this->queKeyPrefix = "MEMQUE_{$key}_"; 
        $this->startKey = "MEMQUE_SK_{$key}";
        $this->endKey = "MEMQUE_EK_{$key}";
    }

    /**
     * 获取列表
     * 先拿到开始结束指针，然后去拿数据
     *
     * @return array
     */
    public function getList() {
        $startP = $this->memcache->get($this->startKey);  
        $endP = $this->memcache->get($this->endKey);
        empty($startP) && $startP = 0;
        empty($endP) && $endP = 0;
        $arr = array();
        for($i = $startP; $i<$endP;++$i) {
            $key = $this->queKeyPrefix.$i;
            $arr[] = $this->memcache->get($key); 
        }
        return $arr;
    }

    /**
     * 插入队列
     * 结束指针后移，拿到一个自增ID
     * 再把值存到指针指定的位置
     *
     * @return void
     */
    public function in($value) {
        $index = $this->memcache->increment($this->endKey); 
        $key = $this->queKeyPrefix.$index;
        $this->memcache->set($Key, $value);
    }

    /**
     * 出队
     * 把开始值却出后开始指针后移
     * @return mixed
     */
    public function out() {
        $result = $this->memcache->get($this->startKey); 
        $this->memcache->increment($this->startKey);
        return $result;
    }

    public function test() {
        echo "123";exit;
    }
}

