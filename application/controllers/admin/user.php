<?php
class User extends MY_Common
{
   var $sError;
   var $data; 
   function __construct()
   {
      // load controller parent
      parent::__construct();
      $this->sError = '';
   }
   function index()
   {
    	$this->listing();
   }
   function listing()
   {
      // print 'chck: ' . parent::check_security(1, 'admin', '/user/');
      if (parent::check_security(1, '/admin/user/'))
      {
         $page_no = $this->uri->segment(4);
         $display = 20;
         $this->load->model('user_model');
         $this->data['name'] = $this->input->get_post('name');
         $name = strtolower($this->input->get_post('name'));
         $this->data['user'] = $this->user_model->getUsers('LOWER(name)', $name, $page_no, $display);
         $total = $this->user_model->getNumUsers();
         $this->data['total'] = $total;
         $this->data['rec_now'] = count($this->data['user']);
         $this->data['user_count'] = 0;
         if ($total == '0')
         {
            $this->data['msg']='No record found';
            $this->load->library('pagination');
         }
         else
         {
            $this->load->library('pagination');
            $config['uri_segment'] =4;
            $config['base_url'] = base_url() . 'admin/user/listing/';
            $config['total_rows'] = $total;
            $config['per_page'] = $display;
            $config['cur_tag_open'] = '<b>';
            $config['cur_tag_close'] = '</b>';
            $config['full_tag_open'] = '<span>';
            $config['full_tag_close'] = '</span>';
            $config['first_link'] = ' First';
            $config['last_link'] = ' Last';
            $config['last_tag_open'] = '<span>';
            $config['last_tag_close'] = '</span>';
            $config['next_link'] = '';
            $config['next_tag_open'] = '<span id="nextbutton" style="padding-left:5px;">';
            $config['next_tag_close'] = '</span>';
            $config['prev_link'] = '';
            $config['prev_tag_open'] = '<span id="prevbutton" style="padding-right:5px;">';
            $config['prev_tag_close'] = '</span>';
            $config['num_links']=4;
            $this->pagination->initialize($config);
            $this->data['msg']='';
         }
         // load 'users_view' view
         $this->data['main_content'] = 'admin/users_view';
         $this->load->view('template/admin/content', $this->data);
      }
   }
   function add()
   {
        $chk = '';
        $this->load->helper("my_helper");
        $this->load->model('common_model');
        if (parent::check_security(1, '/admin/user/add/'))
        {
           $this->load->model('user_model');
           if ($this->input->post('FormAction')<>"")
           {
              $chk = $this->common_model->scalar('user','count(id)', array('username' => $this->input->post('username')));
              if ($chk == '0')
              {
                  $this->data = array(
                  'doctor' => $this->input->post('doctor'),
                  'username' => $this->input->post('username'),
                  'password' => $this->input->post('password'),
                  'name'     => $this->input->post('name'),
                  'address'     => $this->input->post('address'),
                  'state'     => $this->input->post('state'),
                  'web'     => $this->input->post('web'),
                  'business_name'     => $this->input->post('business_name'),
                  'email'     => $this->input->post('email'),
                  'city'     => $this->input->post('city'),
                  'phone1'     => $this->input->post('phone1'),
                  'phone2'     => $this->input->post('phone2'),
                  'zip'     => $this->input->post('zip'),
                  'company_phone_no'     => $this->input->post('company_phone_no'),
                  'company_email'     => $this->input->post('company_email'),
                  'active'     => '1'
                  );

                  // db adding
                  $this->common_model->insert("user", $this->data);
                  redirect(base_url() . 'admin/user/');
              }
              else
                  $this->data['msg'] = 'Error: User "' . $this->input->post('username') . '" already exist. Please try again...';
           }           
           $this->initialize('', $chk);           
           $this->data['main_content'] = 'admin/user_update';
           $this->data['FormAction'] = 'Add';
           $this->load->view('template/admin/content', $this->data);
      }
   }
   function edit()
   {
        if ($this->session->userdata('ulevel') == "2")
            $user_id = $this->session->userdata('uid');
        else
            $user_id = $this->uri->segment(4); 
            // print $user_id;

      $chk = '';      
      if (parent::check_security(2, '/admin/login/user/edit/' . $user_id))
      {
         if ($this->input->post('FormAction')<>"")
         {
             $this->load->model('common_model'); 
             $chk = $this->common_model->scalar('user','count(id)', array(
                 'username' => $this->input->post('username'),
                 'id != ' => $user_id
                     ));
             // print $this->db->last_query(); 
             if ($chk == '0')
              {
                    $this->data = array(
                        'doctor' => $this->input->post('doctor'),
                        'username' => $this->input->post('username'),
                        'password' => $this->input->post('password'),
                        'name'     => $this->input->post('name'),
                        'address'     => $this->input->post('address'),
                        'state'     => $this->input->post('state'),
                        'web'     => $this->input->post('web'),
                        'business_name'     => $this->input->post('business_name'),
                        'email'     => $this->input->post('email'),
                        'city'     => $this->input->post('city'),
                        'phone1'     => $this->input->post('phone1'),
                        'phone2'     => $this->input->post('phone2'),
                        'zip'     => $this->input->post('zip'),
                        'company_phone_no'     => $this->input->post('company_phone_no'),
                        'company_email'     => $this->input->post('company_email'),
                        'active'     => '1'
                  );
                   // print_r ($this->data);
                   $this->db->where('id', $user_id);
                   $this->db->update('user', $this->data);
                   redirect(base_url() . 'admin/user/');
             }
             else
                $this->data['msg'] = 'ERROR: ' . $this->sError;      
         }
        // print '2: ' . $user_id;
        $this->initialize($user_id, $chk);           
        $this->data['main_content'] = 'admin/user_update';
        $this->data['FormAction'] = 'Update';
        $this->load->view('template/admin/content', $this->data);
      }   
   }
   function delete()
   {
      $user_id = $this->uri->segment(4);
       if (parent::check_security(1, '/admin/user/delete/' . $user_id))
      {
         if ($user_id == 'selected')
         {
             for ($i=1; ($i <= $this->input->post('count')); $i++)
             {
                if ($this->input->post('user_' . $i)<>"")
                {
                    $user_id = $this->input->post('user_' . $i);
                    $this->delete_user($user_id);
                }
             }
             redirect(base_url() . 'admin/user/');
         }
         else
         {
            $this->delete_user($user_id);
            redirect(base_url() . 'admin/user/');
         }
      }   
   }
   function delete_user($user_id)
   {
       $this->common_model->delete('user',array('id'=>$user_id));
   }
   function initialize($user_id = '', $sError = '') 
   {
      $this->load->helper("my_helper");
      $this->data["sError"] = $sError; 
      if ($sError == "")
      {
        // print 'user id: ' . $user_id;
        // print 'user id: ' . isset($this->data);

        $this->load->model('common_model');
        $this->data = $this->common_model->get('user', array('id' => $user_id), TRUE);
        /*print 'data: ' . isset($this->data);
        print 'name: ' . $this->data['name'];
        print '3: user_id: ' . $user_id;*/
        if (!isset($this->data) or ($user_id == ""))
          $this->data = null;

        $this->data['doctor'] = get_param('doctor', $this->data);        
        $this->data['name'] = get_param('name', $this->data);        
        $this->data["user_id"] = $user_id; 
        $this->data['username'] = get_param('username', $this->data);  
        $this->data['password'] = get_param('password', $this->data);  
        $this->data['user_id'] = get_param('user_id', $this->data);  
        $this->data['user_zip'] = get_param('user_zip', $this->data);  
        
        $this->data['address'] = get_param('address', $this->data);  
        
        $this->data['state'] = get_param('state', $this->data);  
        $this->data['temp_state'] = get_param('state', $this->data);  
        $this->data['temp_city'] = get_param('city', $this->data);  
        $this->data['temp_zip'] = get_param('zip', $this->data);  
        $this->data['web'] = get_param('web', $this->data);  

        $this->data['business_name'] = get_param('business_name', $this->data);  
        $this->data['email'] = get_param('email', $this->data);  
        $this->data['city'] = get_param('city', $this->data);  
        $this->data['phone1'] = get_param('phone1', $this->data);  
        $this->data['phone2'] = get_param('phone2', $this->data);  
        $this->data['zip'] = get_param('');   
        $this->data['msg'] = get_param('');  
        $this->data['company_phone_no'] = get_param('company_phone_no', $this->data);  
        $this->data['company_email'] = get_param('company_email', 
        $this->data); $this->data['sError'] = ''; 
      }
      else
      {        
        $this->data['username'] = get_param('username');
        $this->data['password'] = get_param('password');
        $this->data['user_id'] = get_param('user_id');
        $this->data['user_zip'] = get_param('user_zip');
        $this->data['name'] = get_param('name');
        $this->data['address'] = get_param('address');
        $this->data['state'] = get_param('state');
        $this->data['temp_state'] = get_param('state');
        $this->data['temp_city'] = get_param('city');
        $this->data['temp_zip'] = get_param('zip');
        $this->data['web'] = get_param('web');

        $this->data['business_name'] = get_param('business_name');
        $this->data['email'] = get_param('email');
        $this->data['city'] = get_param('city');
        $this->data['phone1'] = get_param('phone1');
        $this->data['phone2'] = get_param('phone2');
        $this->data['zip'] = get_param('zip');
        $this->data['company_phone_no'] = get_param('company_phone_no');
        $this->data['company_email'] = get_param('company_email');
      }
   }
}
?>