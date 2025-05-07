<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Expand extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->library('upload');
        //$this->load->library('PHPExcel'); 
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
        $this->data['title']      = 'Expand List';
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->template->admin_render('admin/expand/index', $this->data);
    }

    public function getExpand()
    {
        $action = '$1';
        $action = '<a href="javascript:void(0)" data-id="$1" id="dlt_expand" class="btn btn-danger btn-sm">Delete</a>';

        $this->load->library('datatables');
        $this->datatables
            ->select('expand.nExpandId, expand.cProfileBio,expand.cCountryName,expand.cSeeking,expand.cHowwebuy')
            ->from('expand')
            ->where('isActive', 1);

        $this->datatables->add_column("Actions", $action, "expand.nExpandId");
        echo $this->datatables->generate();
    }
    public function deleteexpand(){
        $id = $this->input->post('id');
          
        $this->db->where('nExpandId', $id);
        $deleted = $this->db->update('expand', array('isActive' => 0));
    
        if($deleted){
            echo json_encode(['status' => '1', 'message' => 'Expand Delete successfully']);
    
        }else{
            echo json_encode(['status' => '0', 'message' => 'Failed to Delete Expand']);
    
        }
      }
    





   
    public function import()
    {
        
        //  $config['upload_path'] = './uploads/csvfile/';
        // $config['allowed_types'] = 'xlsx|xls';
        // $config['max_size'] = 10000;  // Maximum size for the file

        // $this->upload->initialize($config);

        // if ($this->upload->do_upload('csv_file')) {
        //     // File upload success
        //     $fileData = $this->upload->data();
        //     $filePath = './uploads/csvfile/' . $fileData['file_name'];

        //     // Load the Excel file
        //     $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);

        //     // Convert Excel data into an array
        //     $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        //     // Process the data into MySQL
        //     //$this->Excel_model->insert_data($sheetData);
        //     $expand_id = $this->general_model->insert('expand', $sheetData);

        //     // Redirect or display success message
        //     $this->session->set_flashdata('success', 'Excel Data Imported Successfully');
        //     $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        //     $this->data['user'] = $user;
        //     $this->data['title'] = 'Import Expand';
        //     $this->template->admin_render('admin/expand/import', $this->data);
        // } else {
        //     // File upload failed
        //     $this->session->set_flashdata('error', 'Failed to Upload Excel File');
        //     $this->template->admin_render('admin/expand/import', $this->data);
        // }
    



        // $rules = [
        //  'image' => [
        //  'uploaded[file]',
        //                 'max_size[file,1024]',
        //                 'ext_in[image,csv]',
        //  ],
        // ];
         
        // if (!$this->validate($rules)) {
        //     return view('add', ['validation' => $this->validator]);
        // } else {
        //     $file = $this->request->getFile('file');
        //     if($file){
        //     $newName = $file->getRandomName();
        //     // Store file in public/csvfile/ folder
        //     $file->move('../uploads/csvfile', $newName);
        //     // Reading file
        //     $file = fopen("../uploads/csvfile/".$newName,"r");
        //     $i = 0;
        //     $numberOfFields = 5; // Total number of fields
        //     $importData_arr = array();
        //     while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
        //         $num = count($filedata);
        //         if($i > 0 && $num == $numberOfFields){ 
        //             $importData_arr[$i]['cCountryName'] = $filedata[0];
        //             $importData_arr[$i]['cProfileBio'] = $filedata[1];
        //             $importData_arr[$i]['cSeeking'] = $filedata[2];
        //             $importData_arr[$i]['cHowwebuy'] = $filedata[3];
        //             $importData_arr[$i]['cTimeline'] = $filedata[4];
        //             $importData_arr[$i]['cHowtoReach'] = $filedata[5];
        //             $importData_arr[$i]['cURL'] = $filedata[6];
        //             $importData_arr[$i]['cRequestIntro'] = $filedata[7];
        //             $importData_arr[$i]['cTCSProfile'] = $filedata[8];
        //         }
        //         $i++;
        //     }
        //     fclose($file);
    
        //     $image->move(WRITEPATH . 'uploads');
        //      // Insert data
        //     $count = 0;
        //     foreach($importData_arr as $studentData){
        //     // Check record
        //     $expand = $this->general_model->getOne('expand', array('cCountryName' => $studentData['cCountryName'],'cTCSProfile' => $studentData['cTCSProfile'],'isActive'=>1));
        //     //$checkrecord = $model->where('email',$studentData['email'])->countAllResults();
        //     if($checkrecord == 0){
        //         ## Insert Record
        //         $expand_id = $this->general_model->insert('expand', $studentData);
        //         if($expand_id){
        //             $count++;
        //         }
        //     }
        //     //return redirect()->to( base_url('student') );
        //     }
        //     }else{
        //      echo "File not imported";
        //      }
                        
            //} 
        if (isset($_FILES["csv_file"])) {
            $this->load->library('upload');
            $sheet_data = array_map('str_getcsv', file($_FILES['csv_file']['tmp_name']));

            if (isset($sheet_data[0])) {
                $headings = $sheet_data[0];
                if ($sheet_data) {
                    $expand = array();
                    $message = '';
                    $success = 0; 
                    $login_id = 0; 
                    $error_message =0;
//             echo "<pre>";
// var_dump($sheet_data);
// echo "</pre>";exit;
                    $sheet_data->getStyle('B2:B3')->getAlignment()->setWrapText(true);
                    foreach ($sheet_data as $key => $value) {

                        //print_r($sheet_data);exit;
                        //echo "value=".$value[0].' key='.$key.' '.$value[13].'hello ';
                        if (!empty($value[0]) && $key > 0 && !empty($value[13])) {
                            //echo "hiiiiiiiiiiii".' ';
                            $login_id = $this->general_model->getOne('startup_users', array('email' =>trim($value[0]) ? trim($value[0]) : '',
                                'isActive'=>1));
                            if(!empty($login_id)){
                                $attendee_details = $this->general_model->getOne('attende_details', array('login_id' => $login_id->id,
                                'name' => trim($value[1]) ? trim($value[1]) : '',
                                'isActive'=>1));
                            }
                            // $expand = $this->general_model->getOne('expand', array('cCountryName' => trim($value[0]) ? trim($value[0]) : '',
                            //     'cTCSProfile' => trim($value[8]) ? trim($value[8]) : '',
                            //     'isActive'=>1));
                            //echo $this->db->last_query();exit;
                            $data = array(
                                'email' => trim($value[0])? trim($value[0]) : '',
                                'login_id' =>$login_id->id,
                                'name' => ($value[1])? ($value[1]) : '',
                                'above_name' => ($value[2]) ? ($value[2]) : '',
                                'position' => EncodeUrl($value[3]) ? ($value[3]) : '',
                                'industry' => EncodeUrl($value[4]) ? EncodeUrl($value[4]) : '',
                                'country' => ($value[5]) ? ($value[5]) : '',
                                'created_on' => time(),
                                'isActive' => 1,
                            );
                            $data1 = array(
                                'nUserId'=>$login_id->id,
                                'cCountryName' => ($value[5])? ($value[5]) : '',
                                'cProfileBio' => EncodeUrl($value[6])? EncodeUrl($value[6]) : '',
                                'cSeeking' => EncodeUrl($value[7]) ? EncodeUrl($value[7]) : '',
                                'cHowwebuy' => EncodeUrl($value[8]) ? EncodeUrl($value[8]) : '',
                                'cTimeline' => ($value[9]) ? ($value[9]) : '',
                                'cHowtoReach' => ($value[10]) ? ($value[10]) : '',
                                'cURL' => ($value[11]) ? ($value[11]) : '',
                                'cRequestIntro' => ($value[12]) ? ($value[12]) : '',
                                'cTCSProfile' => trim($value[13]) ? trim($value[13]) : '',
                                'dtPostedDate' => time(),
                                'cPostedBy' => 1,
                                'isActive' => 1,
                            );
                            //print_r($data1);
                            if ($attendee_details) {
                               $error_message .= "Already exist expand details for" . $data['name'] . ". ";
                            }
                            else{
                                $attendee_id = $this->general_model->insert('attende_details', $data);
                                $expand_id = $this->general_model->insert('expand', $data1);
                                if ($expand_id || $attendee_id) {
                                } else {
                                $error_message .= "Failed to insert expand details for" . $data['name'] . ". ";
                                }
                                $success++;
                            }
                            
                        }
                    }
                    //exit;
                    if ($success == 0) {
                        $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    } else {
                        $msg = "Total (" . $success . ") item successfully imported.";
                        if ($message) {
                            $msg .= "<br>" . $message;
                        }
                        $this->session->set_flashdata('message', array('1', $msg));
                       
                    }
                    redirect('admin/expand', 'refresh');
                } else {
                    $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    redirect('admin/expand/', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', array('0', "File is empty or not properly formatted."));
                redirect('admin/expand/', 'refresh');
            }
        }
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->data['title'] = 'Import Expand';
        $this->template->admin_render('admin/expand/import', $this->data);
    }

    
                          
    }