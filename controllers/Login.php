<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends Public_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->library('linkedin');
    }
   

    public function getlogin()
    {
      
        $linkedin = new Linkedin();
        $login_url = $linkedin->get_login_url();

        redirect($login_url);
    }


    public function callback()
    {
        echo "hi";exit;;
        $code = $this->input->get('code');

        if ($code) {
            $linkedin = new Linkedin();
            $token_data = $linkedin->get_access_token($code);
            if (isset($token_data['access_token'])) {
                $access_token = $token_data['access_token'];
                $user_info = $this->getLinkedinUser($access_token);
                // echo "<pre>";
                // print_r($user_info);die;
                $Name = $user_info['name'] ?? '';
                $email = $user_info['email'] ?? '';
                $country = $user_info['locale']['country'];
                $profile_photo = $user_info['picture']  ;
                
                $data = array(
                    'name' =>  $Name,
                    'email' => $email,
                    'token' => $access_token,
                    'country'=>$country,
                    'profile_photo'=>$profile_photo,
                );
                
                $exist = $this->general_model->getOne('startup_users', array('name'=>$Name));
                
                
                if ($exist) {
                    
                    $id = $exist->id;
                    $data = array(
                        'token' => $access_token,
                        'profile_photo'=>$profile_photo,

                    );
                  
                    $this->general_model->update('startup_users', array('email' => $email), $data);
                    
                    $session = array(
                        'id' => $id,
                        'name' => $Name,
                        'email' => $email,
                        'token' => $access_token,
                        'user_type' => 2,

                    );
                    $this->session->set_userdata('session_user_data',$session);
                 } else {
                    $this->general_model->insert('startup_users', $data);
                    $id = $this->db->insert_id();
                }
                if ($id) {
                    $session = array(
                        'id' => $id,
                        'name' => $Name,
                        'email' => $email,
                        'token' => $access_token,
                        'user_type' => 2,

                    );
                    $this->session->set_userdata('session_user_data',$session);
                }
                    $attendee = $this->general_model->getOne('attende_details', array('name' => $Name ,'isActive'=>1));
                if ($attendee) {
                    $this->general_model->update('attende_details', array('name' => $Name),array('login_id'=>$id,'email'=>$email));
                    redirect('techpreneurs/details/' . $attendee->id . '-' . url_title($attendee->name, '-', TRUE));
                 }
                 $startup = $this->general_model->getOne('startup_details', array('name' => $Name,'isActive'=>1 ));
                if ($startup) {
                    $this->general_model->update('startup_details', array('name' => $Name),array('login_id'=>$id));
                    redirect('startups/details/' . $startup->id);
                }else{
                    redirect('techpreneurs/create_account');
                }
                    
                
                // else{
                //     redirect('startups/create_account');
                //    }
                } else {
                    echo "Failed to get access token";
                }
                } else {
                    echo "No authorization code received";
                }
            }

    public function logout()
    {
    //     $this->session->unset_userdata('profile_details_startups');
    //     $this->session->unset_userdata('profile_details');
    //   echo "unset";die;
         $this->session->unset_userdata('session_user_data');
         $this->session->unset_userdata('profile_details');
        $this->session->set_flashdata('message', array('1', 'Successfully logout.'));
        redirect('startups', 'refresh');
    }
    public function getLinkedinUser($access_token){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.linkedin.com/v2/userinfo");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $access_token"
        ));

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            return json_decode($response, true);
        }

        curl_close($ch);
        exit;
    }

   
}


