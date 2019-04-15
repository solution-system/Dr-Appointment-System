<?php

class Proceed extends CI_Controller 
{
    public function index()
    {
        $this->payment();
    }
    public function payment()
    {
       $calid = $this->uri->segment(3);
       // print 'calid: ' . $calid . '<br>';
       
       $data['return'] = "http://dr.solutionsystem.net/update/" . $calid;
       $this->load->model('common_model');
       $dataa = $this->common_model->f("calendar", "data", $calid);
       $data['item_name'] = $dataa;
       $data['calid'] = $calid;
       $data['main_content'] = 'frontend/paypal';
       $this->load->view('template/frontend/content', $data);
    }
}
?>
