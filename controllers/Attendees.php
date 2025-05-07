<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendees extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
        $this->load->library('pagination');
    }

    // public function index()
    // {
        
      
    //     $this->load->library('pagination');
    //     $search = $this->input->get('search');
    //     $type = $this->input->get('type');
    //     $country = $this->input->get('country');
    //     $sector = $this->input->get('sector');
    //     $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
    //     if ($this->input->get('cancel')) {
    //         $search = '';
    //         $country = '';
    //         $type = '';
    //         $sector = '';
    //     }
    //     if (!empty($country) && !is_array($country)) {
    //         $country = [$country];
    //     }
    //     if (!empty($sector) && !is_array($sector)) {
    //         $sector = [$sector];
    //     }



    //     $type_array = array("ALPHA", "BETA", "Attendee", "Investor", "Media", "Partner", "Speaker", "Speaker Guest", "Staff", "Volunteer");
    //     $country_array = array("Albania", "Australia", "Austria", "Brazil", "Cameroon", "Canada", "Cayman Islands", "Colombia", "Costa Rica", "Cote divoire", "Denmark", "Egypt", "Estonia", "Ethiopia", "Finland", "France", "Gambia", "Germany", "Ghana", "Greece", "Hong Kong", "Hungary", "India", "Ireland", "Iraq", "Israel", "Italy", "Japan", "Korea (Republic of)", "Latvia", "Lithuania", "Malaysia", "Mexico", "Morocco", "Netherlands", "Nigeria", "Norway", "Pakistan", "Philippines", "Poland", "Portugal", "Rwanda", "Singapore", "South Africa", "Sri Lanka", "Sweden", "Turkiye", "Türkiye", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Viet Nam",);
    //     $sector_array = array("Advertising, content & marketing", "Agritech & foodtech", "AI & machine learning", "Charities & NGOs", "Data & analytics", "Design", "E-commerce & retail", "Education", "Energy & utilities", "Entertainment & media", "Event management", "Fintech & financial services", "Gaming, VR & AR", "Hardware, robotics & IoT", "Healthtech & wellness", "HR & recruitment", "Industrials, manufacturing & consumer goods", "Legal & professional services", "Lifestyle & fashion", "Mobility, transportation & logistics", "Politics, government & international trade", "Proptech & real estate", "SaaS", "Security", "Social media & networking", "Sports & fitness", "Sustainability & cleantech", "Telecommunications & IT", "Travel & hospitality", "Web3");


    //     $config = array();
    //     $config["base_url"] = base_url('attendees/index');
    //     $config["per_page"] = 12;
    //     $config["uri_segment"] = 3;
    //     $config['use_page_numbers'] = TRUE;
    //     $config['num_links'] = 3;
    //     $config['reuse_query_string'] = true;
    //     $config["total_rows"] = $this->general_model->countAttendees($search, $type, $country, $sector);
    //     $this->pagination->initialize($config);
    //     $offset = ($page - 1) * $config["per_page"];
    //     $random_order = true;
    //     $attendes = $this->general_model->getAttendees($config["per_page"], $offset, $search, $type, $country, $sector, $random_order);
    //     // $this->data['title'] = 'Te';
    //     $this->data['attendes'] = $attendes;
    //     $this->data['total_attendes'] = $config["total_rows"];
    //     $this->data['search'] = $search;
    //     $this->data['countries'] = $country_array;
    //     $this->data['sectors'] = $sector_array;
    //     $this->data['types'] = $type_array;
    //     $user_id = isset($this->session->userdata('session_user_data')['id']) ? $this->session->userdata('session_user_data')['id'] : null;

    //     $profile_details =  $this->general_model->getOne('startup_users', array('id' => $user_id));
    //     $attendee_details =   $this->general_model->getdetails('attende_details',$user_id);
        
    //     if (isset($attendee_details)) {
    //         $this->session->set_userdata('profile_details', $attendee_details);
    //         $this->data['profile_img'] = $attendee_details->profile_image_download_path;


    //     }else{
    //         if(isset($profile_details)){
    //             $this->data['demo_photo'] = $profile_details->profile_photo;
    //             $this->data['profile_details'] = $profile_details;
    //         }
          
    //     }
    //    $this->template->public_render('public/attendees/index', $this->data);
    // }
    public function index()
    {
       
        $this->load->library('pagination');
        $search = $this->input->get('search');
        $type = $this->input->get('type');
        $country = $this->input->get('country');
        $sector = $this->input->get('sector');
        $expertise = $this->input->get('expertise');
        $learnabout = $this->input->get('learnabout');
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        if ($this->input->get('cancel')) {
            $search = '';
            $country = '';
            $type = '';
            $sector = '';
           
        }
        if (!empty($country) && !is_array($country)) {
            $country = [$country];
        }
        if (!empty($sector) && !is_array($sector)) {
            $sector = [$sector];
        }
        if (!empty($expertise) && !is_array($expertise)) {
            $expertise = [$expertise];
        }
        if (!empty($learnabout) && !is_array($learnabout)) {
            $learnabout = [$learnabout];
        }



        $type_array = array("ALPHA", "BETA", "Attendee", "Investor", "Media", "Partner", "Speaker", "Speaker Guest", "Staff", "Volunteer");
        $country_array = array("Albania", "Australia", "Austria", "Brazil", "Cameroon", "Canada", "Cayman Islands", "Colombia", "Costa Rica", "Cote divoire", "Denmark", "Egypt", "Estonia", "Ethiopia", "Finland", "France", "Gambia", "Germany", "Ghana", "Greece", "Hong Kong", "Hungary", "India", "Ireland", "Iraq", "Israel", "Italy", "Japan", "Korea (Republic of)", "Latvia", "Lithuania", "Malaysia", "Mexico", "Morocco", "Netherlands", "Nigeria", "Norway", "Pakistan", "Philippines", "Poland", "Portugal", "Rwanda", "Singapore", "South Africa", "Sri Lanka", "Sweden", "Turkiye", "Türkiye", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Viet Nam",);
        $sector_array = array("Advertising, content & marketing", "Agritech & foodtech", "AI & machine learning", "Charities & NGOs", "Data & analytics", "Design", "E-commerce & retail", "Education", "Energy & utilities", "Entertainment & media", "Event management", "Fintech & financial services", "Gaming, VR & AR", "Hardware, robotics & IoT", "Healthtech & wellness", "HR & recruitment", "Industrials, manufacturing & consumer goods", "Legal & professional services", "Lifestyle & fashion", "Mobility, transportation & logistics", "Politics, government & international trade", "Proptech & real estate", "SaaS", "Security", "Social media & networking", "Sports & fitness", "Sustainability & cleantech", "Telecommunications & IT", "Travel & hospitality", "Web3");
        
    
        $config = array();
        $config["base_url"] = base_url('attendees/index');
        $config["per_page"] = 12;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 3;
        $config['reuse_query_string'] = true;
        $config["total_rows"] = $this->general_model->countAttendees($search, $type, $country, $sector,$expertise,$learnabout);
        $this->pagination->initialize($config);
        $offset = ($page - 1) * $config["per_page"];
        $random_order = true;
        $attendes = $this->general_model->getAttendees($config["per_page"], $offset, $search, $type, $country, $sector, $expertise,$learnabout, $random_order);
        // $this->data['title'] = 'Te';
        
        $this->data['attendes'] = $attendes;
        $this->data['total_attendes'] = $config["total_rows"];
        $this->data['search'] = $search;
        $this->data['countries'] = $country_array;
        $this->data['sectors'] = $sector_array;
        $this->data['types'] = $type_array;
        
       

        $user_id = isset($this->session->userdata('session_user_data')['id']) ? $this->session->userdata('session_user_data')['id'] : null;
        $profile_details =  $this->general_model->getOne('startup_users', array('id' => $user_id));
        $attendee_details =   $this->general_model->getdetails('attende_details', $user_id);
      
    
        if (isset($attendee_details)) {
            $this->session->set_userdata('profile_details', $attendee_details);
            $this->data['profile_img'] =  $attendee_details->profile_image_download_path;
           
        } else {
           
            if (isset($profile_details)) {
                $this->data['demo_photo'] = $profile_details->profile_photo;
                $this->data['profile_details'] = $profile_details;
            }
        }
        $this->template->public_render('public/attendees/index', $this->data);
    }
    
    public function details($id)
    {
        if (isset($this->session->userdata('session_user_data')['id']) && $this->session->userdata('session_user_data')['user_type'] == 2) {
            
           
            $attendee = $this->general_model->getOne('attende_details', array('id' => $id, 'isActive' => 1));
            $profile_details =  $this->general_model->getOne('startup_users', array('id' => $this->session->userdata('session_user_data')['id']));
            $attendee_details =  $this->general_model->getOne('attende_details', array('login_id' => $this->session->userdata('session_user_data')['id'], 'isActive' => 1));
          
            if (isset($attendee_details)) {
                if (!empty($attendee_details->profile_image_download_path)) {
                    $this->data['profile_img'] = $attendee_details->profile_image_download_path;
                } else {
                    $this->data['demo_photo'] = $profile_details->profile_photo;
                }
                $this->session->set_userdata('profile_details', $attendee_details);
               
            }else{
                $this->data['demo_photo'] = $profile_details->profile_photo;
                $this->data['profile_details'] = $profile_details;
            }
            $this->data['profile_details'] = $profile_details;
            $this->data['email'] = $profile_details->email;
            $this->data['startups_names'] = $this->general_model->get_startups();
            
            $this->data['attendee_names'] = $this->general_model->get_attendee();
            if (!empty($attendee)) {
                $this->data['attendee'] = $attendee;
                $this->data['demo_photo'] = $profile_details->profile_photo;
                $this->data['expertise_tag'] = $this->general_model->getAll('expertise_tag', array('attende_id' => $attendee->id));
                $this->data['learn_about_tag'] = $this->general_model->getAll('learn_about_tag', array('attende_id' => $attendee->id));
                $this->data['startup'] = $this->general_model->getOne('startup_details', array('id' => $attendee->startup_id,'isActive'=>1));
                $this->data['title'] = $attendee->name;
                $this->data['user']= $this->session->userdata('session_user_data')['name'];
                $this->data['name']= $attendee->name;
                $this->data['education'] = $this->general_model->getAll('eduction', array('attende_id' => $attendee->id,'isActive'=>1));
                $this->data['experience'] = $this->general_model->getAll('experience', array('attende_id' => $attendee->id,'isActive'=>1));
                $this->data['investment_details'] = $this->general_model->getAll('investment', array('attende_id' => $attendee->id,'isActive'=>1));
                $this->data['social_info'] = $this->general_model->getAll('social_details', array('attende_id' => $attendee->id,'isActive'=>1));
                // echo"<pre>";
                // print_r($this->data['investment_details']);die;
                // $this->data['profile_img']= $attendee->profile_image_download_path;
                $attendeeName = str_replace(' ', '-', $attendee->name);
                $this->data['current_url'] = base_url('techpreneurs/details/' . $attendee->id . '-' . urlencode($attendeeName)); 
                $this->data['country_names'] = $this->general_model->getDistinctValues('attende_details', 'country');
                $this->data['industry_names'] = $this->general_model->getDistinctValues('attende_details', 'industry');
                $this->data['expertise_names'] = $this->general_model->getDistinctValues('expertise_tag', 'expertise');
                $this->data['learnabout_names'] = $this->general_model->getDistinctValues('learn_about_tag', 'tag');
            } else {
                echo "no profile found";
                exit;
              }
                 $this->template->public_render('public/attendees/details', $this->data);
        } else {
            redirect('login/getlogin');  
        }
    }
    public function deleteByAttendeId($attende_id)
    {
        $this->db->where('attende_id', $attende_id);
        $this->db->delete('social_details');
        return $this->db->affected_rows(); // Return the number of affected rows
    }
    // Create profile
    // public function create_account()
    // { 
    
    //     $user_id = isset($this->session->userdata('session_user_data')['id']) ? $this->session->userdata('session_user_data')['id'] : null;
    //     if (empty($user_id)) {
    //         redirect('startups', 'refresh');
    //     }
    //     $profile_details =  $this->general_model->getOne('startup_users', array('id' => $user_id));
       
    //     if (isset($profile_details)) {
    //         $this->data['title'] = $profile_details->name;
    //         $this->data['demo_photo'] = $profile_details->profile_photo;
    //         $this->data['profile_details'] = $profile_details;
    //         $this->data['email'] =$profile_details->email;
    //         $this->data['expertise_names'] = $this->general_model->getDistinctValues('expertise_tag', 'expertise');
    //        $this->data['learnabout_names'] = $this->general_model->getDistinctValues('learn_about_tag', 'tag');

    //     }
    //       $this->template->public_render('public/attendees/create_account', $this->data);
    // }
    public function create_account()
    {
        
        $user_id = 9;
        // $user_id = isset($this->session->userdata('session_user_data')['id']) ? $this->session->userdata('session_user_data')['id'] : null;
        
        if (empty($user_id)) {
            redirect('startups', 'refresh');
        }
        $profile_details =  $this->general_model->getOne('startup_users', array('id' => $user_id));
        $attendee = $this->general_model->getOne('attende_details', array('login_id' => $user_id, 'isActive' => 1));

        if (!empty($attendee)) {
            $this->data['attendee'] = $attendee;
            $this->data['expertise_tag'] = $this->general_model->getAll('expertise_tag', array('attende_id' => $attendee->id,'isActive'=>1));
            $this->data['expertise_names'] = $this->general_model->getDistinctValues('expertise_tag', 'expertise');
            $this->data['learn_about_tag'] = $this->general_model->getAll('learn_about_tag', array('attende_id' => $attendee->id));
            $this->data['education'] = $this->general_model->getAll('eduction', array('attende_id' => $attendee->id,'isActive'=>1));
            $this->data['experience'] = $this->general_model->getAll('experience', array('attende_id' => $attendee->id,'isActive'=>1));
            $this->data['investment_details'] = $this->general_model->getAll('investment', array('attende_id' => $attendee->id,'isActive'=>1));
            $this->data['social_info'] = $this->general_model->getAll('social_details', array('attende_id' => $attendee->id,'isActive'=>1));
            // echo"<pre>";
            // print_r($this->data['social_info']);die;
           
            $this->data['profile_img']= $attendee->profile_image_download_path;
            $attendeeName = str_replace(' ', '-', $attendee->name);
            $this->data['current_url'] = base_url('techpreneurs/details/' . $attendee->id . '-' . urlencode($attendeeName));           
        }
        if (isset($profile_details)) {
            $this->data['title'] = $profile_details->name;
            $this->data['demo_photo'] = $profile_details->profile_photo;

            $this->data['profile_details'] = $profile_details;
            $this->data['email'] = $profile_details->email;
           
            $this->data['expertise_names'] = $this->general_model->getDistinctValues('expertise_tag', 'expertise');
            $this->data['learnabout_names'] = $this->general_model->getDistinctValues('learn_about_tag', 'tag');
            $this->data['startups_names'] = $this->general_model->get_startups();
          
            $this->data['attendee_names'] = $this->general_model->get_attendee();
            $this->data['country_names'] = $this->general_model->getDistinctValues('attende_details', 'country');

           
        }
        $this->template->public_render('public/attendees/create_account', $this->data);
    }
  
//     public function create_profile()
//     {

//         $this->load->library('upload');

//         if ($_POST) {
//         // echo "<pre>";
//         // print_r($_POST);die;
//             $postdata = $this->input->post();


//             $data = array(
//                 'login_id'=>$this->session->userdata('id'),
//                 'name' => $postdata['name'],
//                 'email' => $postdata['email'],
//                 'position' => $postdata['position'],
//                 'about' => $postdata['about'],
//                 'industry' => $postdata['industry'],
//                 'country' => $postdata['country'],
//                 'startup_name' => $postdata['startup_name'],
//                 'startup_country' => $postdata['startup_country']
//             );
//             $this->general_model->insert('attende_details', $data);
//             $attendee_id = $this->db->insert_id();
//             $this->general_model->insert('startup_details', array('login_id'=>$this->session->userdata('id'),'name' => $postdata['startup_name'], 'country' => $postdata['startup_country'], 'sector' => $postdata['industry']));
//             $startup_id = $this->db->insert_id();

//             $startup = $this->general_model->get_startup_by_name($postdata['startup_name']);
//             if ($startup) {
//                 $data = array(
//                    'startup_id' => $startup_id,
//                 );
//                 $this->general_model->update('attende_details', array('id' => $attendee_id), $data);
//             }
//             if (!empty($_FILES['profile_image']['name'])) {
//                 $ids = $attendee_id . '.jpg';
//                 $upload_dir = 'uploads/attendees_profile/';
//                 $target_file = $upload_dir . $ids;
//                 $new_file_tmp = $_FILES['profile_image']['tmp_name'];


//                 move_uploaded_file($new_file_tmp, $target_file);

//                 $img = array(
//                     'profile_image_download_path' => $target_file,
//                 );
//                 $this->general_model->update('attende_details', array('id' => $attendee_id), $img);
//             }
//             if (!empty($_FILES['startup_logo']['name'])) {
//                 $ids = $startup_id . '.jpg';
//                 $upload_dir = 'uploads/logos/';
//                 $target_file = $upload_dir . $ids;
//                 $new_file_tmp = $_FILES['startup_logo']['tmp_name'];


//                 move_uploaded_file($new_file_tmp, $target_file);

//                 $img = array(
//                     'startup_logo' => $target_file,
//                 );
//                 $this->general_model->update('attende_details', array('id' => $attendee_id), $img);
//                 $this->general_model->update('startup_details', array('id' => $startup_id), array('logo_src' => $target_file));
//             }

//             if (!empty($postdata['learn_about'])) {
//                 $learn_about_data = [];
//                 foreach ($postdata['learn_about'] as $learn_about) {
//                     $learn_about_data[] = array(
//                         'attende_id' => $attendee_id,
//                         'tag' => $learn_about,
//                         'created_on' => time()
//                     );
//                 }
//                 $this->general_model->insert_batch('learn_about_tag', $learn_about_data);
//             }
//             if (!empty($postdata['expertise'])) {
//                 $expertise_data = [];
//                 foreach ($postdata['expertise'] as $expertise) {
//                     $expertise_data[] = array(
//                         'attende_id' => $attendee_id,
//                         'expertise' => $expertise,
//                         'created_on' => time()
//                     );
//                 }
//                 $this->general_model->insert_batch('expertise_tag', $expertise_data);
//             }
//             $this->session->set_flashdata('message', array('1', 'Successfully register'));
//             redirect('attendees/details/' . $attendee_id);
//         }
       
//  }
public function complete_profile()
{
    $current_session_data = $this->session->userdata('session_user_data');

    $postdata = $this->input->post();
    
    $full_name = $postdata['firstname'] . ' ' . $postdata['lastname'];

    $data = array(
         'login_id' => $this->session->userdata('session_user_data')['id'],
        //'login_id'=> 6,
        'name' => $full_name,
        'email' => $postdata['email'],
        'descrption' => $postdata['describe'],
        'about' => $postdata['about'],
        'country' => $postdata['country'],
        'mision_vision' => $postdata['mision_vision'],
        'impact_goal' => $postdata['impact_goal'],
        'key_achievement' => $postdata['key_achievement'],
        'short_and_long_goals' => $postdata['short_and_long_goals'],
        'resource_for_growth' => $postdata['resource_for_growth'],
        'track_record' => $postdata['track_record'],
        'metrics_success' => $postdata['metrics_success'],
    );
    $exist = $this->general_model->getOne('attende_details', array('email' => $postdata['email'], 'isActive' => 1));

    if ($exist) {
        
        $this->general_model->update('attende_details',array('email' => $postdata['email']), $data);
        $attendee_id = $exist->id;
        $updated_session_data = array(
            'id' => $current_session_data['id'],
            'name' => $full_name,
            'email' => $current_session_data['email'],
            'token' => $current_session_data['token'],
            'user_type' => $current_session_data['user_type'],
        );
           $this->session->set_userdata('session_user_data', $updated_session_data);
      } else {
        $this->general_model->insert('attende_details', $data);
        $attendee_id = $this->db->insert_id();
    }

    
    $existing_tag = $this->general_model->getall('expertise_tag', array('attende_id' => $attendee_id));
    $existing_tags_array = array();
    foreach ($existing_tag as $tag) {
        $existing_tags_array[$tag->expertise] = $tag;
    }
    // if (isset($postdata['skills'])) {
        $posted_tags = isset($postdata['skills']) ? $postdata['skills'] : [];
        $posted_ids = [];
        foreach ($posted_tags as $tag) {
            if (isset($existing_tags_array[$tag])) {
                $this->general_model->update('expertise_tag', array('id' => $existing_tags_array[$tag]->id), array('expertise' => $tag));
            } else {

                $expertise_data = array(
                    'attende_id' => $attendee_id,
                    'expertise' => $tag,
                    'created_on' => time()
                );
                $this->general_model->insert('expertise_tag', $expertise_data);
                $inserted_expertise_id = $this->db->insert_id();
                $posted_ids[] = $inserted_expertise_id;
            }
        }

        $tags_to_delete = array_diff(array_keys($existing_tags_array), $posted_tags);
        foreach ($tags_to_delete as $tag) {
            $this->general_model->delete('expertise_tag', array('id' => $existing_tags_array[$tag]->id));
        }
    // }

 // learnabout tag
 $existing_tag = $this->general_model->getall('learn_about_tag', array('attende_id' => $attendee_id));
 $existing_tags_array = array();
 foreach ($existing_tag as $tag) {
     $existing_tags_array[$tag->tag] = $tag;
 }
//  if (isset($postdata['learabout'])) {
     $posted_tags = isset($postdata['learabout']) ? $postdata['learabout'] : [];
     $posted_ids = [];
     foreach ($posted_tags as $tag) {
         if (isset($existing_tags_array[$tag])) {
             $this->general_model->update('learn_about_tag', array('id' => $existing_tags_array[$tag]->id), array('tag' => $tag));
         } else {

             $expertise_data = array(
                 'attende_id' => $attendee_id,
                 'tag' => $tag,
                 'created_on' => time()
             );
             $this->general_model->insert('learn_about_tag', $expertise_data);
             $inserted_expertise_id = $this->db->insert_id();
             $posted_ids[] = $inserted_expertise_id;
         }
     }

     $tags_to_delete = array_diff(array_keys($existing_tags_array), $posted_tags);
     foreach ($tags_to_delete as $tag) {
         $this->general_model->delete('learn_about_tag', array('id' => $existing_tags_array[$tag]->id));
     }
//  }
    // experince data


$experienceData = $this->input->post('experienceData');
$update_data = [];
$insert_data = [];
$ids = []; 

if ($experienceData) {
foreach ($experienceData as $experience) {
    $parsedUrl = parse_url($experience['imageSrc']);
        $relativePath = $parsedUrl['path']; 
        
        $relativePath = str_replace('/community/', '', $relativePath);
    $start_date = ($experience['startYear'] && $experience['startMonth'])
        ? $experience['startYear'] . '-' . date('m', strtotime($experience['startMonth'])) . '-01'
        : null;

    $end_date = ($experience['endYear'] && $experience['endMonth'])
        ? $experience['endYear'] . '-' . date('m', strtotime($experience['endMonth'])) . '-01'
        : null;

    
    $exp_data = array(
        'attende_id' => $attendee_id,
        'company_name' => $experience['company'],
        'company_image'=>$relativePath,
        'title' => $experience['title'],
        'role' => $experience['role'],
        'start_date' => $start_date,
        'end_date' => $end_date,
    );

    if (isset($experience['id']) && !empty($experience['id'])) {
        $ids[] = $experience['id'];
        $exp_data['id'] = $experience['id'];
        $update_data[] = $exp_data;
    } else {
        $insert_data[] = $exp_data;
    }
}
if ($ids) {
    $this->general_model->delete_where_not_in('experience', $ids, ['attende_id' => $attendee_id], 'id');
}
if ($update_data) {
    $this->general_model->update_batch('experience', $update_data, 'id');
}
if ($insert_data) {
    $this->general_model->insert_batch('experience', $insert_data);
}
}
  

$educationData = $this->input->post('educationData');
$update_data = [];
$insert_data = [];
$ids = [];

if ($educationData) {
foreach ($educationData as $education) {
    

    $start_date = ($education['startYear'] && $education['startMonth'])
        ? $education['startYear'] . '-' . date('m', strtotime($education['startMonth'])) . '-01'
        : null;

    $end_date = ($education['endYear'] && $education['endMonth'])
        ? $education['endYear'] . '-' . date('m', strtotime($education['endMonth'])) . '-01'
        : null;

    
    $edu_data = array(
        'attende_id' => $attendee_id,
        'university_name' => $education['schoolName'],
        'degree' => $education['degree'],
        'subject' => $education['subject'],
        'start_date' => $start_date,
        'end_date' => $end_date,
    );

    if (isset($education['id']) && !empty($education['id'])) {
        
        $ids[] = $education['id'];
        $edu_data['id'] = $education['id'];
        $update_data[] = $edu_data;
    } else {
        
        $insert_data[] = $edu_data;
    }
}


if ($ids) {
    $this->general_model->delete_where_not_in('eduction', $ids, ['attende_id' => $attendee_id], 'id');
}


if ($update_data) {
    $this->general_model->update_batch('eduction', $update_data, 'id');
}


if ($insert_data) {
    $this->general_model->insert_batch('eduction', $insert_data);
}
}
$investmentData = "";    
// $investmentData = $postdata['investmentData'];

// if ($investmentData) {
// foreach ($investmentData as $invest) {
//     $parsedUrl = parse_url($invest['compnay_image']);
//     $relativePath = $parsedUrl['path']; 
//     $relativePath = str_replace('/community/', '', $relativePath);
//     $invest_data = array(
//         'attende_id' => $attendee_id,
//         'company_name' => $invest['company'],
//         'comapny_image' => $relativePath,
//         'amount' => $invest['amount'],
//         'currency' => $invest['currency'],
//         'equity' => $invest['equity'],
//         'round' => $invest['round'],
//     );

//     if (isset($invest['id']) && !empty($invest['id'])) {
        
//         $this->general_model->update('investment',array('id' => $invest['id']),$invest_data,);
//     } else {
//         $this->general_model->insert('investment', $invest_data);
//     }
// }
// }

   
    function extract_name($url)
    {
        $parsed_url = parse_url($url);
        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';

        $platforms = [
            'linkedin' => 'Linkedin',
            'youtube' => 'YouTube',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'tiktok' => 'TikTok',
            'telegram' => 'Telegram',
            'pinterest' => 'Pinterest',
            'github' => 'github'
        ];

        foreach ($platforms as $key => $value) {
            if (strpos($host, $key) !== false) {
                return $value;
            }
        }

        return '';         
    }

    $socialData = $postdata['socialData'];$socialData = $postdata['socialData'];

    if ($socialData) {
        foreach ($socialData as $social) {
            
            $keyword = extract_name($social['link']);
            $social_data = array(
                'startup_id ' => null,
                'attende_id' => $attendee_id,
                'link' => $keyword,
                'icon_image' => $social['imgSrc'],
                'link_href' => $social['link'],
            );
    
            if (isset($social['id']) && !empty($social['id'])) {
                $this->general_model->update('social_details', array('id' => $social['id']),$social_data);
             } else {
               $this->general_model->insert('social_details', $social_data);
              
             }
        }
       
}
//  echo"<pre>";
//  print_r($exp_data);
// print_r($invest_data);die;
if(isset($postdata['profileImage']) && !filter_var($postdata['profileImage'], FILTER_VALIDATE_URL)){
    $base64String = explode(',', $postdata['profileImage'])[1];
    $imageData = base64_decode($base64String);
    $uploadDir = 'uploads/attendees_profile/';
    $imageFileName =  $attendee_id. '.jpg'; 
    $uploadFile = $uploadDir . $imageFileName;
    $imageSize = getimagesizefromstring($imageData);
    if ($imageSize === false) {
        error_log("The image data is not valid.");
        return;
    }
   
    if (file_exists($uploadFile)) {
        unlink($uploadFile);
        // echo "deleted";die;
    }

    file_put_contents($uploadFile, $imageData);
             
    //   echo $uploadFile;die;
    $updata =array(
        'profile_image_download_path'=>$uploadFile,
    );
    $this->general_model->update('attende_details',array('id' => $attendee_id), $updata,);
  
 }
 //  when not change profie image
 if(isset($postdata['profileImage']) && filter_var($postdata['profileImage'], FILTER_VALIDATE_URL)){
    $imageUrl = $postdata['profileImage'];
    $imageContent = file_get_contents($imageUrl);
    if ($imageContent !== false) {
       
        $uploadDir = 'uploads/attendees_profile/';
        $imageFileName = $attendee_id . '.jpg'; 
        $uploadFile = $uploadDir . $imageFileName;
         file_put_contents($uploadFile, $imageContent);
      $imageSize = getimagesize($uploadFile);
        if ($imageSize === false) {
            error_log("The downloaded image is not valid.");
            return;
        }
      $updata = array(
            'profile_image_download_path' => $uploadFile,
        );
        $this->general_model->update('attende_details', array('id' => $attendee_id), $updata);
  
 }
//  end
 // if(isset($postdata['backgroundImage']) && !filter_var($postdata['backgroundImage'], FILTER_VALIDATE_URL)){
 //    $base64String = explode(',', $postdata['backgroundImage']);
 //    $imagebg = base64_decode($base64String);
  
 //    $uploadDir = 'uploads/background_img/';
 //    $imageFileName =  $attendee_id. '.jpg'; 
 //    $uploadFile = $uploadDir . $imageFileName;
   
 //    $imageSize = getimagesizefromstring($imagebg); 
 //    if ($imageSize === false) {
 //        error_log("The image data is not valid.");
 //        return;
 //    }

 //    file_put_contents($uploadFile, $imagebg);
   
 //    $updata =array(
 //        'background_image'=>$uploadFile,
 //    );
 //    $this->general_model->update('attende_details',array('id' => $attendee_id), $updata,);
 // }         
}
}

 public function get_icon()
 {
      
     $keyword = $this->extract_keyword($this->input->post('link'));

     $social_icon = $this->general_model->getOne('social_icons', array('name' => $keyword));
     if ($social_icon) {
         echo json_encode(array('status' => 'success', 'icon' => $social_icon->icon));
     } else {
         echo json_encode(array('status' => 'error', 'message' => 'Icon not found'));
     }
 }
 private function extract_keyword($url)
 {

     $parsed_url = parse_url($url);
     $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';

     $platforms = [
         'linkedin' => 'Linkedin',
         'youtube' => 'youtube',
         'twitter' => 'twitter',
         'instagram' => 'instagram',
         'facebook' => 'facebook',
         'tiktok' => 'tiktok',
         'telegram' => 'telegram',
         'pinterest  ' => 'pinterest '
     ];
     foreach ($platforms as $key => $value) {
         if (strpos($host, $key) !== false) {
             return $value;
         }
     }
     return null;
 }


 //  Edit & Delete profile

 public function edit_data()
 {
     $data = $this->general_model->getOne($this->input->post('table'), array('id' => $this->input->post('id')));
     
     if ($data) {
         echo json_encode(array('status' => 'success', 'data' => $data));
     } else {
         echo json_encode(array('status' => 'error', 'message' => 'data not found'));
     }
 }

 public function remove_profile()
 {
     $id = $this->input->post('id');
      
     $data = array(
         'isActive' => 0
     );
  $update = $this->general_model->update($this->input->post('table'), array('id' => $id),$data);

     if ($update) {
         echo json_encode(array('status' => 'success', 'message' => 'Record deleted'));
     } else {
          echo json_encode(array('status' => 'error', 'message' => 'Failed to delete record'));
     }
 }


    //  Edit & Delete profile
    

    public function update_data()
    {

        $postData = $this->input->post();
        // echo "<pre>";
        // print_r($_FILES['file']['name']);die;
        if (!empty($_FILES['file']['name'])) {
            $id = $postData['id'] . '.jpg';
            $upload_dir = FCPATH . 'uploads/attendees_profile/';
            $file_path = $upload_dir . $id;

            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $new_file_name = $id;
            $new_file_path = $upload_dir . $new_file_name;

            // Upload new file
            $new_file_tmp = $_FILES['file']['tmp_name'];
            if (move_uploaded_file($new_file_tmp, $new_file_path)) {
                redirect('attendees/details/' . $id);
            } else {
                echo "Failed to upload file.";
            }
        }
        $data = array(

            'name' => $postData['name'],
            'position' => $postData['position'],
            'about' => $postData['about'],
            'country' => $postData['country'],
            'industry' => $postData['industry']
        );
        $this->session->set_userdata('name', $postData['name']);
         $where = array('id' => $postData['id']);
        $this->general_model->update('attende_details', $where, $data);

        //Start  expertise tag update delete
        $existing_tag = $this->general_model->getall('expertise_tag', array('attende_id' => $postData['id']));
        $existing_tags_array = array();
        foreach ($existing_tag as $tag) {
            $existing_tags_array[$tag->expertise] = $tag;
        }
        $posted_tags = $postData['expertise_tag'];
        $posted_ids = [];
        foreach ($posted_tags as $tag) {
            if (isset($existing_tags_array[$tag])) {

                $this->general_model->update('expertise_tag', array('id' => $existing_tags_array[$tag]->id), array('expertise' => $tag));
            } else {

                $expertise_data = array(
                    'attende_id' => $postData['id'],
                    'expertise' => $tag,
                    'created_on' => time()
                );
                $this->general_model->insert('expertise_tag', $expertise_data);
                $inserted_expertise_id = $this->db->insert_id();
                $posted_ids[] = $inserted_expertise_id;
            }
        }

        $tags_to_delete = array_diff(array_keys($existing_tags_array), $posted_tags);
        foreach ($tags_to_delete as $tag) {
            $this->general_model->delete('expertise_tag', array('id' => $existing_tags_array[$tag]->id));
        }
        // end expertise tag


        //Start learn about tag update delete
        $existing_learnabout = $this->general_model->getAll('learn_about_tag', array('attende_id' => $postData['id']));

        $existing_ltags_array = array();
        foreach ($existing_learnabout as $tag) {
            $existing_ltags_array[$tag->tag] = $tag;
        }
        $posted_tags = $postData['learn_about_tag'];
        $inserted_ids = [];
        $deleted_ids = [];
        foreach ($posted_tags as $tag) {
            if (isset($existing_ltags_array[$tag])) {
                $this->general_model->update('learn_about_tag', array('id' => $existing_ltags_array[$tag]->id), array('tag' => $tag));
            } else {
                $learnabout_data = array(
                    'attende_id' => $postData['id'],
                    'tag' => $tag,
                    'created_on' => time()
                );
                $this->general_model->insert('learn_about_tag', $learnabout_data);
                $inserted_ids[] = $this->db->insert_id();
            }
        }

        $tags_to_delete = array_diff(array_keys($existing_ltags_array), $posted_tags);
        if (!empty($tags_to_delete)) {
            foreach ($tags_to_delete as $tag) {
                $this->general_model->delete('learn_about_tag', array('id' => $existing_ltags_array[$tag]->id));
                $deleted_ids[] = $existing_ltags_array[$tag]->id;
            }
        }
        redirect('Attendees/details/' . $postData['id']);
        $response = array('status' => 1, 'message' => 'profile update successfully.');
        echo json_decode($response);
    }
    public function clam_profile(){
        $this->general_model->update('attende_details', array('id' => $this->input->post('id')), array('claim_profile' => 1));
        echo json_encode(array('status' => 'success'));
     }
     public function submit_report()
     {
         $session_user_data = $this->session->userdata('session_user_data');
        $data = array(
             'name' => isset($session_user_data['name']) ? $session_user_data['name'] : null,
             'login_id' => isset($session_user_data['id']) ? $session_user_data['id'] : null,
             'claim_profile_id' => $this->input->post('id'),
             'request_msg' => $this->input->post('issue'),
         );
         
          $this->general_model->insert('claim_report', $data);
        
 
     }
 
    public function delete_profile($id)
    {
        $this->general_model->delete_profile('attende_details', $id, true);
        $this->session->unset_userdata('profile_details');

        redirect('startups');
    }
    
}
