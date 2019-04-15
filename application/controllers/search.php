<?php
class Search extends MY_Frontend
{
   var $no;
   var $str;
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
       $this->session->set_userdata('search_url', '');
    }

    public function index()
    {
       $this->processing();
    }
    public function processing()
	 {
      // // print '1 - index';
      $this->session->set_userdata('search_url', 'locate/result/');
      $this->session->set_userdata('keyword', '');
      $this->session->set_userdata('us_state', '');
      $this->session->set_userdata('service_selected', '');
      $keyword_original = urldecode($this->uri->segment(3));
      // $this->input->get_post('keyword');
      // // print '<br>keyword_original: ' . $keyword_original . '<br>';
	   $k = preg_replace('/\s\s+/', ' ', str_replace('services', '', str_replace(',', ' ', str_replace('.', ' ', strtolower(trim($keyword_original))))));
	   // // print '<br>k: ' . $k . '<br>';
	   if ($k == "")
	     redirect(base_url());
	   else
	   {
          $this->load->model('search_model');
          $this->str = $this->search_model->extract_no_str($k, 'str');
          $this->no = $this->search_model->extract_no_str($k, 'no');
          $this->session->set_userdata('keyword', trim($this->str));
          $this->session->set_userdata('keyword_no', trim($this->no));
          // print '<br>k 1: ' . $this->session->userdata("keyword");
          if ($this->session->userdata("keyword") <> "")
            $this->search_model->contain_service();
          // print '<br>k 2: ' . $this->session->userdata("keyword");
          if ($this->session->userdata("keyword") <> "")
            $this->search_model->contain_service_subtype();
          // print '<br>k 3: ' . $this->session->userdata("keyword");
          if ($this->session->userdata("keyword") <> "")
            $this->search_model->contain_us_state();
          // print '<br>k 4: ' . $this->session->userdata("keyword");
          if ($this->session->userdata("keyword") <> "")
            $this->search_model->contain_city();
          // print '<br>k 5 b4: ' . $this->no;            
          if ($this->session->userdata("keyword_no") <> "")
             $this->search_model->contain_zipcode($this->session->userdata("keyword_no"));
          // print '<br>k 5: ' . $this->session->userdata("keyword_no");
          if ($this->session->userdata("keyword") <> "")
             $this->search_model->contain_name();
          if ($this->session->userdata("keyword_no") <> "")
            $this->search_model->contain_phone($this->session->userdata("keyword_no"));
          // print '<br>k 6: ' . $this->session->userdata("keyword");

          if ($this->session->userdata("keyword") <> "")
          {
             // print '<br>k 7: ' . $this->session->userdata("keyword") . '<br>';
             $this->search_model->contain_company_name();
          }
          $search_url = $this->session->userdata("search_url");
          if ( $search_url == 'locate/result/')
   	       redirect(base_url() . 'message/alert/no_record_found/' . urlencode($keyword_original) . '/'); 
          else
          {
            // $this->update_tracking($search_url);
            redirect(base_url() . $search_url);
          }
	   }
    }

}
?>