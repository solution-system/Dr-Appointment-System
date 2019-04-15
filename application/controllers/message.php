<?php

class Message extends MY_Frontend {

    function __construct() { //this could also be called function User(). the way I do it here is a PHP5 constructor
        parent::__construct();
    }

    public function index() {
        $this->alert();
    }
    
    public function cancal() {
        $data['msg'] = '<p>Your payment has been cancelled. You can do it later before other user reserve this appointment.</p>';
    }
    public function success() {
        $data['msg'] = '<p>Thank you.<br>Your appointment has been confirmed and fee received.<br><br>Please contact site administrator for appointment -timing.</p>';
    }

    function alert() {
        $data['title'] = 'Dr. Website';
        $msg = $this->uri->segment(3);
        $kw = $this->uri->segment(4);
        if ($msg == 'expert_signup_successfull')
            $data['msg'] = '<p>Your information has been submitted. The process of research may take a couple of days. Please be sure to check your Email Address for a response</p>';
        if ($msg == 'advertiser_signup_successfull')
            $data['msg'] = '<div class="message">
                           <p>Thank you for contacting Dr. Website! We will respond to you as soon as possible!</p>
                         </div>';
        else if ($this->uri->segment(2) == 'registerd')
            $data['msg'] = '<p>Thank you for contacting Dr. Website! We will respond to you as soon as possible!</p>';
        else if ($msg == 'prohibited')
            $data['msg'] = '<font color=red>You are not allowed to visit this section!</font>';
        else if ($msg == 'no_record_found')
            $data['msg'] = '<font color=maroon>No record found for search criteria.</font>
         <script language="javascript">
            $("#keyword").val("' . $kw . '");
         </script>   
         ';
        // $data['banners'] = parent::get_banner('ad_type,-1');
        $data['main_content'] = 'frontend/message_view';
        $this->load->view('template/admin/content', $data);
    }

}

?>