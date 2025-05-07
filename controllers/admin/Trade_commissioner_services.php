<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Trade_commissioner_services extends Admin_Controller
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
        $this->data['title']      = 'Trade Commissioner List';
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
          $this->data['user'] = $user;
        $this->template->admin_render('admin/tradecommissionerservices/index', $this->data);
    }

    public function getTradecommissionerServices()
    {
        $action = '$1';
        $action = '<a href="javascript:void(0)" data-id="$1" id="dlt_trade_commissioner_services" class="btn btn-danger btn-sm">Delete</a>';

        $this->load->library('datatables');
        $this->datatables
            ->select('tradecommissionerservices.TradeCommissionerServicesid, tradecommissionerservices.cCommissionerName, tradecommissionerservices.cEmail, tradecommissionerservices.cCountryName, tradecommissionerservices.cWebsiteURL')
            ->from('tradecommissionerservices')
            ->where('isActive', 1);

        $this->datatables->add_column("Actions", $action, "tradecommissionerservices.TradeCommissionerServicesid");
        echo $this->datatables->generate();

    }
    public function deleteTradecommissionerServices(){
        $id = $this->input->post('id');
          
        $this->db->where('TradeCommissionerServicesid', $id);
        $deleted = $this->db->update('tradecommissionerservices', array('isActive' => 0));
    
        if($deleted){
            echo json_encode(['status' => '1', 'message' => 'tradecommissioner Delete successfully']);
    
        }else{
            echo json_encode(['status' => '0', 'message' => 'Failed to Delete tradecommissioner']);
    
        }
      }
    

    public function import()
    {
        $error_message = "";
        if (isset($_FILES["csv_file"])) {
            $this->load->library('upload');
            $sheet_data = array_map('str_getcsv', file($_FILES['csv_file']['tmp_name']));
            if (isset($sheet_data[0])) {
                $headings = $sheet_data[0];
                if ($sheet_data) {
                    $startup = array();
                    $message = '';
                    $success = 0;   
                    foreach ($sheet_data as $key => $value) {
                        if (!empty($value[0]) && $key > 0 && !empty($value[4])) {
                            $tradecommissionerservices = $this->general_model->getOne('tradecommissionerservices', array('cEmail' => trim($value[2]) ? trim($value[2]) : '','isActive'=>1));
                            //echo $this->db->last_query();exit;
                            //print_r($tradecommissionerservices);
                            $data = array(
                                'cCountryName' => trim($value[0]) ? trim($value[0]) : '',
                                'cCommissionerName' => trim($value[1]) ? trim($value[1]) : '',
                                'cEmail' => trim($value[2]) ? trim($value[2]) : '',
                                'cWebsiteURL' => trim($value[3]) ? trim($value[3]) : '',
                                'cSupport' => trim($value[4]) ? trim($value[4]) : '',
                                'created_on' => time(),
                                'isActive'=>1
                            );
                            //print_r($tradecommissionerservices);
                            if ($tradecommissionerservices) {
                               //echo "hello";exit;
                               $error_message .= "Already exist tradecommissioner details";
                            } else {
                                $tradecommissionerservices = $this->general_model->insert('tradecommissionerservices', $data);
                                if ($tradecommissionerservices) {
                               } else {
                                    $error_message .= "Failed to insert tradecommissioner details for" . $data['cCommissionerName'] . ". ";
                                }
                            }
                            $success++;
                        }
                    }
                    if ($success == 0) {
                        $this->session->set_flashdata('message', array('0', $error_message));
                    } else {
                        $msg = "Total (" . $success . ") item successfully imported.";
                        if ($message) {
                            $msg .= "<br>" . $message;
                        }
                        $this->session->set_flashdata('message', array('1', $msg));
                    }
                    redirect('admin/Trade_commissioner_services', 'refresh');
                } else {
                    $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    redirect('admin/Trade_commissioner_services/', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', array('0', "File is empty or not properly formatted."));
                redirect('admin/Trade_commissioner_services/', 'refresh');
            }
        }
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->data['title'] = 'Import Tradecommissioner Services';
        $this->template->admin_render('admin/tradecommissionerservices/import', $this->data);
    }

    
}