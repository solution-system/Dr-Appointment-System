<?php
class Expert extends MY_Frontend
{
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
    }

    public function index()
	 { 
      $this->profile();
	 }
    function profile()
    {
         // $data['banners'] = parent::get_banner('ad_type,-1');
         $user_id = $this->uri->segment(3);
         $this->load->model('common_model');
         $data =  $this->common_model->get('user', array('id'=>$user_id),TRUE);
         $data['membership_start'] =  date('m/d/Y', strtotime($data['membership_start']));
         $data['membership_end'] =  date('m/d/Y', strtotime($data['membership_end']));
         $bl = $data["business_logo"];
         $data['business_keyword'] = '<li>' . str_replace('|', '</li><li>', $data["business_keyword"]) . '</li>';
         $ext =  pathinfo($bl, PATHINFO_EXTENSION);
      	$business_logo = str_replace("." . $ext, '', $bl);
         $data["business_img_large"] = '<img src="/business_logo/' . $user_id . '.' . $ext . '" border=0> ';
         $data["business_logo"] = $user_id . '_thumb.' . $ext;
         $data['email'] = parent::onclick_info('email', $data['email'], $data['id']);
         $data['phone1'] = parent::onclick_info('phone1', $data['phone1'], $data['id']);
         $data['phone2'] = parent::onclick_info('phone2', $data['phone2'], $data['id']);
         $data['msg'] = '';
         $data["user_id"] = $user_id;
         $data['i'] = 0;
         $this->load->model('user_model');
         $data['states'] = $this->user_model->getUS_State();
         $data['tot_st'] = $this->user_model->getNum_USStates();
         $uz = $this->user_model->get_user_zip($user_id);
         if ($data['entire_nation'] == "1")
            $data['user_zip'] = '<div id="blink"><b>ENTIRE NATION</b></div>';
         else
         {
            if ($uz <> "")
               $data['user_zip'] = $uz;
            else
               $data['user_zip'] = $uz;
         }      
         $data['services'] = $this->user_model->get_Service($user_id);
         $data['total_service'] = $this->user_model->getNum_Service();
   		$data['main_content'] = 'frontend/expert_view';
   		$this->load->view('template/frontend/content', $data);
   }
}
?>