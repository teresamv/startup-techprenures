<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class MY_Controller extends CI_Controller {



    public function __construct() {

        parent::__construct();

        /* Load */

        $this->load->library(array('form_validation', 'template'));

        $this->load->helper(array('array', 'language', 'url', 'api'));

        $this->load->model('Model');

        $userData = $this->session->userdata("mstuser");

		$segments = $this->uri->segment_array();

        Auth_login();

    }



}



class Admin_Controller extends CI_Controller {

	public function __construct() {

		parent::__construct();

		$segments = $this->uri->segment_array();
        if (empty($this->session->userdata('admin_data')['id']) || $this->session->userdata('admin_data')['user_type'] != 1) {
            redirect('auth/login', 'refresh');
        }

		$this->user = $this->general_model->getOne('mstuser', array('id' => $this->session->userdata('id')));

		$url = base_url($segments[1] . '/' . $segments[2] . '/' );

		$this->session->set_userdata('public_base_url', $url);

		$this->home_url = $this->session->userdata('public_base_url');

		

	}



}



class Public_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $segments = $this->uri->segment_array();

        // Check if the second segment exists, otherwise use a fallback
        if (isset($segments[1])) {
            $url = base_url($segments[1] . '/');
        } else {
            // Fallback: use 'startups' as the default if it's not there
            $url = base_url('startups/');
        }

        $this->session->set_userdata('public_base_url', $url);
        $this->home_url = $this->session->userdata('public_base_url');
    }
}
