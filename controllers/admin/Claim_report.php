<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Claim_report extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $admin_data = $this->session->userdata('admin_data');
        if (isset($admin_data['id'])) {
            $this->user_id = $admin_data['id'];
        }
       if (isset($admin_data['user_type'])) {
            $this->user_type = $admin_data['user_type'];
        }
       
    }
    public function index(){
        $user = $this->general_model->getOne('mstuser', array('id' =>$this->user_id ));
      
        $this->data['user'] = $user;
        $this->data['title']    = 'Claim report';
        $this->template->admin_render('admin/claim_report/index',$this->data);
    }
   public function getreport(){
    // $action = '$1';
    $this->load->library('datatables');
    $this->datatables
        ->select('claim_report.id, claim_report.name, claim_report.request_msg, claim_report.login_id,claim_report.claim_profile_id')
        ->from('claim_report');
    // $this->datatables->add_column("Actions", $action, "attende_details.id");
    echo $this->datatables->generate();
   } 
}
?>