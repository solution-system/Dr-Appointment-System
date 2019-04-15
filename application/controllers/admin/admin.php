<?php

class Admin extends MY_Common {

    function __construct() { //this could also be called function User(). the way I do it here is a PHP5 constructor
        parent::__construct();
    }

    public function index() {
        // if ($this->session->userdata('username') == "")
            $this->login();
        /*else {
            $data['main_content'] = 'admin/index';
            $this->load->view('template/admin/content', $data);
        }*/
    }

    function login() {
        if ($this->session->userdata('username') == "")
        {
            $data['main_content'] = 'admin/index';
            $this->load->view('template/admin/content', $data);
            //$this->redirection();
        }    
        else {            
            $user_name = $this->input->post('user_name');
            $user_pass = $this->input->post('user_pass');
            $data['ret_page'] = $this->get_ret_page();
            $data['user_name'] = $user_name;
            $data['sError'] = '';
            if ($this->input->post('user_name')) {

                $this->load->model('admin_model');
                $res = $this
                        ->admin_model
                        ->verify_user($user_name, $user_pass);

                if ($res !== false) {
                    $this->session->set_userdata('user_type', 'admin');
                    $this->session->set_userdata('username', $user_name);
                    $this->session->set_userdata('ulevel', '0');
                    $this->redirection();
                } else {
                    // $this->form_validation->set_error_delimiters('<div class="error">ERROR: Username: ', $user_name, ' -- Password: ', $user_pass,'</div>');
                    $data['sError'] = '<div class="error">ERROR: Username: ' . $user_name . ' -- Password: ' . $user_pass . '</div>';
                    // redirect(base_url() . 'admin/login');
                }
            } else {
                // SET VALIDATION RULES
                $this->form_validation->set_rules('user_name', 'username', 'required');
                $this->form_validation->set_rules('user_pass', 'password', 'required');
                // $this->form_validation->set_error_delimiters('<div class="error">ERROR: Username: ', $user_name, ' -- Password: ', $user_pass,'</div>');
                // $data['sError'] = '<div class="error">ERROR: Username: ' . $user_name . ' -- Password: ' . $user_pass . '</div>';
            }

            $data['main_content'] = 'admin/login_view';
            $this->load->view('template/admin/content', $data);
        }
    }

    function doctor() {
        if ($this->session->userdata('username') <> "")
            $this->redirection();
        else {            
            $user_name = $this->input->post('user_name');
            $user_pass = $this->input->post('user_pass');
            $data['ret_page'] = $this->get_ret_page();
            $data['user_name'] = $user_name;
            $data['sError'] = '';
            if ($this->input->post('user_name')) 
            {
                $this->load->model('admin_model');
                $res = $this
                        ->admin_model
                        ->verify_user_user($user_name, $user_pass, 'doctor');

                if ($res !== false) {
                    $this->session->set_userdata('user_type', 'doctor');
                    $this->session->set_userdata('username', $user_name);
                    $this->session->set_userdata('ulevel', '1');
                    $this->redirection();
                } else {
                    // $this->form_validation->set_error_delimiters('<div class="error">ERROR: Username: ', $user_name, ' -- Password: ', $user_pass,'</div>');
                    $data['sError'] = '<div class="error">ERROR: Username: ' . $user_name . ' -- Password: ' . $user_pass . '</div>';
                    // redirect(base_url() . 'admin/login');
                }
            } else {
                // SET VALIDATION RULES
                $this->form_validation->set_rules('user_name', 'username', 'required');
                $this->form_validation->set_rules('user_pass', 'password', 'required');
                // $this->form_validation->set_error_delimiters('<div class="error">ERROR: Username: ', $user_name, ' -- Password: ', $user_pass,'</div>');
                // $data['sError'] = '<div class="error">ERROR: Username: ' . $user_name . ' -- Password: ' . $user_pass . '</div>';
            }

            $data['main_content'] = 'admin/login_view';
            $this->load->view('template/admin/content', $data);
        }
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

    function redirection() {
      /*  $ret_page = urldecode($this->input->post('ret_page'));
        // print '$ret_page: ' . $ret_page . '<br>';
        if ($ret_page <> "")
            redirect(base_url() . $ret_page);
        else {
            $url = '';
            // print '3: ' . $this->uri->segment(3);
            if (($this->uri->segment(3) <> "") and ($this->uri->segment(3) <> "login"))
                $url .= $this->uri->segment(3) . '/';
            if ($this->uri->segment(4) <> "")
                $url .= $this->uri->segment(4) . '/';
            if ($this->uri->segment(5) <> "")
                $url .= $this->uri->segment(5);
            // print 'url:   ' . $url;
            if ($url <> "")
                redirect(base_url() . $url);
            else
                redirect(base_url() . 'admin/admin');*/
            redirect("/");    
        }
    }

}

?>