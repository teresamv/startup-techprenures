<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Events extends Public_Controller
{
  
   public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');

    }

public function index() {
    if (isset($this->session->userdata('session_user_data')['id']) && $this->session->userdata('session_user_data')['user_type'] == 2) {
        $profile_details =  $this->general_model->getOne('startup_users', array('id' => $this->session->userdata('session_user_data')['id']));
       $attendee_details =  $this->general_model->getOne('attende_details', array('login_id' => $this->session->userdata('session_user_data')['id'], 'isActive' => 1));
   
    if (isset($attendee_details)) {
        $this->session->set_userdata('profile_details', $attendee_details);
      
        $this->data['demo_photo'] = $attendee_details->profile_image_download_path ? $attendee_details->profile_image_download_path : $profile_details->profile_photo;

    } else {
            $this->data['demo_photo'] = $profile_details->profile_photo;
            $this->data['profile_details'] = $profile_details;
      }
    }
    

    $events = $this->general_model->get_all_events();
    $filteredEvents = array_map(function($event) {
        
        if (preg_match('/[a-zA-Z]{3},\s(\w+\s\d+)/', $event->Date, $matches)) {
           
            $dateObject = DateTime::createFromFormat('M j', $matches[1]);
            
            if ($dateObject) {
              
                $event->Date = $dateObject->format('j-M');
            }
        }
        
      
        elseif (preg_match('/(\w+)\s(\d+)/', $event->Date, $matches)) {
            $dateObject = DateTime::createFromFormat('M j', "{$matches[1]} {$matches[2]}");
            
            if ($dateObject) {
               
                $event->Date = $dateObject->format('j-M');
            }
        }
        
        return $event;
    }, $events);
//   echo "<pre>";
//   print_r($events);die;
    $currentDate = new DateTime();
    $currentDateStr = $currentDate->format('j-M'); 
    
   
    
    $filteredEvents = array_filter($events, function($event) use ($currentDate) {
        $eventDateTime = DateTime::createFromFormat('j-M g:i A', "{$event->Date} {$event->Time}");
        return $eventDateTime >= $currentDate;
    });
    
    
    usort($filteredEvents, function($a, $b) {
        $dateA = DateTime::createFromFormat('j-M g:i A', "{$a->Date} {$a->Time}");
        $dateB = DateTime::createFromFormat('j-M g:i A', "{$b->Date} {$b->Time}");
        return $dateA <=> $dateB;
    });
    
    
    $selectedLocation = $this->input->post('location');
    if ($selectedLocation) {
        $filteredEvents = array_filter($filteredEvents, function($event) use ($selectedLocation) {
            return $event->Location === $selectedLocation;
        });
    }
    
    $this->data['events'] = $filteredEvents;
    $this->data['currentDate'] = $currentDateStr;
    $this->data['currentDay'] = $currentDate->format('l'); 
    $this->data['selectedLocation'] = $selectedLocation; 

  
    $locations = array_unique(array_column($events, 'Location'));
    $this->data['locations'] = $locations;
   
    
    $this->template->public_render('public/events/index', $this->data);
}


public function create_event(){
   
    if (!empty($_FILES['event_image']['name'])) {
        $ids = $this->input->post('title') . '.jpg';
        $upload_dir = 'uploads/Events_image/';
        $target_file = $upload_dir . $ids;
        $new_file_tmp = $_FILES['event_image']['tmp_name'];
       move_uploaded_file($new_file_tmp, $target_file);
       
    }
    $event_data = array(
        'Title' => $this->input->post('title'),
        'Organizer' => $this->input->post('organizer'),
        'Location' => $this->input->post('location'),
        'Link' => $this->input->post('link'),
        'Image' => $target_file,
        'Price' => $this->input->post('price'),
        'Day' => $this->input->post('day'),
        'Date' => $this->input->post('date'),
        'Time' => $this->input->post('time')
    );

    $this->general_model->insert('events',$event_data);
    $id = $this->db->insert_id();
    if ($id) {
        $this->session->set_flashdata('message', array('1', "Event created successfully."));
    } else {
        $this->session->set_flashdata('message', array('0', "Failed to create event."));
    }
      redirect('events');
    

}
    
}