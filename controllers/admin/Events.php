<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Events extends Admin_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $admin_data = $this->session->userdata('admin_data');

        if($admin_data) {
            if (isset($admin_data['id'])) {
                $this->user_id = $admin_data['id'];
            }
        
            
            if (isset($admin_data['user_type'])) {
                $this->user_type = $admin_data['user_type'];
            }
          }

    }

    public function index()
    {
       
        $this->data['title'] = 'Events List';
        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
          $this->data['user'] = $user;
        $this->template->admin_render('admin/events/index', $this->data);
    }
   
    public function getEvents()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select('events.id, events.Title, events.Organizer, events.Location, events.Date, events.Time')
            ->from('events')
            ->where('isActive', 1);
    
            $this->datatables->add_column("Actions", '<a href="" data-id="$1" id="edit" class="btn btn-outline-secondary btn-sm edit">Edit</a><a href="" data-id="$1" id="delete"  class="btn btn-danger btn-sm">Delete</a>', "events.id");
        
        echo $this->datatables->generate();
    }

    public function getEventById(){
        $id = $this->input->post('id');
        $event = $this->general_model->getOne('events',array('id'=>$id));
        echo json_encode($event);
    }
    public function updateEvent()
    {
        
        $data = array(
            'Title'     => $this->input->post('title'),
            'Organizer' => $this->input->post('organizer'),
            'Location'  => $this->input->post('location'),
            'Link'      => $this->input->post('link'),
            'Price'      => $this->input->post('price'),
            'Day'       => $this->input->post('day'),
            'Date'      => $this->input->post('date'),
            'Time'      => $this->input->post('time')
        );
        $this->db->where('id', $this->input->post('id'));
        $updated = $this->db->update('events', $data);
     
        if ($updated) {
            echo json_encode(['status' => '1', 'message' => 'Event Update successfully']);
       
        }else{
            echo json_encode(['status' => '0', 'message' => 'Failed to update event']);
             
        }

     }

     public function deleteEvent(){
        $id = $this->input->post('id');
      
        $this->db->where('id', $id);
        $deleted = $this->db->update('events', array('isActive' => 0));

        if($deleted){
            echo json_encode(['status' => '1', 'message' => 'Event Delete successfully']);

        }else{
            echo json_encode(['status' => '0', 'message' => 'Failed to Delete event']);

        }
       
     }
    public function import()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 10000; // in KB

        $this->upload->initialize($config);

        // Check if file is uploaded successfully
        if (!$this->upload->do_upload('csv_file')) {
            // Show error message
            $error = $this->upload->display_errors();
            echo $error;
        } else {
            // Get the uploaded file data
            $data = $this->upload->data();

            // File path to the uploaded CSV
            $file_path = $data['full_path'];

            // Read the CSV file
            $this->load->library('csvimport');

            $events_details ="";
            if ($this->csvimport->get_array($file_path)) {
                $csv_data = $this->csvimport->get_array($file_path);
                
                $data           = array();
                $data1          = array();
                $success        = 0;
                $error_message  = 0;
//print_r($csv_data);exit;
                foreach ($csv_data as $row) {
                    
                    $events_details = $this->general_model->getOne('events', array('Date' =>$row['Date'],
                        'Day' => $row['Day'],
                        'Title' => $row['Title'],
                        'isActive'=>1));

                        $data[] = array(
                        'Date' => $row['Date'] ,
                        'Day' => $row['Day'],
                        'Link' => $row['Link'],
                        'Image  ' => $row['Image'],
                        'Time' => $row['Time'],
                        'Title' => $row['Title'],
                        'Organizer' => $row['Organizer'],
                        'Location' => $row['Location'],
                        'Price' => $row['Price'],
                        'created_on' => time(),
                        'isActive' => 1,
                        );
               
                }
                // echo "<pre>";
                // var_dump($csv_data);
                // echo "</pre>";
                //exit;

                if ($events_details) {
                   $error_message .= "Already exist events details for";
                }
                else{
                     $events_rows = $this->general_model->insert_batch('events', $data);
                    if ($events_rows) {
                        $msg = "Total (" . $events_rows . ") item successfully imported.";
                        $success++;
                    } else {
                        $error_message .= "Failed to insert events details for";
                    }
                    
                }
                        
            } else {
                $error_message .= "Failed to insert events details for";
            }

            if ($success == 0) {
                $this->session->set_flashdata('message', array('0', "Please import correct file, did not match excel sheet column"));
            } else {
                $msg = "Total (" . $events_rows . ") item successfully imported.";
                if ($message) {
                    $msg .= "<br>" . $message;
                }
                $this->session->set_flashdata('message', array('1', $msg));
               
            }
            redirect('admin/events', 'refresh');
            }

        $user = $this->general_model->getOne('mstuser', array('id' =>  $this->user_id ));
        $this->data['user'] = $user;
        $this->data['title'] = 'Import Events';
        $this->template->admin_render('admin/events/import', $this->data);
    }
}