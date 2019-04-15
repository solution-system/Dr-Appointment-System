<?php
class Change_pass extends MY_Common
{
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
    }
    function index()
    {
      if (parent::check_security(2, '/admin/change_pass/'))
      {
         if($this->input->post('FormAction') == 'change_pass')
       		{
       			$table = $this->session->userdata('user_type');
            $old = $this->input->post('old');
       			$new1 = $this->input->post('new1');
            $new2 = $this->input->post('new2');

       			$this->load->model('admin_model');
                $res = $this
                         ->admin_model
                         ->verify_pass($old, $table);

                if ( $res !== false )
                {
                   $data = array(
                                  'password' => $new1
                               );

                   $this->db->where('id', $this->session->userdata('uid'));
                   $this->db->update($table, $data);

                   // print $this->db->last_query();
                   $data['old'] = '';
                   $data['new1'] = '';
                   $data['new2'] = '';
                   $data['msg'] = '<font color="maroon">New password has been updated.</font>';
                }
       			else
       			{
                   $data['old'] = $old;
                   $data['new1'] = $new1;
                   $data['new2'] = $new2;
       				$data['msg'] = '<font color=red>ERROR: Incorrect old password.</font>';
       			}
   		}
   		else
   		{
            $data['msg'] = '';
            $data['old'] = '';
            $data['new1'] = '';
            $data['new2'] = '';
   		}
         $data['main_content'] = 'admin/change_pass_view';
         $this->load->view('template/admin/content', $data);
      }
   }      
}
?>