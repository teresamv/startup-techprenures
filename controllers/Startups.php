<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . '/third_party/PHPMailer/PHPMailerAutoload.php';


class Startups extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
    }

    public function index()
    {
        $this->load->library('pagination');

        $search = $this->input->get('search');
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
        $type_array = array("ALPHA", "BETA", "GROWTH",);
        $country_array = array("Albania", "Australia", "Austria", "Brazil", "Cameroon", "Canada", "Cayman Islands", "Colombia", "Costa Rica", "Cote divoire", "Denmark", "Egypt", "Estonia", "Ethiopia", "Finland", "France", "Gambia", "Germany", "Ghana", "Greece", "Hong Kong", "Hungary", "India", "Ireland", "Iraq", "Israel", "Italy", "Japan", "Korea (Republic of)", "Latvia", "Lithuania", "Malaysia", "Mexico", "Morocco", "Netherlands", "Nigeria", "Norway", "Pakistan", "Philippines", "Poland", "Portugal", "Rwanda", "Singapore", "South Africa", "Sri Lanka", "Sweden", "Turkiye", "Türkiye", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Viet Nam",);
        $sector_array = array("Advertising, content & marketing", "Agritech & foodtech", "AI & machine learning", "Charities & NGOs", "Data & analytics", "Design", "E-commerce & retail", "Education", "Energy & utilities", "Entertainment & media", "Event management", "Fintech & financial services", "Gaming, VR & AR", "Hardware, robotics & IoT", "Healthtech & wellness", "HR & recruitment", "Industrials, manufacturing & consumer goods", "Legal & professional services", "Lifestyle & fashion", "Mobility, transportation & logistics", "Politics, government & international trade", "Proptech & real estate", "SaaS", "Security", "Social media & networking", "Sports & fitness", "Sustainability & cleantech", "Telecommunications & IT", "Travel & hospitality", "Web3");


        $config = array();
        $config["base_url"] = base_url() . "startups/index";
        $config["per_page"] = 12;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 3;
        $config['reuse_query_string'] = true;
        $config["total_rows"] = $this->general_model->countStartup($search, $country, $type, $sector);
        $this->pagination->initialize($config);
        $offset = ($page - 1) * $config["per_page"];
        $random_order = true;
        $startups = $this->general_model->getStartupFilter($config["per_page"], $offset, $search, $country, $type, $sector, $random_order);
        // $this->data['title'] = 'Startups';
        $this->data['startup'] = $startups;
        $this->data['total_startup'] = $config["total_rows"];
        $this->data['search'] = $search;
        $this->data['countries'] = $country_array;
        $this->data['sectors'] = $sector_array;
        $this->data['types'] = $type_array;
        $this->data['startups_names'] = '';
        $this->data['country_names'] = $this->general_model->getCountry('startup_details');
        
        // $user_id = isset($this->session->userdata('session_user_data')['id']) ? $this->session->userdata('session_user_data')['id'] : null;

        $user_id = 6;
        

        $attendee_details =  $this->general_model->getOne('attende_details', array('login_id' => $user_id,'isActive'=> 1));
        $this->data['attendee_details'] = $attendee_details;
        $profile_details = $this->general_model->getOne('startup_users', array('id' => $user_id)) ;
        // print_r($startups_details);die;
        $current_uri = $this->uri->uri_string();
         if ($current_uri == 'startups') {
            if (!empty($attendee_details->profile_image_download_path)) {
                $this->data['profile_img'] = $attendee_details->profile_image_download_path;
                $this->session->set_userdata('profile_details', $attendee_details);
            } else {
                
                if(isset($profile_details)){
                    $this->data['demo_photo'] = $profile_details->profile_photo;
                    $this->data['profile_details'] = $profile_details;
                    }
            }
        }
        if (isset($startups_details)) {
            $this->session->set_userdata('profile_details_startups', $startups_details);
            $this->data['profile_img'] = $startups_details->logo_src;

        }
           else {
            if(isset($profile_details)){
            $this->data['demo_photo'] = $profile_details->profile_photo;
            $this->data['profile_details'] = $profile_details;
            }
            
        }
        $this->data['sector_names'] = $this->general_model->getDistinctValues('startup_details', 'sector');

        $this->template->public_render('public/startups/index', $this->data);
    }


    public function details($id) {
       
        // if (isset($this->session->userdata('session_user_data')['id']) && $this->session->userdata('session_user_data')['user_type'] == 2) {
            
          //code added by sonia for startup add purpose
            $login_id = 6;
            $startup_details   = $this->general_model->getOne('startup_details', array('id' => $id, 'isActive' => 1));
            // $profile_details =  $this->general_model->getOne('startup_users', array('id' => $this->session->userdata('session_user_data')['id']));
            // $startups_details =  $this->general_model->getOne('startup_details', array('login_id' => $this->session->userdata('session_user_data')['id']));
            // $attendee_details =  $this->general_model->getOne('attende_details', array('login_id' => $this->session->userdata('session_user_data')['id'],'isActive'=>1));
             $profile_details =  $this->general_model->getOne('startup_users', array('id' => $login_id));
            $startups_details =  $this->general_model->getOne('startup_details', array('login_id' => $login_id));
            $attendee_details =  $this->general_model->getOne('attende_details', array('login_id' => $login_id,'isActive'=>1));

            $current_uri = $this->uri->uri_string();
            if ($current_uri == 'startups/details/') {
                $this->data['profile_img'] = $startups_details->logo_src;
            } else {
                if (!empty($attendee_details->profile_image_download_path)) {
                    $this->data['profile_img'] = $attendee_details->profile_image_download_path;
                    $this->session->set_userdata('profile_details', $attendee_details);
                } else {
                    $this->data['demo_photo'] = $profile_details->profile_photo;
                    $this->data['profile_details'] = $profile_details;
                }
            }
        if (isset($startups_details)) {
            $this->session->set_userdata('profile_details_startups', $startups_details);
        } else {
            $this->data['demo_photo'] = $profile_details->profile_photo;
            $this->data['profile_details'] = $profile_details;
        }
                    if (!empty($startup_details)) {
                $social_details = $this->general_model->getAll('social_details', array('startup_id' => $startup_details->id,'isActive'=>1));
                
                $social_detail = array_filter($social_details, function ($item) {
                    return $item->link !== 'Pitch deck' && !empty($item->link);
                });
                $this->data['social_details']   = $social_details;
                $this->data['attende_details']   = $this->general_model->getAll('attende_details', array('startup_id' => $startup_details->id));
                $this->data['startup_details'] = $startup_details;
                //print_r($this->data['social_details']);

                foreach ($social_detail as $detail) {
                    if ($detail->icon_id != 0) {
                        $icon_detail = $this->general_model->getAll('social_icons', array('id' => $detail->icon_id));
                        if (!empty($icon_detail)) {
                            $this->data['icon_details'][] = $icon_detail[0];
                        }
                    }
                }
                $this->data['title'] = $startup_details->name;
                $this->data['stage_names'] = $this->general_model->getDistinctValues('startup_details', 'stage');
                $this->data['sector_names'] = $this->general_model->getDistinctValues('startup_details', 'sector');
                $this->data['booth_names'] = $this->general_model->getDistinctValues('startup_details', 'booth');
                $this->data['social_names'] = $this->general_model->getDistinctValues('social_icons', 'name');
                $this->data['startups_names'] ='';
                $this->data['country_names'] = $this->general_model->getCountry('startup_details');

                $sector_array = array("Consumer Goods","Data & Analytics","Privacy & Security","IaaS","SaaS","Biotech","Gaming,Transportation","E-Commerce","Hardware","Marketplaces","No Target","Real Estate","Healthcare","Social / Communities","Advertising & Media","Manufacturing,Food & Beverages","Natural Resources","Future of Work","FoodTech,Sales & Marketing","Education,Web3 / Blockchain","Agriculture & Farming","Privacy &Energy","AI/ML","Government","Marketplace","Travel & Tourism","Social & Communities","Financial Services & Payments","CleanTech & Impact & Sustainability","Mental Health","Aging","Technology","Investment Focus");
                $this->data['funding_list'] = $this->general_model->getFundingStartup_category($startup_details->sector,$sector_array);
                //print_r($this->data['funding_list']);exit;
            } else {
                echo 'profile not found';
                exit;
            }
            $this->template->public_render('public/startups/details', $this->data);
        // } else {
        //      redirect('login/getlogin');      
        //    }
    }

    public function insert_startups(){
        
        $postdata = $this->input->post();
        // exit;
        $attendee_id = $postdata['id'];
    
        // Prepare data
        $data = array(
            'name' => $postdata['title'],
            'description' => $postdata['description'],
            'stage' => $postdata['stage'],
            'country' => $postdata['country'],
            'sector' => $postdata['sector'],
            'booth' => $postdata['booth'],
        );
    
        // Check if record exists
        $exist = $this->general_model->getOne('startup_details', array('name' => $postdata['title']));
        if ($exist) {
            // Update existing record
            $this->general_model->update('attende_details', array('id' => $attendee_id), array('startup_id' => $exist->id));
            $title_slug = str_replace(' ', '-', $postdata['title']);
            
            // Output response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'redirect' => base_url('startups/details/' . $exist->id . '-' . $title_slug)
            ]);
            return;
        }
    
        // Insert new record
        $this->general_model->insert('startup_details', $data);
        $id = $this->db->insert_id();
        $this->general_model->update('attende_details', array('id' => $attendee_id), array('startup_id' => $id));
        
        // Handle file uploads
        if (isset($_FILES['startupimage']) && !empty($_FILES['startupimage']['tmp_name'])) {
            $ids = $id . '.jpg';
            $upload_dir = 'uploads/logos/';
            $target_file = $upload_dir . $ids;
            $new_file_tmp = $_FILES['startupimage']['tmp_name'];
        
            if (move_uploaded_file($new_file_tmp, $target_file)) {
                $img = array('logo_src' => $target_file);
                $this->general_model->update('startup_details', array('id' => $id), $img);
            } 
        }
    
        if (isset($_FILES['pitchdeck']) && !empty($_FILES['pitchdeck']['tmp_name'])) {
            $upload_dir = "uploads/pitch_deck/";
            $file_name = $postdata['title'];
            $file_tmp = $_FILES["pitchdeck"]["tmp_name"];
            $file_extension = pathinfo($_FILES['pitchdeck']['name'], PATHINFO_EXTENSION);
            $target_file = $upload_dir . $file_name . '.' . $file_extension;
            
            if (move_uploaded_file($file_tmp, $target_file)) {
                $data = array(
                    'startup_id' => $id,
                    'link' => 'Pitch deck',
                    'file' => $target_file,
                );
                $this->general_model->insert('social_details', $data);
            }
        }
    
        $social_links = $postdata['social_links'];
        $base_url = base_url();
        if (!empty($social_links)) {
            foreach ($social_links as $platform => $details) {
                $relative_icon_path = str_replace($base_url, '', $details['icon']);
                $data = [
                    'startup_id' => $id,
                    'link' => $details['name'],
                    'link_href' => $details['url'],
                    'icon_image' => $relative_icon_path,
                ];
                $this->general_model->insert('social_details', $data);
            }
        }
    
        // Output response
        $title_slug = str_replace(' ', '-', $postdata['title']);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'redirect' => base_url('startups/details/' . $id . '-' . $title_slug)
        ]);
    }
    
    public function send_email($id) {
        $this->load->helper('url');
        $attendees = $this->general_model->getAll('attende_details', array('startup_id' => $id));
       
        if (isset($attendees) && !empty($attendees)) {
            $attendee = $attendees[0];
            $startup = $this->general_model->getOne('startup_details', array('id' => $attendee->startup_id));
            $startupName = $startup->name;
            $message = '<p>Dear ' . htmlspecialchars($startupName).',</p>
                <p>We wanted to inform you that someone has downloaded the pitch deck documents from your startup.</p>
                <p>If you didn\'t authorize this, please feel free to contact our support team for further assistance.</p>
                <p>Thank you for using our platform!</p>
                <br>
                <p>Best regards,</p>
                <p>techpreneurs community</p>';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host       = 'ssl://smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->SMTPDebug = false;
            $mail->Username   = 'vite.ravi26@gmail.com';
            $mail->Password   = 'rglvkxokkmnjciud'; 
            $mail->Port       = 465;
            $mail->setFrom('vite.ravi26@gmail.com', 'Your Name');
            $mail->isHTML(true);
            $mail->Subject    = 'Pitch Deck Download Notification';
            $mail->Body       = $message;
            
    
            $email_addresses = array();
            foreach ($attendees as $attendee) {
                $email = $attendee->email;
                if (!in_array($email, $email_addresses)) {
                    $email_addresses[] = $email;
                    $mail->addAddress($email);
                }
            }
    
            if ($mail->send()) {
                redirect('startups/details/' . $id);
            } else {
               echo 'Failed to send email. Error: ' . $mail->ErrorInfo;
            }
        } else {
            redirect('startups/details/' . $id);
        }
    }
    

    //     public function send_email($id)
    // {
        
    //     $attendees = $this->general_model->getAll('attende_details', array('startup_id' => $id));
     
    //     if (isset($attendees) && !empty($attendees)) {
    //         $this->load->config('email');
    //         $this->load->library('email');
    //         ini_set('SMTP', 'smtp.gmail.com');
    //         ini_set('smtp_port', '465');
    //         ini_set('sendmail_from', 'vite.ravi26@gmail.com');
    //         $from = 'vite.ravi26@gmail.com';
    //         $subject = 'Pitch deck';
    //         $message = 'someone download pitch deck document from your startups';
    //         $this->email->set_newline("\r\n");
    //         $this->email->from($from);
    //         $this->email->subject($subject);
    //         $this->email->message($message);

    //         $email_addresses = array();
    //         foreach ($attendees as $attendee) {
    //             $email = $attendee->email;
    //             if (!in_array($email, $email_addresses)) {
    //                 $email_addresses[] = $email;
    //             }
    //         }
            
    //         foreach ($email_addresses as $email) {
    //             $this->email->to($email);
    //          }
    //         if ($this->email->send()) {
    //           redirect('startups/details/' . $id);
    //         } else {
    //              echo 'Failed to send email to ' . $to . '<br>';
    //              show_error($this->email->print_debugger());
    //          }
    //     }else{
    //         redirect('startups/details/' . $id);
    //     }
    // }
    //   public function create_profile()
    // {
    //     $user_id =$this->session->userdata('userdata','id');
    //     $profile_details =  $this->general_model->getOne('startup_users', array('id' => $user_id));
    //     $user_full_name = $this->session->userdata('userdata','name');
    //     $full_name_arr = explode(" ", $user_full_name);
    //     $full_name_arr_end = end($full_name_arr);
    //     $firstWord = !empty($full_name_arr[0]) ? $full_name_arr[0] : '';
    //     $lastWord = !empty($full_name_arr_end[0]) ? $full_name_arr_end[0] : '';
    //     $charF = !empty(mb_substr($firstWord, 0, 1)) ? mb_substr($firstWord, 0, 1) : '';
    //     $this->data['demo_photo'] = $charF;
    //     $this->data['profile_details'] = $profile_details;

    //     $this->load->library('upload');
    //     if ($_POST) {
    //         $postdata = $this->input->post();

    //         $data = array(
    //             'name' => $postdata['name'],
    //             'description' => $postdata['description'],
    //             'stage' => $postdata['stage'],
    //             'country' => $postdata['country'],
    //             'sector' => $postdata['sector'],
    //             'booth' => $postdata['booth'],
    //         );
    //         $this->general_model->insert('startup_details', $data);
    //         $id = $this->db->insert_id();
    //         if (!empty($_FILES['logo']['name'])) {
    //             $ids = $id . '.jpg';
    //             $upload_dir = 'uploads/logos/';
    //             $target_file = $upload_dir . $ids;
    //             $new_file_tmp = $_FILES['logo']['tmp_name'];


    //             move_uploaded_file($new_file_tmp, $target_file);

    //             $img = array(
    //                 'logo_src' => $target_file,
    //             );
    //             $this->general_model->update('startup_details', array('id' => $id), $img);
    //         }
    //         $social_names = $postdata['social_name'];
    //         $social_urls = $postdata['social_url'];

    //         if (!empty($social_names) || !empty($social_urls)) {
    //             $icon_ids = $this->general_model->get_icon_ids_by_names($social_names);
    //             $social_details = [];
    //             foreach ($social_names as $index => $social_name) {

    //                 if (isset($icon_ids[$social_name])) {
    //                     $social_details[] = array(
    //                         'startup_id' => $id,
    //                         'icon_id' => $icon_ids[$social_name],
    //                         'link' => $social_name,
    //                         'link_href' => $social_urls[$index],
    //                         'created_on' => date('Y-m-d H:i:s')
    //                     );
    //                 }
    //             }
    //             $this->general_model->insert_batch('social_details', $social_details);
    //         }
    //         redirect('startups/details/' . $id);
    //     }
    //     $this->data['title'] = $this->session->userdata('userdata','name');
    //     $this->data['social_names'] = $this->general_model->getDistinctValues('social_icons', 'name');
    //     $this->template->public_render('public/startups/create_profile', $this->data);
    // }

    public function edit_startup ($id){
        if (isset($this->session->userdata('session_user_data')['id']) && $this->session->userdata('session_user_data')['user_type'] == 2) {
            $startup_details   = $this->general_model->getOne('startup_details', array('id' => $id, 'isActive' => 1));
           $attendee_details=  $this->general_model->getOne('attende_details', array('login_id' => $this->session->userdata('session_user_data')['id'], 'isActive' => 1));
       if(!empty($attendee_details)){
        $this->data['profile_img'] = $attendee_details->profile_image_download_path;
       }
        if (!empty($startup_details)) {
                $social_details = $this->general_model->getAll('social_details', array('startup_id' => $startup_details->id,'isActive'=>1));
                       
                       $social_detail = array_filter($social_details, function ($item) {
                           return $item->link !== 'Pitch deck' && !empty($item->link);
                       });
                      
                    }
                    $this->data['sector_names'] = $this->general_model->getDistinctValues('startup_details', 'sector');
                    $this->data['social_details']   = $social_details;
                    $this->data['startup_details']   = $startup_details;
                    $this->data['startups_names'] ='';
                    $this->template->public_render('public/startups/edit', $this->data);
        }else{
            redirect('login/getlogin');
        }
        
    }
    public function edit_profile()
    {
        $postdata = $this->input->post(); 

       
           if (!empty($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['tmp_name'])) {
                $ids = $postdata['id'] . '.jpg';
                $upload_dir = 'uploads/logos/';
                $target_file = $upload_dir . $ids;
                $new_file_tmp = $_FILES['profile_image']['tmp_name'];
                move_uploaded_file($new_file_tmp, $target_file);
                $update_data = array(
                    'logo_src' => $target_file,
                );
                $this->general_model->update('startup_details', array('id' => $postdata['id']), $update_data);
            }
    
            $update_data = array(
                'name' => $postdata['name'],
                'description' => $postdata['description'],
                'stage' => $postdata['stage'],
                'country' => $postdata['country'],
                'sector' => $postdata['sector'],
                'booth' => $postdata['booth'],
            );
            //var_dump($update_data);exit;
            $this->general_model->update('startup_details', array('id' => $postdata['id']), $update_data);
    
            if ($_FILES && isset($_FILES['pitchdeck']) && !empty($_FILES['pitchdeck']['tmp_name'])) {
                $upload_dir = "uploads/pitch_deck/";
                $file_name = $postdata['name'];
                $file_tmp = $_FILES["pitchdeck"]["tmp_name"];
                $file_extension = pathinfo($_FILES['pitchdeck']['name'], PATHINFO_EXTENSION);
                $target_file = $upload_dir . $file_name . '.' . $file_extension;
                $old_file = $upload_dir . $postdata['name'] . '.pdf';
                if (file_exists($old_file)) {
                    unlink($old_file); 
                }
                if (move_uploaded_file($file_tmp, $target_file)) {
                    $insert_data = array(
                        'startup_id'=>$postdata['id'],
                        'link'=> 'Pitch deck', 
                        'file' => $target_file,
                    );
                   
                    $existt = $this->general_model->getOne('social_details', array('startup_id' => $postdata['id'], 'link' => 'Pitch deck'));
                      if($existt){
                        $this->general_model->update('social_details', array('startup_id' =>$existt->id), array('file'=>$target_file));
                      }else{
                        $this->general_model->insert('social_details',  $insert_data);
                        }

                }
            }
    
           
            $socialData = isset($postdata['socialData']) ? json_decode($postdata['socialData'], true) : [];
    
            if ($socialData) {
                foreach ($socialData as $social) {
                     $social_data = array(
                        'startup_id' => $postdata['id'],
                        'link' => $social['name'],
                        'icon_image' => $social['icon'],
                        'link_href' => $social['url'],
                    );
    
                    if (isset($social['id']) && !empty($social['id'])) {
                        $this->general_model->update('social_details', array('id' => $social['id']), $social_data);
                    } else {
                        $this->general_model->insert('social_details', $social_data);
                    }
                }
              }
        $title_slug = str_replace(' ', '-', $postdata['name']);
        header('Content-Type: application/json');
           echo json_encode([
               'success' => true,
               'redirect'=>base_url('startups/details/' . $postdata['id'] . '-' . $title_slug) 
             ]);
    }
        
    public function remove_social(){
        $id = $this->input->post('id');

    
    if ($id) {
        
        $this->general_model->update(
            'social_details',
            array('id' => $id),
            array('isActive' => 0)
        );
         echo json_encode(array('success' => true));
    } else {
         echo json_encode(array('success' => false, 'message' => 'Invalid ID'));
    }

    }
    public function delete_profile($id)
    {
        $this->general_model->delete_profile('startup_details', $id);
        $this->session->unset_userdata('profile_details_startups');

        
        redirect('startups');
    }
    public function startup_docs(){
        if (isset($this->session->userdata('session_user_data')['id']) && $this->session->userdata('session_user_data')['user_type'] == 2) {
            $postdata = $this->input->post();
            
            $startup_id = $postdata['startup_id'];
            //$attendee_id = $postdata['id'];
            $attendee_id = $this->session->userdata('session_user_data')['id'];
            $typeof_doc = $this->input->post("typeof_doc");
            $doc_flag = 0;
            
            if (isset($_FILES[''.$typeof_doc.'']) && !empty($_FILES[''.$typeof_doc.'']['tmp_name'])) {
                $doc_flag = 1;
                $upload_dir = "uploads/".$typeof_doc."/";
                //print_r($postdata);
                $file_name = $_FILES[''.$typeof_doc.'']['name'];
                //exit;
                $file_tmp = $_FILES[''.$typeof_doc.'']["tmp_name"];
                $file_extension = pathinfo($_FILES[''.$typeof_doc.'']['name'], PATHINFO_EXTENSION);
                $target_file = $upload_dir . $file_name . '.' . $file_extension;
                
                
            }
            if($doc_flag == 1){
                if (move_uploaded_file($file_tmp, $target_file)) {
                    $data = array(
                        'startup_id' => $startup_id,
                        'link' => $typeof_doc,
                        'file' => $target_file,
                        'attende_id' => $attendee_id
                    );
                    $this->general_model->insert('social_details', $data);
                    echo json_encode([
                        'success' => true
                    ]);
                }
            }
        }
        else {
            redirect('login/getlogin');      
        }
    }
    
}
