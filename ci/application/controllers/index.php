<?php
class Index extends CI_Controller {
    
    public function __construct() {
        parent::__construct();     
    }
    
    public function index() {
        $this->config->load('democonfig', TRUE);
        $this->demo_config = $this->config->item('democonfig');
        $data['demo_config'] = $this->demo_config;
        $this->load->view('homepage.tpl.php', $data);
    }
}
