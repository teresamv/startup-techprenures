<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/third_party/PHPMailer/PHPMailerAutoload.php';

class Buyers extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
        
    }

    public function index()
    {
        
        $user_id = 5;
        $this->load->library('pagination');
        $search = $this->input->get('search');
        $industry = $this->input->get('industry');
        $country = $this->input->get('country');
        $sector = $this->input->get('sector');
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if ($this->input->get('cancel')) {
            $search = '';
            $country = '';
            $$industry = '';
            $sector = '';
        }

        

        $config = array();
        $config["base_url"] = base_url() . "buyers/index";
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 3;
        $config['reuse_query_string'] = true;
        $config["total_rows"] = $this->general_model->countBuyers($search, $industry, $country, $sector);
        $this->pagination->initialize($config);
        $offset = ($page - 1) * $config["per_page"];
        $random_order = true;

        $this->data['buyers'] = $this->general_model->getbuyersFilter($config["per_page"], $offset, $search, $industry, $country, $sector, $random_order);
        $this->data['total_buyers'] = $config["total_rows"];
        $this->data['search'] = $search;
        $this->data['funding_name'] = '';
        $this->data['countries'] = $this->general_model->GetLocationBuyers();
        //print_r($this->data['countries']);
        

        $attendee = $this->general_model->getOne('attende_details', array('login_id' => $user_id, 'isActive' => 1));

        if (!empty($this->data['buyers'])) {
            foreach($this->data['buyers'] as $buyers_row){
                $buyers_row->{'expertise_tag'} = $this->general_model->getAll('expertise_tag', array('attende_id' => $buyers_row->nUserId,'isActive'=>1));
                $buyers_row->{'expertise_names'} = $this->general_model->getDistinctValues('expertise_tag', 'expertise');
                $buyers_row->{'attende_details'} = $this->general_model->getOne('attende_details', array('login_id' => $buyers_row->nUserId,'isActive'=>1));
                
            }
        }
        //print_r( $this->data['buyers']);
        //exit;
        $this->data['industry_names'] = $this->general_model->getDistinctValues('attende_details', 'industry');
        //print_r($this->data['industry_names']);exit;
        
        
        //$this->data['sectors'] = $sector_array;
        $this->data['types'] = $this->general_model->GetFocusFunding();
        // $user_id = isset($this->session->userdata('session_user_data')['id']) ? $this->session->userdata('session_user_data')['id'] : null;
        //$this->data['buyers_details'] =  $this->general_model->getAll('expand', array('isActive'=> 1));
        $this->data['startups_names'] = $this->general_model->get_startups();
        $this->template->public_render('public/buyers/index', $this->data);
    }    

    public function details($id) {
        $user_id = 6;
        $buyers_details = "";
        //echo $id;exit;
        if($user_id){
        // if (isset($this->session->userdata('session_user_data')['id']) && $this->session->userdata('session_user_data')['user_type'] == 2) {
            $attendee_details   = $this->general_model->getOne('attende_details', array('id' => $id));
            if(!empty($attendee_details)){
                $buyers_details    =  $this->general_model->getOne('expand', array('nUserId'=>$attendee_details->login_id,'isActive'=> 1));

            }
            
            $this->data['title'] = $attendee_details->name;
            $this->data['buyers_details'] = $buyers_details;
            $this->data['attendee_details']= $attendee_details;
            $this->template->public_render('public/buyers/details', $this->data);
        } else {
            redirect('login/getlogin');      
        }
    }
}