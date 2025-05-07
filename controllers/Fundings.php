<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/third_party/PHPMailer/PHPMailerAutoload.php';

class Fundings extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
        
    }

    public function index()
    {
        
        $this->load->library('pagination');
        echo $search = $this->input->get('search');
        $type = $this->input->get('type');
        $country = $this->input->get('country');
        $sector = $this->input->get('sector');
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if ($this->input->get('cancel')) {
            $search = '';
            $country = '';
            $type = '';
            $sector = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "fundings/index";
        $config["per_page"] = 12;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 3;
        $config['reuse_query_string'] = true;
        $sector_array = array("Consumer Goods","Data & Analytics","Privacy & Security","IaaS","SaaS","Biotech","Gaming","Transportation","E-Commerce","Hardware","Marketplaces","Real Estate","Healthcare","Social / Communities","Advertising & Media","Manufacturing","Food & Beverages","Natural Resources","Future of Work","FoodTech","Sales & Marketing","Education","Web3 / Blockchain","Agriculture & Farming","Privacy & Energy","AI/ML","Government","Marketplace","Travel & Tourism","Social & Communities","Financial Services & Payments","CleanTech & Impact & Sustainability","Mental Health","Aging","Technology","Investment Focus");
        
        $config["total_rows"] = $this->general_model->countFundings($search, $type, $country, $sector);
        $this->pagination->initialize($config);
        $offset = ($page - 1) * $config["per_page"];
        $random_order = true;

        $this->data['fundings'] = $this->general_model->getFundingFilter($config["per_page"], $offset, $search, $type, $country, $sector, $random_order);
        $this->data['total_funding'] = $config["total_rows"];
        $this->data['search'] = $search;
        $this->data['funding_name'] = '';
        $this->data['countries'] = $this->general_model->GetLocationFunding();
        
        
        //$this->data['sectors'] = $this->general_model->GetSectorFunding();
        $this->data['sectors'] = $sector_array;
        $this->data['types'] = $this->general_model->GetFocusFunding();
        $user_id = isset($this->session->userdata('session_user_data')['id']) ? $this->session->userdata('session_user_data')['id'] : null;
        $this->data['attendee_details'] =  $this->general_model->getOne('attende_details', array('login_id' => $user_id, 'isActive'=> 1));
        $this->template->public_render('public/fundings/index', $this->data);
    }    

    public function details($id) {
        $user_id = 6;
        if($user_id){
        // if (isset($this->session->userdata('session_user_data')['id']) && $this->session->userdata('session_user_data')['user_type'] == 2) {
            $fundings_details   = $this->general_model->getOne('fundings_details', array('id' => $id));
            $this->data['title'] = $fundings_details->name;
            $this->data['fundings_details'] = $fundings_details;
            $this->template->public_render('public/fundings/details', $this->data);
        } else {
            redirect('login/getlogin');      
        }
    }
}