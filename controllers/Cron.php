<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
    }

    public function fetch_ids()
    {
       $attendi= $this->general_model->getall('attende_details', array('startup_id !='=> 0));
       
        if($attendi){
            foreach ($attendi as $key => $value) {
                echo $value->startup_id ."<br>";
            }
            
        }
    }
    public function store_local_path_pitchdeck(){
        $links =$this->general_model->getAll('social_details', array('link' => 'Pitch deck', 'file' => ''));
        $update_data = [];
        if($links){
            foreach ($links as $key => $link) {
                if($link->link_href){
                    $path = parse_url($link->link_href, PHP_URL_PATH);
                    $file = "uploads/pitch_deck/".basename($path);
                    $update_data[] = array(
                        'id' => $link->id,
                        'file' => $file,
                    );
                    echo $key."....<br>";
                }
            }
        }
      
        if($update_data){
            $this->general_model->update_batch('social_details', $update_data, 'id');
        }
        echo "DONE>....";    
    }

    public function add_missing_fils_check(){
        $links =$this->general_model->getAll('social_details', array('link' => 'Pitch deck', 'file !=' => ''));
        if($links){
            foreach ($links as $key => $link) {
                if(!file_exists($link->file)){
                    echo $link->id." Missing file = ". $link->file."<br>";
                }
            }
        }
    }

    public function addpath_attandee(){
        $directory = 'uploads/attendees_profile/';
        // Get an array of files and directories
        $files = scandir($directory);

        // Filter out the current (.) and parent (..) directories
        $files = array_diff($files, array('.', '..'));
        $update_data = [];
        // Print the list of files
        foreach ($files as $file) {
            $update_data[] = [
                'id' => $this->removeExtension($file),
                'profile_image_download_path' => $directory.$file
            ];
            echo "$file is added as ".base_url($directory.$file)."<br>";
        }
        // attende_details
        if($update_data){
            $this->general_model->update_batch('attende_details', $update_data, 'id');
        }
    }

    function removeExtension($fileName) {
        return pathinfo($fileName, PATHINFO_FILENAME);
    }

// E:/uploads/logos/1.jpg
    public function updatelinks(){
        $lists = $this->general_model->getAll('startup_details', array('logo_src !=' => ''));
        if($lists){
            $update_data = [];
            foreach ($lists as $key => $l) {
                $link = str_split($l->logo_src);
                $newlink = '';
                if($link[0] == 'E'){
                    $newlink = str_replace('E:/', '', $l->logo_src);
                    $update_data[] = [
                        'id' => $l->id,
                        'logo_src' => $newlink
                    ];
                }
                echo "updated as ".base_url($newlink)."<br>";
            }
            if($update_data){
                $this->general_model->update_batch('startup_details', $update_data, 'id');
            }
        }
    }
    
}