<?php
class Contact extends MY_Frontend
{
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
    }

    public function index()
	 {
         $data['title'] = 'Snell Expert - Contact';
         $data['banners'] = parent::get_banner('ad_type,-1');
         $data['main_content'] = 'frontend/contact_view';
		   $this->load->view('template/frontend/content', $data);
    }
    function email()
    {
         $this->load->helper("my_helper");
         $fullname = $this->input->get_post('first_name') . ' ' . $this->input->get_post('last_name');
         $subject = 'Someone has contact you at Snell Experts';
         $body = nl2br('

Hello Again Snell Experts,

Please check out the user’s submitted information and return to them soon:
At his Email Address: ' . chk_input($this->input->get_post('email')) . '
Or via Phone: ' . chk_input($this->input->get_post('phone')) . '

<b>Submitted information:</b>
<b>Contact First Name:</b> ' . chk_input($this->input->get_post('first_name')) . '
<b>Contact Last Name:</b> ' . chk_input($this->input->get_post('last_name')) . '
<b>Contact Phone Number:</b> ' . chk_input($this->input->get_post('phone')) . '
<b>State:</b> ' . chk_input($this->input->get_post('state')) . '
<b>City:</b> ' . chk_input($this->input->get_post('city')) . '
<b>Zip Code:</b> ' . chk_input($this->input->get_post('zip')) . '
<b>Comments:</b> ' . nl2br($this->input->get_post('comments')) . '


---
This is an automated message. Please do not reply to the Email sent. 
Godspeed Technologies, LLC has brought you this message ');
// print $body;
// print '<hr>list: ' .
// $this->input->get_post('to_email') . ', ' . $this->input->get_post('email') . ', ' . $subject . ', ' . $body . ', ' . $fullname . ', ' . "Snell Expert";
// $sent = parent::sendmail('abdul@solutionsystem.net', $this->input->get_post('email'), $subject, $body, "Admin", $fullname);
$sent = parent::sendmail(urldecode($this->input->get_post('to_email')),
                         urldecode($this->input->get_post('email')),
                         $subject,
                         $body,
                         $fullname,
                         "Snell Expert");
$sent = parent::sendmail('support@godspeedtechnologies.com',
                         urldecode($this->input->get_post('email')),
                         $subject,
                         $body,
                         $fullname,
                         "Snell Expert");
print $sent;
    }
}
?>