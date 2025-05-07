<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $admin_data = $this->session->userdata('admin_data');

        if($admin_data) {
            if (isset($admin_data['id'])) {
                $this->user_id = $admin_data['id'];
            }
        
            
            if (isset($admin_data['user_type'])) {
                $this->user_type = $admin_data['user_type'];
            }
          }
        $this->form_validation->set_error_delimiters("<div class='error'>", "</div>");
    }

    public function index()
    {
        $this->data['title']      = 'Dashboard';
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->data['startup']    = $this->general_model->getCount('startup_details',array('isActive'=>1));
        $this->data['attende']    = $this->general_model->getCount('attende_details',array('isActive'=>1));
        $this->data['event']    = $this->general_model->getCount('events',array('isActive'=>1));
        $this->data['report'] = $this->general_model->getCount('claim_report');
        $this->template->admin_render('admin/dashboard/index', $this->data);
    }
}
