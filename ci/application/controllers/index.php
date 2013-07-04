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

    public function image_unit() {
        echo "test..."; 
        $this->load->library('unit_test');
        $this->load->library('Image');
        $test = $this->image->a_image();
        $expected_result = 'AA';
        $test_name = 'Image Unit';
        echo $this->unit->run($test, $expected_result, $test_name);
    }
}
