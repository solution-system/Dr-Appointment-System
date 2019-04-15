<?php

class Doctor extends MY_Common {

    var $sError;
    var $data;

    function __construct() {
        // load controller parent
        parent::__construct();
        $this->sError = '';
        $this->data['doctor_id'] = '';
    }

    function index() {
        $this->listing();
    }

    function listing() {
        // print 'chck: ' . parent::check_security(1, 'admin', '/doctor/');
        if (parent::check_security(1, '/admin/doctor/')) {
            $page_no = $this->uri->segment(4);
            $display = 20;
            $this->load->model('doctor_model');
            $this->data['name'] = $this->input->get_post('name');
            $name = strtolower($this->input->get_post('name'));
            $this->data['doctor'] = $this->doctor_model->getDoctor('LOWER(name)', $name, $page_no, $display);
            $total = $this->doctor_model->getNumDoctor();
            $this->data['total'] = $total;
            $this->data['rec_now'] = count($this->data['doctor']);
            $this->data['doctor_count'] = 0;
            if ($total == '0') {
                $this->data['msg'] = 'No record found';
                $this->load->library('pagination');
            } else {
                $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url() . 'admin/doctor/listing/';
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
                $config['num_links'] = 4;
                $this->pagination->initialize($config);
                $this->data['msg'] = '';
            }
            // load 'doctor_view' view
            $this->data['main_content'] = 'admin/doctor_view';
            $this->load->view('template/admin/content', $this->data);
        }
    }

    function add() {
        $this->load->model('common_model');
        //if($this->session->userdata('username') == "")
        //   redirect('/admin/login/doctor/add/');
        if (parent::check_security(1, '/admin/doctor/add/')) {
            $this->load->model('doctor_model');
            if ($this->input->post('FormAction') <> "") {
                $this->data = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password'),
                    'name' => $this->input->post('name'),
                    'address' => $this->input->post('address'),
                    'state' => $this->input->post('state'),
                    'web1' => $this->input->post('web1'),
                    'web2' => $this->input->post('web2'),
                    'web3' => $this->input->post('web3'),
                    'web4' => $this->input->post('web4'),
                    'business_name' => $this->input->post('business_name'),
                    'email' => $this->input->post('email'),
                    'city' => $this->input->post('city'),
                    'phone1' => $this->input->post('phone1'),
                    'phone2' => $this->input->post('phone2'),
                    'zip' => $this->input->post('zip'),
                    'business_keyword' => $this->input->post('business_keyword'),
                    'business_desc' => $this->input->post('business_desc'),
                    'company_phone_no' => $this->input->post('company_phone_no'),
                    'company_email' => $this->input->post('company_email'),
                    'bureau_member' => $this->input->post('bureau_member'),
                    'active' => '1',
                    'certification' => $this->input->post('certification'),
                    'area_coverage' => $this->input->post('area_coverage'),
                    'type_of_doctor' => $this->input->post('type_of_doctor'),
                    'type_of_insurance' => $this->input->post('type_of_insurance')
                );

                // db adding
                $this->common_model->insert("doctor", $this->data);
                $doctor_id = $this->db->insert_id();
                $this->doctor_business_logo_update($doctor_id);
                $this->load->helper("my_helper");
                doctor_service_update($doctor_id);
                // $this->doctor_service_update($doctor_id);
                // $this->doctor_area_update($doctor_id);
                redirect(base_url() . 'admin/doctor/');
            } else {
                $this->initialize();
            }
            // load 'doctor_view' view
            $this->data['main_content'] = 'admin/doctor_update';
            $this->data['FormAction'] = 'Add';
            $this->load->view('template/admin/content', $this->data);
        }
    }

    function edit() {
        $this->load->model('common_model');
        if ($this->session->userdata('ulevel') == "1"){
            /*$doctor_id = $this->common_model->f('doctor', 'doctor', array('id' => $this->session->userdata('uid')));*/

            // print 'uid: ' . $this->session->userdata('uid');
            $doctor_id = $this->session->userdata('uid');
        }
        else if ($this->session->userdata('ulevel') == "0")
            $doctor_id = $this->uri->segment(4);
        // print 'edit @ dr ' . $doctor_id;
        if (parent::check_security(2, '/admin/doctor/edit/' . $doctor_id)) {
            if ($this->input->post('FormAction') <> "") {
                if ($this->sError == "") {
                    $this->data = array(
                        'username' => $this->input->post('username'),
                        'password' => $this->input->post('password'),
                        'name' => $this->input->post('name'),
                        'address' => $this->input->post('address'),
                        'state' => $this->input->post('state'),
                        'web1' => $this->input->post('web1'),
                        'web2' => $this->input->post('web2'),
                        'web3' => $this->input->post('web3'),
                        'web4' => $this->input->post('web4'),
                        'business_name' => $this->input->post('business_name'),
                        'email' => $this->input->post('email'),
                        'city' => $this->input->post('city'),
                        'phone1' => $this->input->post('phone1'),
                        'phone2' => $this->input->post('phone2'),
                        'zip' => $this->input->post('zip'),
                        'business_keyword' => $this->input->post('business_keyword'),
                        'business_desc' => $this->input->post('business_desc'),
                        'company_phone_no' => $this->input->post('company_phone_no'),
                        'company_email' => $this->input->post('company_email'),
                        'bureau_member' => $this->input->post('bureau_member'),
                        'certification' => $this->input->post('certification'),
                        'area_coverage' => $this->input->post('area_coverage'),
                        'type_of_doctor' => $this->input->post('type_of_doctor'),
                        'type_of_insurance' => $this->input->post('type_of_insurance')
                    );
                    // print_r ($this->data);
                    $this->db->where('id', $doctor_id);
                    $this->db->update('doctor', $this->data);
                    $this->doctor_business_logo_update($doctor_id);
                    $this->load->helper("my_helper");
                    doctor_service_update($doctor_id);
                    redirect(base_url() . 'admin/doctor/');
                }
                else
                    $this->data['msg'] = 'ERROR: ' . $this->sError;
            }
            else {
                
                $this->data = $this->common_model->get('doctor', array('id' => $doctor_id), TRUE);
                $this->data['temp_state'] = $this->data['state'];
                $this->data['temp_city'] = $this->data['city'];
                $this->data['temp_zip'] = $this->data['zip'];

                $this->data['msg'] = '';
                $this->data["doctor_id"] = $doctor_id;
                $this->data['i'] = 0;
                $this->load->model('doctor_model');
                $this->data['states'] = $this->doctor_model->getUS_State();

                $this->data['tot_st'] = $this->doctor_model->getNum_USStates();
                $this->data['services'] = $this->doctor_model->get_Service($doctor_id, 'admin');
                $this->data['total_service'] = $this->doctor_model->getNum_Service();
                if ($this->data['bureau_member'] == '1') {
                    $this->data['member1'] = ' CHECKED ';
                    $this->data['member2'] = '';
                } else {
                    $this->data['member1'] = '';
                    $this->data['member2'] = ' CHECKED ';
                }
                $this->data['main_content'] = 'admin/doctor_update';
                $this->data['FormAction'] = 'Update';
                $this->load->view('template/admin/content', $this->data);
            }
        }
    }

    function delete() {
        $doctor_id = $this->uri->segment(4);
        if (parent::check_security(1, '/admin/doctor/delete/' . $doctor_id)) {
            if ($doctor_id == 'selected') {
                for ($i = 1; ($i <= $this->input->post('count')); $i++) {
                    if ($this->input->post('doctor_' . $i) <> "") {
                        $doctor_id = $this->input->post('doctor_' . $i);
                        $this->delete_user($doctor_id);
                    }
                }
                redirect(base_url() . 'admin/doctor/');
            } else {
                $this->delete_user($doctor_id);
                redirect(base_url() . 'admin/doctor/');
            }
        }
    }

    function delete_user($doctor_id) {
        $this->load->model('common_model');
        $img = $this->common_model->scalar("doctor", "business_logo", array('id' => $doctor_id));
        if ($img <> "") {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/business_logo/' . $img))
                unlink($_SERVER['DOCUMENT_ROOT'] . '/business_logo/' . $img);
        }
        $this->common_model->delete('doctor_service', array('frn_user' => $doctor_id));
        // $this->common_model->delete('doctor_area',array('frn_user'=>$doctor_id));
        $this->common_model->delete('doctor', array('id' => $doctor_id));
    }

    function doctor_business_logo_update($doctor_id) {
        // print '$this->input->post(business_logo): -->' . ( $_FILES AND $_FILES['business_logo']['name'] ) . '<--';
        if ($_FILES AND $_FILES['business_logo']['name']) {
            $business_logo = '';
            $this->load->model('Gallery_model');
            $business_logo = $this->Gallery_model->do_upload('business_logo', '../business_logo', $doctor_id);
            // print ('bl: ' . $business_logo);
            $this->data = array(
                'business_logo' => $business_logo
            );
            if ($business_logo <> '') {
                $this->load->model('common_model');
                $this->common_model->update("doctor", array('id' => $doctor_id), $this->data);
            }
        }
        // exit();
    }

    function initialize() {       
        $this->data['app_detail'] = '';
        $this->data['return'] = '';
        $this->data['item_name'] = '';
        $this->data['username'] = '';
        $this->data['password'] = '';
        $this->data['type_of_insurance'] = '';
        $this->data['type_of_doctor'] = '';
        $this->data['doctor_id'] = '';
        $this->data['doctor_zip'] = '';
        $this->data['name'] = '';
        $this->data['address'] = '';
        $this->data['state'] = '';
        $this->data['temp_state'] = '';
        $this->data['temp_city'] = '';
        $this->data['temp_zip'] = '';
        $this->data['web1'] = '';
        $this->data['web2'] = '';
        $this->data['web3'] = '';
        $this->data['web4'] = '';
        $this->data['web5'] = '';
        $this->data['fee'] = 0;
        $this->data['business_name'] = '';
        $this->data['email'] = '';
        $this->data['city'] = '';
        $this->data['phone1'] = '';
        $this->data['phone2'] = '';
        $this->data['zip'] = '';
        $this->data['entire_nation'] = '';
        $this->data['business_logo'] = '';
        $this->data['business_keyword'] = '';
        $this->data['business_desc'] = '';
        $this->data['msg'] = '';
        $this->data['company_phone_no'] = '';
        $this->data['company_email'] = '';
        $this->data['area_coverage'] = '';
        $this->data['certification'] = '';
        $this->data['i'] = 0;
        $this->load->model('doctor_model');
        $this->data['states'] = $this->doctor_model->getUS_State();
        $this->data['tot_st'] = $this->doctor_model->getNum_USStates();

        $this->data['services'] = $this->doctor_model->get_Service('', 'admin');
        $this->data['total_service'] = $this->doctor_model->getNum_Service();
        if ($this->input->post('bureau_member') == '1') {
            $this->data['member1'] = ' CHECKED ';
            $this->data['member2'] = '';
        } else {
            $this->data['member1'] = '';
            $this->data['member2'] = ' CHECKED ';
        }
    }

    function appointment() {
        $this->load->model('common_model'); 
        if ($this->session->userdata('ulevel') == "0")
        {
            // print ('dr.' . $this->input->get_post('doctor'));
            if ($this->input->get_post('doctor') == "")
                $doctor_id = $this->uri->segment(4);
            else
                $doctor_id = $this->input->get_post('doctor');
            // print '<br>dr.2: ' . $doctor_id;
            $user_id = '';
        }
        else if ($this->session->userdata('ulevel') == "1")
        {            
            $doctor_id = $this->session->userdata('doctor_id');
            $user_id = '';
        }
        else if ($this->session->userdata('ulevel') == "2")
        {
            if ($this->input->get_post('doctor') == "")
                $doctor_id = $this->common_model->f('user', 'doctor', $this->session->userdata('uid'));
            else
                $doctor_id = $this->input->get_post('doctor');
            // print $this->db->last_query();
            $user_id = $this->session->userdata('uid');
        }
        
        $year = $this->uri->segment(5);
        $month = $this->uri->segment(6);
        $url = '/admin/doctor/appointment/' . $doctor_id;
        if ($year <> "")
            $url .= '/' . $year;
        if ($month <> "")
            $url .= '/' . $month;
        if (parent::check_security(2, $url)) {
            $this->load->model('doctor_model');
            if ($year=="") 
            {
                $year = date('Y');
            }
            if ($month=="") 
            {
                $month = date('m');
            }
            // print '<br>dr 3: ' . $doctor_id;
            $this->data['doctor_id'] = $doctor_id;
            $this->data['timing'] = '';
            $this->data['calid'] = '';
            $this->data['return'] = '';
            $this->data['item_name'] = '';
            $this->data['month'] = $month;
            $this->data['year'] = $year;            
            $this->data['calendar'] = $this->display($year, $month, $doctor_id, $user_id);
            $this->data['doctor_name'] = $this->common_model->f('doctor', 'name', $doctor_id);
            $this->data['business_logo'] = $this->common_model->f('doctor', 'business_logo', $doctor_id);
            $this->data['services'] = $this->doctor_model->get_Service($doctor_id);
            $this->data['main_content'] = 'admin/appointment_view';
            $this->load->view('template/admin/content', $this->data);
        }
    }
    function app_detail() 
    {
        $this->load->helper("my_helper");
        $arr = explode(',', get_config_ext('timing'));    
        $doctor_id = $this->uri->segment(4);
        $year = $this->uri->segment(5);
        $month = $this->uri->segment(6);
        $day = $this->uri->segment(7);
        $user_id = $this->uri->segment(8);
        $app_data = '<table width="100%" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td bgcolor="darkblue" colspan="3" align="center">
                                <font color=white>Appointment Detail for '. $month . '/' . $day . '/' . $year . '</font>
                            </td>
                        </tr>
                        <tr bgcolor="darkblue">
                            <td width="60"><font color=white>Time</font></td>
                            <td><font color=white>Message</font></td>
                            <td></td>
                       </tr>';
        for ($i=0; $i < count($arr); $i++)
        {                    
            $timing = trim($arr[$i]);
            $sql = 'SELECT  timing,  
                            `data`, 
                            if ((paid=1 AND doctor_id=' . $doctor_id;
            if ($user_id <> "")
                $sql .= ' AND user_id = ' . $user_id;
            $sql .= '),
                    "<img src=\"/images/paid.png\" height=20 border=\"0\">",
                            if ((paid=1 AND doctor_id=' . $doctor_id;
            if ($user_id <> "")
                $sql .= ' AND user_id <> ' . $user_id;
            $sql .= '),
                    "<img src=\"/images/reserved.gif\" border=\"0\">", 
                    if ((paid <> 1 AND doctor_id=' . $doctor_id;
            if ($user_id <> "")
                $sql .= ' AND user_id = ' . $user_id;
            $sql .= '),
                        CONCAT("<a href=\"javascript: pay_now(", id, ",\'", `data`, "\',\''. $timing . '\',\''. $day . '\');\"><img src=\"/images/paynow.gif\" border=\"0\"></a>"),
                    if ((paid <> 1 AND doctor_id=' . $doctor_id;
            if ($user_id <> "")
                $sql .= ' AND user_id <> ' . $user_id;
            $sql .= '),
                CONCAT("<a href=\"javascript: pay_now(", id, ",\'", `data`, "\',\''. $timing . '\',\''. $day . '\');\"><img src=\"/images/paynow.gif\" border=\"0\"></a>"), 1	
                                        )))) as `icon`
                    FROM (`calendar`) 
                    WHERE `date` LIKE \'' . $year . '-' . $month . '-' . $day . '\'  AND
                            doctor_id=' . $doctor_id . ' AND 
                            timing=STR_TO_DATE("' . $timing . '", "%h:%i %p")';
            // print htmlentities($sql) . '<hr>';
            $query = $this->db->query($sql);  
            if($query->num_rows() == 0)
            {
                $app_data .= '<tr>
                                    <td nowrap width="60">' . $timing . '</td>
                                    <td ALIGN=CENTER><B>AVAILABLE</B></td>
                                    <td><a href="javascript: pay_now(\'\',\'\',\''. $timing . '\',\''. $day . '\');"><img src="/images/paynow.gif" border="0"></a></td>
                               </tr>'; 
            }   
            else 
            {
                foreach ($query->result() as $row) {
                    $app_data .= '<tr>
                                        <td nowrap width="60">' . $timing . '</td>
                                        <td>' . $row->data . '</td>
                                        <td>' . $row->icon . '</td>
                                   </tr>';                
                }
            }
        }        
        print $app_data . '</table>';
    }
    function display($year, $month, $doctor_id, $user_id) 
    {
        $this->load->model('calendar_model');
        $cal = $this->calendar_model->generate($year, $month, $doctor_id, $user_id);
        // print $this->db->last_query();
        return $cal;
    }
    function add_calendar_data() {
        $this->load->model('common_model');  
        if ($this->session->userdata('ulevel') == "2")
        {
            // $doctor_id = $this->common_model->f('user', 'doctor', $this->session->userdata('uid'));
            // print $this->db->last_query();
            $user_id = $this->session->userdata('uid');
        }
        else
        {
            // $doctor_id = $this->uri->segment(4);
            $user_id = $this->input->get_post('user');
        }
        $doctor_id = $this->uri->segment(4);
        $year = $this->uri->segment(5);
        $month = $this->uri->segment(6);
        $url = '/' . $this->session->userdata('user_type') . '/doctor/appointment/' . $doctor_id;
        if ($year <> "")
            $url .= '/' . $year;
        if ($month <> "")
            $url .= '/' . $month;
        if (parent::check_security(2, $url)) 
        {
            $this->load->model('calendar_model');
            if ($year=="") {
                        $year = date('Y');
                    }
            if ($month=="") {
                $month = date('m');
            }            
            $day = $this->input->get_post('day');
            $timing = $this->input->get_post('timing');
            $calid = $this->calendar_model->add_calendar_data(
                "$year-$month-$day", $this->input->get_post('data'), $doctor_id, $user_id, $timing
            );
            redirect(base_url() . 'proceed/payment/' . $calid);
        }
    }
}

?>