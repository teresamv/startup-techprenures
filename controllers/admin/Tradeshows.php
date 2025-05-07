<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tradeshows extends Admin_Controller
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
        $this->data['title']      = 'Tradeshows List';
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
          $this->data['user'] = $user;
        $this->template->admin_render('admin/tradeshows/index', $this->data);
    }

    public function getTradeshows()
    {
        $action = '$1';
        $action = '<a href="javascript:void(0)" data-id="$1" id="dlt_tradeshows" class="btn btn-danger btn-sm">Delete</a>';

        $this->load->library('datatables');
        $this->datatables
            ->select('tradeshows.nTradeshowId, tradeshows.cName,tradeshows.cCountryName,tradeshows.cFocus,tradeshows.cIndustry')
            ->from('tradeshows')
            ->where('isActive', 1);

        $this->datatables->add_column("Actions", $action, "tradeshows.nTradeshowId");
        echo $this->datatables->generate();
    }
    public function deleteTradeshows(){
        $id = $this->input->post('id');
          
        $this->db->where('nTradeshowId', $id);
        $deleted = $this->db->update('tradeshows', array('isActive' => 0));
    
        if($deleted){
            echo json_encode(['status' => '1', 'message' => 'Tradeshows Delete successfully']);
    
        }else{
            echo json_encode(['status' => '0', 'message' => 'Failed to Delete Tradeshows']);
    
        }
      }
    

    public function import()
    {
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
                        if (!empty($value[0]) && $key > 0 && !empty($value[9])) {
                            $tradeshows = $this->general_model->getOne('tradeshows', array('cName' => trim($value[0]),'cIndustry' => trim($value[4]) ? trim($value[4]) : '','cCountryName' => trim($value[8]) ? trim($value[8]) : '','isActive'=>1));
                            $data = array(
                                'cName' => trim($value[0]) ? trim($value[0]) : '',
                                'cImage' => trim($value[1]) ? trim($value[1]) : '',
                                'dtDateFrom' => trim($value[2]) ? trim($value[2]) : '',
                                'dtToDate' => trim($value[3]) ? trim($value[3]) : '',
                                'cIndustry' => trim($value[4]) ? trim($value[4]) : '',
                                'cFocus' => trim($value[5]) ? trim($value[5]) : '',
                                'cTradeCommisionarProgram' => trim($value[6]) ? trim($value[6]) : '',
                                'cLocation' => trim($value[7]) ? trim($value[7]) : '',
                                'cCountryName' => trim($value[8]) ? trim($value[8]) : '',
                                'cWebsite' => trim($value[9]) ? trim($value[9]) : '',
                                'created_on' => time(),
                            );
                            if ($tradeshows) {
                               
                            } else {
                                $tradeshows_id = $this->general_model->insert('tradeshows', $data);
                                if ($tradeshows_id) {
                                    
                               } else {
                                    $error_message .= "Failed to insert tradeshows details for" . $data['cName'] . ". ";
                                }
                            }
                            $success++;
                        }
                    }
                    if ($success == 0) {
                        $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    } else {
                        $msg = "Total (" . $success . ") item successfully imported.";
                        if ($message) {
                            $msg .= "<br>" . $message;
                        }
                        $this->session->set_flashdata('message', array('1', $msg));
                    }
                    redirect('admin/Tradeshows', 'refresh');
                } else {
                    $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    redirect('admin/Tradeshows/', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', array('0', "File is empty or not properly formatted."));
                redirect('admin/Tradeshows/', 'refresh');
            }
        }
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->data['title'] = 'Import Tradeshows';
        $this->template->admin_render('admin/tradeshows/import', $this->data);
    }

    

}