<?php
class Apply extends MY_Frontend
{
    var $data;
    var $sError;
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
       $this->sError = '';
       $this->data['title'] = 'Snell Expert - Apply';
       $this->data['banners'] = parent::get_banner('ad_type,-1');
    }
    public function index()
	 {
      if ($this->input->post('FormAction') == "Add")
      {
         // print 'form type: ' . $this->input->post('FormType');
         if ($this->input->post('FormType') == "expert")
            $this->expert_signup();
         else
            $this->advertiser_signup();
      }
      else
      {
         $this->load->model('user_model');

         $this->var_initialize();

         $this->load->helper("my_helper");
         $this->data['image'] = captcha();
         $this->data['main_content'] = 'frontend/apply_view';
         $this->load->view('template/frontend/content', $this->data);
      }
	}
   function expert_signup()
   {
      $this->load->helper("my_helper");
      $this->sError .= chk_registration($this->sError);
      if ($this->input->post() && ($this->input->post('word') <> $this->session->userdata('word')))
          $this->sError .= '- Invalid Captcha Entry... Please try again...<br>';
      if ($this->sError == "")
      {
         $fullname=$this->input->post('first_name') . ' ' . $this->input->post('last_name');
         $this->data = array(
                'name'     => $fullname,
                'state'     => $this->input->post('state'),
                'web1'     => $this->input->post('web1'),
                'business_name'     => $this->input->post('business_name'),
                'email'     => $this->input->post('email'),
                'city'     => $this->input->post('city'),
                'phone1'     => $this->input->post('phone1'),
                'phone2'     => $this->input->post('phone2'),
                'zip'     => $this->input->post('zip'),
                'company_phone_no'     => $this->input->post('company_phone_no'),
                'company_email'     => $this->input->post('company_email'),
                'area_coverage'     => $this->input->post('area_coverage'),
                'certification'     => $this->input->post('certification'),
                'best_time'     => $this->input->post('best_time'),
                'am_pm'     => $this->input->post('am_pm'),
                'bureau_member'     => $this->input->post('bureau_member')
            );
            $this->load->model('common_model');
            $this->common_model->insert("users", $this->data);
            $user_id = mysql_insert_id();
            user_service_update($user_id);
            $services = '';
for ($s=1; $s <= 5; $s++)
{
  if ($this->input->post('service' . $s) <> "")
  {
     $services .=  $this->common_model->scalar("service","name",array("id" => $this->input->post('service' . $s))) . ',';
  }
}
if ($services <> "")
   $services = substr($services, 1, (strlen($services)-1));
$subject = "A new contractor wants to be listed on Snell Experts!";
$body = nl2br('Hello Again Snell Experts,

A new contractor wants to be listed on your directory!
Please check out the user’s submitted information and return to them soon:
At his <b>Email Address:</b> ' . chk_input($this->input->post('email')) . '
Or via <b>Phone:</b> ' . chk_input($this->input->post('phone1')) . '

<b>Submitted information: </b>
<b>Contact First Name:</b>  ' . chk_input($this->input->post('first_name')) . '
<b>Contact Last Name:</b> ' . chk_input($this->input->post('last_name')) . '
<b>Contact Phone Number:</b> ' . chk_input($this->input->post('phone1')) . '
<b>Company Name:</b> ' . chk_input($this->input->post('business_name')) . '
<b>Contact Email Address:</b> ' . chk_input($this->input->post('email')) . '
<b>Company Phone Number:</b> ' . chk_input($this->input->post('company_phone_no')) . '
<b>Zip Code:</b> ' . chk_input($this->input->post('zip')) . '
<b>Company Email Address:</b> ' . chk_input($this->input->post('company_email')) . '
<b>Website:</b> ' . chk_input($this->input->post('web1')) . '
<b>Guesstimated Exposure Budget:</b> ' . chk_input($this->input->post('budget')) . '
<b>Company Service Types:</b> ' . $services . '
<b>Areas of Coverage:</b> ' . chk_input($this->input->post('area_coverage')) . '
<b>Certifications and Accreditations:</b> ' . chk_input($this->input->post('certification')) . '
<b>Best time to contact them:</b> ' . chk_input($this->input->post('best_time')) . '
<b>Better Business Bureau Member:</b> ' . chk_input($this->input->post('bureau_member'), 'bureau_member') . '


---
This is an automated message. Please do not reply to the Email sent. 
Godspeed Technologies, LLC has brought you this message');
// $sent = parent::sendmail('abdul@solutionsystem.net', $this->input->post('email'), $subject, $body, "Admin", $fullname);
$sent = parent::sendmail('support@snellexperts.com', $this->input->post('email'), $subject, $body, "Admin", $fullname);
$sent = parent::sendmail('support@godspeedtechnologies.com', $this->input->post('email'), $subject, $body, "Admin", $fullname);

$subject = 'Thank you for requesting to be listed on Snell Experts!';
$body = nl2br('

Hello Again ' . $fullname . ',

We appreciate your time and will be checking out your information then returning contact to you soon! Rest assured that your information is safe with us. We just need it to double check everything so that potential visitors are assured the utmost quality Experts to assist them. If you are approved, we can work out something to bring exposure to your fantastic brand. We will work up a custom plan based on your wants and your budget to assist the growth of your brand, in every way we can. Expect an Email, or Phone Call within the next couple of days if you have been approved. If you have not been approved, we will send you an Email to let you know, as well.

Please note:
If you have waited longer than 3 days, it may be due to our own growth. We work hard to assure exposure for the real Experts that have invested in our assistance to them. Please just bear with us, but if we are taking too long, or if you have further questions, please don’t hesitate to contact us at support@snellexperts.com.

---
Thank you and have an awesome day!
-Snell Experts Approval Team
<a href="http://www.snellexperts.com">http://www.snellexperts.com</a>');
$sent = parent::sendmail($this->input->post('email'), 'support@snellexperts.com', $subject, $body, $fullname, 'Snell Experts');
//$sent = parent::sendmail($this->input->post('email'), 'support@snellexperts.com', $subject, $body, $fullname, 'Snell Experts');

            if ($sent == true)
               redirect(base_url() . 'message/alert/expert_signup_successfull');
            else
               print $sent;
       }
       else
       {
          $this->var_initialize();
          $this->data['debug'] = '<font color=red><b>ERROR: </b>' . $this->sError . '</font>';
          $this->data['first_name'] = $this->input->post('first_name');
          $this->data['FormType'] = 'expert';
          $this->data['has_error'] = '1';
          $this->data['last_name'] = $this->input->post('last_name');
          $this->data['state'] = $this->input->post('state');
          $this->data['web1'] = $this->input->post('web1');
          $this->data['budget'] = $this->input->post('budget');
          $this->data['business_name'] = $this->input->post('business_name');
          $this->data['email'] = $this->input->post('email');
          $this->data['city'] = $this->input->post('city');
          $this->data['phone1'] = $this->input->post('phone1');
          $this->data['phone2'] = $this->input->post('phone2');
          $this->data['zip'] = $this->input->post('zip');
          $this->data['company_phone_no'] = $this->input->post('company_phone_no');
          $this->data['company_email'] = $this->input->post('company_email');
          $this->data['area_coverage'] = $this->input->post('area_coverage');
          $this->data['certification'] = $this->input->post('certification');
          $this->data['best_time'] = $this->input->post('best_time');
          $this->data['am_pm'] = $this->input->post('am_pm');
          if ($this->input->post('terms') == '1')
          {
            $this->data['agree1'] = ' CHECKED ';
            $this->data['agree2'] = '';
          }
          else
          {
             $this->data['agree1'] = '';
             $this->data['agree2'] = ' CHECKED ';
          }
          if ($this->input->post('bureau_member') == '1')
          {
            $this->data['member1'] = ' CHECKED ';
            $this->data['member2'] = '';
          }
          else
          {
             $this->data['member1'] = '';
             $this->data['member2'] = ' CHECKED ';
          }
          if ($this->input->post('am_pm') == 'AM')
          {
            $this->data['time_am_pm1'] = ' SELECTED ';
            $this->data['time_am_pm2'] = '';
          }
          else
          {
             $this->data['time_am_pm1'] = '';
             $this->data['time_am_pm2'] = ' SELECTED ';
          }
          $this->data['bureau_member'] = $this->input->post('bureau_member');
          $this->load->model('user_model');
          $this->data['states'] = $this->user_model->getUS_State();
          $this->data['tot_st'] = $this->user_model->getNum_USStates();

          $this->data['services'] = $this->user_model->get_Service('', 'admin');
          $this->data['total_service'] = $this->user_model->getNum_Service();
          $this->data['temp_state'] = $this->input->post('state');
          $this->data['temp_city'] = $this->input->post('city');
          $this->data['temp_zip'] = $this->input->post('zip');
          $this->load->helper("my_helper");
          $this->data['image'] = captcha();
          $this->data['main_content'] = 'frontend/apply_view';
          $this->load->view('template/frontend/content', $this->data);
       }
    }
   function advertiser_signup()
   {
      $this->var_initialize();
      $this->load->helper("my_helper");
      $this->sError .= chk_registration($this->sError, 'ad_');
      if ($this->input->post() && ($this->input->post('ad_word') <> $this->session->userdata('word')))
          $this->sError .= '- Invalid Captcha Entry... Please try again...<br>';
      if ($this->sError == "")
      {
         $fullname = $this->input->post('ad_first_name') . ' ' . $this->input->post('ad_last_name');
         $subject = 'A new Banner Advertiser wants to be listed on Snell Experts!';
         $body = nl2br('

Hello Again Snell Experts,

A new Banner advertiser wants to put a banner Ad on your directory! 
Please check out the user’s submitted information and return to them soon:
At his Email Address: ' . chk_input($this->input->post('ad_email')) . '
Or via Phone: ' . chk_input($this->input->post('ad_phone1')) . '

<b>Submitted information:</b>
<b>Contact First Name:</b> ' . chk_input($this->input->post('ad_first_name')) . '
<b>Contact Last Name:</b> ' . chk_input($this->input->post('ad_last_name')) . '
<b>Contact Phone Number:</b> ' . chk_input($this->input->post('ad_phone1')) . '
<b>Company Name:</b> ' . chk_input($this->input->post('ad_brand_name')) . '
<b>Contact Email Address:</b> ' . chk_input($this->input->post('ad_company_email')) . '
<b>Company Phone Number:</b> ' . chk_input($this->input->post('ad_company_phone_no')) . '
<b>State:</b> ' . chk_input($this->input->post('ad_state')) . '
<b>City:</b> ' . chk_input($this->input->post('ad_city')) . '
<b>Zip Code:</b> ' . chk_input($this->input->post('ad_zip')) . '
<b>Guesstimated Exposure Budget:</b> ' . chk_input($this->input->post('ad_budget')) . '
<b>Website:</b> ' . chk_input($this->input->post('ad_web1')) . '
<b>Product or Service they want to show:</b> ' . chk_input($this->input->post('ad_advertising')) . '</b>
<b>General areas they want to be seen in:</b> ' . chk_input($this->input->post('ad_areas')) . '</b>


---
This is an automated message. Please do not reply to the Email sent. 
Godspeed Technologies, LLC has brought you this message ');
// $sent = parent::sendmail('abdul@solutionsystem.net', $this->input->post('ad_email'), $subject, $body, "Admin", $fullname);
$sent = parent::sendmail('support@snellexperts.com', $this->input->post('ad_email'), $subject, $body, "Admin", $fullname);
$sent = parent::sendmail('support@godspeedtechnologies.com', $this->input->post('ad_email'), $subject, $body, "Admin", $fullname);

$subject = 'Thank you for requesting to be listed on Snell Experts!';
$body = nl2br('

Hello Again ' . $fullname . ',

We appreciate your time and will be checking out your information then returning contact to you soon! Rest assured that your information is safe with us. We just need it to look over everything so that have an idea of the product you are listing with us and for availability. If you are approved, we can work out something to bring exposure to your fantastic brand. We will work up a custom plan based on your wants and your budget to assist the growth of your brand, in every way we can. Expect an Email, or Phone Call within the next couple of days if you have been approved. If you have not been approved, we will send you an Email to let you know, as well.

Please note:
If you have waited longer than 3 days, it may be due to our own growth. We work hard to assure exposure for the real people that have invested in our assistance to them. Please just bear with us, but if we are taking too long, or if you have further questions, please don’t hesitate to contact us at support@snellexperts.com.

---
Thank you and have an awesome day!
-Snell Experts Approval Team
<a href="http://www.snellexperts.com">http://www.snellexperts.com</a>');
$sent = parent::sendmail($this->input->post('ad_email'), 'support@snellexperts.com', $subject, $body, $fullname, 'Snell Experts');
// $sent = parent::sendmail('abdul@solutionsystem.net', 'support@snellexperts.com', $subject, $body, $fullname, 'Snell Experts');
         redirect(base_url() . 'message/alert/advertiser_signup_successfull');
       }
       else
       {
          $this->data['ad_debug'] = '<font color=red><b>ERROR: </b>' . $this->sError . '</font>';
          $this->data['ad_first_name'] = $this->input->post('ad_first_name');
          $this->data['ad_FormType'] = 'advertiser';
          $this->data['ad_has_error'] = '1';
          $this->data['ad_last_name'] = $this->input->post('ad_last_name');
          $this->data['ad_state'] = $this->input->post('ad_state');
          $this->data['ad_web1'] = $this->input->post('ad_web1');
          $this->data['ad_advertising'] = $this->input->post('ad_advertising');
          $this->data['ad_areas'] = $this->input->post('ad_areas');
          $this->data['ad_brand_name'] = $this->input->post('ad_brand_name');
          $this->data['ad_email'] = $this->input->post('ad_email');
          $this->data['ad_city'] = $this->input->post('ad_city');
          $this->data['ad_phone1'] = $this->input->post('ad_phone1');
          $this->data['ad_zip'] = $this->input->post('ad_zip');
          $this->data['ad_budget'] = $this->input->post('ad_budget');
          $this->data['ad_company_phone_no'] = $this->input->post('ad_company_phone_no');
          $this->data['ad_company_email'] = $this->input->post('ad_company_email');
          $this->data['ad_temp_state'] = $this->input->post('ad_state');
          $this->data['ad_temp_city'] = $this->input->post('ad_city');
          $this->data['ad_temp_zip'] = $this->input->post('ad_zip');
          if ($this->input->post('ad_terms') == '1')
          {
            $this->data['ad_agree1'] = ' CHECKED ';
            $this->data['ad_agree2'] = '';
          }
          else
          {
             $this->data['ad_agree1'] = '';
             $this->data['ad_agree2'] = ' CHECKED ';
          }

          $this->load->helper("my_helper");
          $this->data['image'] = captcha();
          $this->data['main_content'] = 'frontend/apply_view';
          $this->load->view('template/frontend/content', $this->data);
       }
    }
    function var_initialize()
    {
      $this->data['ad_has_error'] = '';
      $this->data['ad_debug'] = '';
      $this->data['ad_first_name'] = '';
      $this->data['ad_last_name'] = '';
      $this->data['ad_state'] = '';
      $this->data['ad_web1'] = '';
      $this->data['ad_advertising'] = '';
      $this->data['ad_areas'] = '';
      $this->data['ad_brand_name'] = '';
      $this->data['ad_email'] = '';
      $this->data['ad_city'] = '';
      $this->data['ad_phone1'] = '';
      $this->data['ad_zip'] = '';
      $this->data['ad_budget'] = 'Example: $300 to $600 per month';
      $this->data['ad_company_phone_no'] = '';
      $this->data['ad_company_email'] = '';
      $this->data['ad_temp_state'] = '';
      $this->data['ad_temp_city'] = '';
      $this->data['ad_temp_zip'] = '';


      $this->data['FormType'] = '';
      $this->data['has_error'] = '';
      $this->data['debug'] = '';
      $this->data['first_name'] = '';
      $this->data['last_name'] = '';
      $this->data['state'] = '';
      $this->data['web1'] = '';
      $this->data['budget'] = 'Example: $300 to $600 per month';
      $this->data['business_name'] = '';
      $this->data['email'] = '';
      $this->data['city'] = '';
      $this->data['phone1'] = '';
      $this->data['phone2'] = '';
      $this->data['zip'] = '';
      $this->data['company_phone_no'] = '';
      $this->data['company_email'] = '';
      $this->data['area_coverage'] = '';
      $this->data['certification'] = '';
      $this->data['best_time'] = '';
      $this->data['am_pm'] = '';
      $this->data['agree1'] = ' SELECTED ';
      $this->data['agree2'] = '';
      $this->data['ad_agree1'] = ' SELECTED ';
      $this->data['ad_agree2'] = '';
      $this->data['member1'] = '';
      $this->data['member2'] = '';
      $this->data['time_am_pm1'] = '';
      $this->data['time_am_pm2'] = '';

      $this->data['bureau_member'] = '';
      $this->data['temp_state'] = '';
      $this->data['temp_city'] = '';
      $this->data['temp_zip'] = '';
      $this->load->model('user_model');
      $this->data['services'] = $this->user_model->get_Service('', 'admin');
      $this->data['total_service'] = $this->user_model->getNum_Service();
    }
}
