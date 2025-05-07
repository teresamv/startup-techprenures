<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Attendes extends Admin_Controller
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
        $this->data['title'] = 'Techpreneurs List';
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->template->admin_render('admin/attendes/index', $this->data);
    }

    public function getAttende()
    {
        $action = '$1';
        $action = '<a href="javascript:void(0)" data-id="$1" id="dlt_attendee" class="btn btn-danger btn-sm">Delete</a>';

        $this->load->library('datatables');
        $this->datatables
            ->select('attende_details.id, attende_details.name, attende_details.position, attende_details.industry, attende_details.country')
            ->from('attende_details')
            ->where('isActive', 1);

        $this->datatables->add_column("Actions", $action, "attende_details.id");
        echo $this->datatables->generate();
    }
    public function deleteattendee(){
        $id = $this->input->post('id');
          
        $this->db->where('id', $id);
        $deleted = $this->db->update('attende_details', array('isActive' => 0));
    
        if($deleted){
            echo json_encode(['status' => '1', 'message' => 'techpreneurs Delete successfully']);
    
        }else{
            echo json_encode(['status' => '0', 'message' => 'Failed to Delete techpreneurs']);
    
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
                    $attende = array();
                    $message = '';
                    $success = 0;   
                    foreach ($sheet_data as $key => $value) {
                        if (!empty($value[0]) && $key > 0 && !empty($value[4])) {
                            $startup_id = 0;
                            if (isset($value[10]) && !empty($value[10])) {
                                $startup_name = trim($value[10]);
                                $startup = $this->general_model->get_startup_by_name($startup_name);
                                if ($startup) {
                                    $startup_id = $startup['id'];
                                }
                            }
                            $data = array(
                                'startup_id'            => $startup_id,
                                'web_scraper_start_url' => isset($value[1]) ? trim($value[1]) : '',
                                'above_name'            => isset($value[2]) ? trim($value[2]) : '',
                                'email'                 => isset($value[3]) ? trim($value[3]) : '',
                                'name'                  => trim($value[4]),
                                'position'              => isset($value[5]) ? trim($value[5]) : '',
                                'industry'              => isset($value[6]) ? trim($value[6]) : '',
                                'about'                 => isset($value[7]) ? trim($value[7]) : '',
                                'country'               => isset($value[8]) ? trim($value[8]) : '',
                                'profile_image'         => isset($value[9]) ? trim($value[9]) : '',
                                'startup_name'          => isset($value[10]) ? trim($value[10]) : '',
                                'startup_country'       => isset($value[11]) ? trim($value[11]) : '',
                                'startup_logo'          => isset($value[12]) ? trim($value[12]) : '',
                                'startup_page_link'     => isset($value[13]) ? trim($value[13]) : '',
                                'startup_page_link_href' => isset($value[14]) ? trim($value[14]) : '',
                                'created_on'            => time(),
                            );
                            if ($id = $this->general_model->insert('attende_details', $data)) {
                                for ($i = 15; $i <= 21; $i++) {
                                    if (isset($value[$i]) && !empty($value[$i])) {
                                        $expertise_tag = array(
                                            'attende_id' => $id,
                                            'expertise'  => trim($value[$i]),
                                            'created_on' => time(),
                                        );
                                        $this->general_model->insert('expertise_tag', $expertise_tag);
                                    }
                                }
                                for ($i = 22; $i <= 31; $i++) {
                                    if (isset($value[$i]) && !empty($value[$i])) {
                                        $learn_about_tag = array(
                                            'attende_id' => $id,
                                            'tag'        => trim($value[$i]),
                                            'created_on' => time(),
                                        );
                                        $this->general_model->insert('learn_about_tag', $learn_about_tag);
                                    }
                                }
                                $success++;
                            }
                        }
                    }
                    if ($success == 0) {
                        $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    } else {
                        $msg = "Total (" . $success . ") item(s) successfully imported.";
                        if ($message) {
                            $msg .= "<br>" . $message;
                        }
                        $this->session->set_flashdata('message', array('1', $msg));
                    }
                    redirect('admin/attendes', 'refresh');
                } else {
                    $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
                    redirect('admin/attendes/', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', array('0', "File is empty or not properly formatted."));
                redirect('admin/attendes/', 'refresh');
            }
        }
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->data['title'] = 'Import Attende';
        $this->template->admin_render('admin/attendes/import', $this->data);
    }

    public function download_logos() {
        $attende_details = $this->general_model->get_all_attendee_logos();
        $save_dir = 'E:/uploads/attendees_profile/'; 
        if (!is_dir($save_dir)) {
            mkdir($save_dir, 0777, true);
        }
        $success_count = 0;
        $failure_count = 0;
        $error_details = [];
        foreach ($attende_details as $attende) {
            $url = $attende['profile_image'];
            $id = $attende['id'];
            $file_name = $this->sanitize_file_name($id) . '.jpg';
            $local_path = $save_dir . $file_name;

            if (!empty($url) && $this->save_image($url, $local_path)) {
                if ($this->general_model->update_attendee_logo_path($id, $local_path)) {
                    $success_count++;
                } else {
                    $failure_count++;
                    $error_details[] = "Failed to update database for ID: $id";
                }
            } else {
                $failure_count++;
                $error_details[] = "Failed to download image for ID: $id, URL: $url";
            }
        }

        if ($success_count > 0) {
            $message = array('1', 'Logos downloaded and paths updated successfully.');
        } else {
            $message = array('0', 'Failed to download or update logos.');
            if (!empty($error_details)) {
                $message[1] .= '<br>' . implode('<br>', $error_details);
            }
        }
        $this->session->set_flashdata('message', $message);
        redirect('admin/attendes', 'refresh');
    }

    private function sanitize_file_name($file_name) {
        return preg_replace('/[^A-Za-z0-9_\-]/', '_', $file_name);
    }

    private function save_image($url, $save_path) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $image_data = curl_exec($ch);
        curl_close($ch);
        if ($image_data) {
            $temp_path = $save_path . '_temp';
            if (file_put_contents($temp_path, $image_data)) {
                $image = imagecreatefromstring(file_get_contents($temp_path));
                if ($image !== false) {
                    imagejpeg($image, $save_path, 100);
                    imagedestroy($image);
                    unlink($temp_path);
                    return true;
                }
                unlink($temp_path);
            }
        }
        return false;
    }

}