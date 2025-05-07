<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Startup extends Admin_Controller
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
        $this->data['title']      = 'Startup List';
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
          $this->data['user'] = $user;
        $this->template->admin_render('admin/startup/index', $this->data);
    }

    public function getStartup()
    {
        $action = '$1';
        $action = '<a href="javascript:void(0)" data-id="$1" id="dlt_startup" class="btn btn-danger btn-sm">Delete</a>';

        $this->load->library('datatables');
        $this->datatables
            ->select('startup_details.id, startup_details.name, startup_details.description, startup_details.country, startup_details.sector')
            ->from('startup_details')
            ->where('isActive', 1);

        $this->datatables->add_column("Actions", $action, "startup_details.id");
        echo $this->datatables->generate();
    }
    public function deletestartups(){
        $id = $this->input->post('id');
          
        $this->db->where('id', $id);
        $deleted = $this->db->update('startup_details', array('isActive' => 0));
    
        if($deleted){
            echo json_encode(['status' => '1', 'message' => 'startup Delete successfully']);
    
        }else{
            echo json_encode(['status' => '0', 'message' => 'Failed to Delete startup']);
    
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
                        if (!empty($value[0]) && $key > 0 && !empty($value[8])) {
                            $startup_details = $this->general_model->getOne('startup_details', array('web_scraper_start_url' => trim($value[1])));
                            $data = array(
                                'web_scraper_start_url' => trim($value[1]),
                                'name' => trim($value[2]),
                                'stage' => trim($value[3]) ? trim($value[3]) : '',
                                'description' => trim($value[4]) ? trim($value[4]) : '',
                                'logo_src' => trim($value[5]) ? trim($value[5]) : '',
                                'country' => trim($value[6]) ? trim($value[6]) : '',
                                'sector' => trim($value[7]) ? trim($value[7]) : '',
                                'booth' => trim($value[8]) ? trim($value[8]) : '',
                                'created_on' => time(),
                            );
                            $link = array(
                                'link' => trim($value[9]),
                                'link_href' => trim($value[10]),
                                // 'link_href_orignal' => trim($value[10]),
                                'created_on' => time(),
                            );
                            if ($startup_details) {
                                $link['startup_id'] = $startup_details->id;
                                if ($id = $this->general_model->insert('social_details', $link)) {
                                    $details = $this->general_model->getOne('social_details', array('id' => $id));
                                    // if($details->link == 'Pitch deck'){
                                    //     $this->pitch_deck_download($details->id);
                                    // }
                                }
                               
                            } else {
                                $startup_id = $this->general_model->insert('startup_details', $data);
                                if ($startup_id) {
                                    $link['startup_id'] = $startup_id;
                                    if ($id = $this->general_model->insert('social_details', $link)) {
                                        $details = $this->general_model->getOne('social_details', array('id' => $id));
                                        // if($details->link == 'Pitch deck'){
                                        //     $this->pitch_deck_download($details->id);
                                        // }
                                    }
                               } else {
                                    $error_message .= "Failed to insert startup details for" . $data['name'] . ". ";
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
                        $this->download_logos();
                    }
                    redirect('admin/startup', 'refresh');
                } else {
                    $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    redirect('admin/startup/', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', array('0', "File is empty or not properly formatted."));
                redirect('admin/startup/', 'refresh');
            }
        }
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->data['title'] = 'Import Startup';
        $this->template->admin_render('admin/startup/import', $this->data);
    }

    public function pitch_deck_download()
    {
        $pitch_deck_details = $this->general_model->getAll('social_details', array('id' => 26));
        
        if ($pitch_deck_details) {
            foreach ($pitch_deck_details as $key => $value) {
                //$details = $this->general_model->getOne('social_details', array('id' => $value->id));
                $file_url = $value->link_href;
                $local_path = 'uploads/pitch_deck/';
                $filename = $this->sanitize_file_name($value->id) . $this->getFileExtentionFromUrl($file_url);
                if (empty($filename)) {
                    $filename = $value->id . '.pdf'; 
                }
                $local_filepath = $local_path . $filename;
                $file_content = file_get_contents($file_url);
                if ($file_content !== false) {
                    if (!is_dir($local_path)) {
                        mkdir($local_path, 0777, true);
                    }
                    file_put_contents($local_filepath, $file_content);
                    $update_data = array('link_href' => $local_filepath);
                    $this->general_model->update('social_details', array('id' => $value->id), $update_data);
                    echo "File downloaded and saved locally. Database updated.";
                }
            }
        }
        
    }


    public function getFileExtentionFromUrl($file_url){
        $url = strtok($file_url, '?');
        return pathinfo($url, PATHINFO_EXTENSION);
    }
                          
    public function download_logos()
    {
        $this->load->helper('file');
        $this->load->model('general_model');
        $save_dir = 'E:/uploads/logos/';          
        if (!is_dir($save_dir)) {
            mkdir($save_dir, 0777, true);
        }
        $logos = $this->general_model->get_all_startup_logos();
        $success_count = 0;
        $failure_count = 0;
        foreach ($logos as $logo) {
            $url = $logo['logo_src'];
            $startup_id = $logo['id'];
            if (!empty($url)) {
                $file_name = $this->sanitize_file_name($startup_id) . '.jpg';
                //$file_name = $this->sanitize_file_name(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME)) . '.jpg';
                $local_path = $save_dir . $file_name;
                if ($this->save_image($url, $local_path)) {
                    if ($this->general_model->update_startup_logo_path($startup_id, $local_path)) {
                        $success_count++;
                    } else {
                        $failure_count++;
                    }
                } else {
                    $failure_count++;
                }
            }
        }
        if ($success_count > 0) {
            $message = array('1', 'Logos downloaded and paths updated successfully.');
        } 
        $this->session->set_flashdata('message', $message);
        redirect('admin/startup', 'refresh');
    }

    private function sanitize_file_name($file_name) {
        return preg_replace('/[^A-Za-z0-9_\-]/', '_', $file_name);
    }
    
    private function save_image($url, $save_path)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        $image_data = curl_exec($ch);
        curl_close($ch);
        if ($image_data) {
            $temp_path = $save_path . '_temp';
            file_put_contents($temp_path, $image_data);
            $image = imagecreatefromstring(file_get_contents($temp_path));
            if ($image !== false) {
                imagejpeg($image, $save_path, 100);
                imagedestroy($image);
                unlink($temp_path);
                return true;
            }
            unlink($temp_path);
        }
        return false;
    }
}