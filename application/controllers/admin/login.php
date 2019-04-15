<?php

class Login extends MY_Common {

    var $sError, $data;

    function __construct() { //this could also be called function User(). the way I do it here is a PHP5 constructor
        parent::__construct();
    }

    public function index() {
        $this->user();
    }

    function user() {
        // print 'at user';
        if (!$this->authenticate('user')) {
            if ($this->input->post('username') <> "")
                $this->data['sError'] = '<div class="error">ERROR: Username: "' . $this->input->post('username') . '" not exist. Please try again.</div>';
        }
        $this->form_display('user');
    }
    
    function admin() {
        //print 'at admin';
        if (!$this->authenticate('admin')) {
            if ($this->input->post('username') <> "")
                $this->data['sError'] = '<div class="error">ERROR: Admin Username: "' . $this->input->post('username') . '" not exist. Please try again.</div>';
        }
        $this->form_display('admin');
    }

    function doctor() {
        //print 'at dr.';
        if (!$this->authenticate('doctor')) {
            if ($this->input->post('username') <> "")
                $this->data['sError'] = '<div class="error">ERROR: Doctor Username: "' . $this->input->post('username') . '" not exist. Please try again.</div>';
        }
        $this->form_display('doctor');
    }

    function get_ret_page() {
        $ret = '';
        $ts = $this->uri->total_segments();
        for ($i = 3; $i <= $ts; $i++) {
            $ret .= $this->uri->segment($i) . '/';
        }
        if ($ret <> "")
            return urlencode($ret);
        else
            $ret = '';
    }

    function redirection() 
    {       
        // print 'ut: ' . $this->session->userdata('user_type');
        if ($this->session->userdata('user_type') == 'doctor')
        {
            $url = base_url() . 'admin/user/';
            redirect($url);
        }
        else if ($this->session->userdata('user_type') == 'user')
        {
            $url = base_url() . 'admin/doctor/appointment/';
            redirect($url);
        }
        $ret_page = urldecode($this->input->post('ret_page'));
        // print '$ret_page: ' . $ret_page . '<br>';
        if ($ret_page <> "")
            redirect(base_url() . $ret_page);
        $url = '';
       // print '4: ' . $this->uri->segment(4);
        //if (($this->uri->segment(3) <> "") and ($this->uri->segment(3) <> "login"))
        //    $url .= $this->uri->segment(3) . '/';
        if ($this->uri->segment(4) <> "")
            $url .= $this->uri->segment(4) . '/';
        if ($this->uri->segment(5) <> "")
            $url .= $this->uri->segment(5); 
        if ($url <> "")
            $url = base_url() . 'admin/'  . $url;
        // print 'url: ' . $this->session->userdata('user_type');
        redirect("/");        
    }

    function form_display($u = 'user') {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->data['u'] = ucfirst($u);
        $this->data['username'] = $this->input->post('username');
        $this->data['username'] = '';
        $this->data['main_content'] = 'admin/login_view';
        $this->load->view('template/admin/content', $this->data);
    }

    function authenticate($u = 'user') {
        // // print 'auth u: ' . $u;
        if ($this->session->userdata('username') <> "")
            $this->redirection();

        $password = $this->input->post('password');
        $this->data['ret_page'] = $this->get_ret_page();
        $this->data['username'] = $this->input->post('username');
        $this->data['sError'] = '';
        if ($this->input->post('username')) {
            $this->load->model('login_model');
            $res = $this
                    ->login_model
                    ->verify_user($this->input->post('username'), $password, $u);

            if ($res !== false) 
            {
                // $this->load->helper('cookie');
                $this->input->set_cookie(array('user_type'   => $u));

                $this->session->set_userdata('user_type', $u);
                $this->session->set_userdata('username', $this->input->post('username'));
                $this->load->model('common_model');
                $uid = $this->common_model->scalar($u,'id', 
                            array('username' => $this->input->post('username'))
                        );
                $this->session->set_userdata('uid', $uid);
                $name = $this->common_model->scalar($u,'name', array('username' => $this->input->post('username')));
                $this->session->set_userdata('name', $name);
                // print 'u at auth : ' . $this->session->userdata('uid');
                if ($u == 'admin')
                    $ulevel = '0';
                else if ($u == 'doctor')
                {
                    $ulevel = '1';
                    $this->session->set_userdata('doctor_id', $uid);
                }
                else
                {
                    $ulevel = '2';
                    $this->session->set_userdata('doctor_id', $this->common_model->f($u, 'doctor', $uid));
                }
                // print '<br>ulevel ' . $ulevel;
                $this->session->set_userdata('ulevel', $ulevel);                
                $this->redirection();
            }
            else
                return FALSE;
        }
    }

}

?>