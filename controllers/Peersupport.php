<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peersupport extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
       
        $this->template->public_render('public/peersupport/index');
    }    

}