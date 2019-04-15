<?php

class facility extends MY_Common {

    var $sError, $data;

    function __construct() {
        // load controller parent
        parent::__construct();
        $this->sError = '';
    }

    function index() {
        $this->listing();
    }

    function listing() {
        if (parent::check_security(0, '/admin/facility/')) {
            $this->data['msg'] = '';
            $name = $this->input->get_post('name');
            $this->data['name'] = $name;
            $page_no = $this->uri->segment(4);
            $display = 20;
            $this->load->library('table');
            $sql = 'SELECT  CONCAT(\'<input type="checkbox" name="facility_\', @curRow := @curRow + 1, \'" value="\', a.id, \'">\') as chk,
                            name,
                            CONCAT("<a href=\"/admin/facility/edit/" , a.id, "\"><img width=\"20\" heigth=\"20\" src=\"/images/edit_icon.gif\" border=\"0\" align=\"center\"></a>"),
                            CONCAT("<a onclick=\"javascript: return confirm(\'Sure to delete this Facility: ", a.name, "?\');\" href=\"/admin/facility/delete/" , a.id, "\"><img src=\"/images/del.gif\" border=\"0\" align=\"center\"></a>")
                  FROM     service a
                  JOIN    (SELECT @curRow := 0) r ';
            if ($name <> "")
                $sql .= ' WHERE LOWER(a.name) LIKE \'%' . strtolower($name) . '%\' ';

            $sql .= '   ORDER by a.name ASC ';
            if ($page_no == "")
                $sql .= " LIMIT	0, " . $display;
            else {
                if ($page_no == "1")
                    $page_no = 0;
                $sql .= " LIMIT	" . $page_no . ", " . $display;
            }
            // print $sql;

            $query = $this->db->query($sql);
            $this->data['total'] = $this->db->count_all('service');
            $this->data['rec_now'] = $query->num_rows();
            if ($query->num_rows() == '0') {
                $this->data['msg'] = 'No record found';
                $this->data['table'] = '';
                $this->load->library('pagination');
            } else {
                $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url() . 'admin/facility/listing/';
                $config['total_rows'] = $this->db->count_all('service');
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

                $tmpl = array('table_open' => '<table id="table_sort" class="tablesorter">',
                    'row_start' => '<tr onmouseover="this.className = \'mover\';" onmouseout="this.className = \'tr\';">'
                );

                $this->table->set_template($tmpl);

                $this->table->set_heading('<input type="checkbox" onclick="javascript: chk_all(this.checked);"/>', 'Facility', '', '');
                $table = $this->table->generate($query);
                $this->data['table'] = $table;
            }

            // load 'facility_view' view
            $this->data['main_content'] = 'admin/facility_view';
            $this->load->view('template/admin/content', $this->data);
        }
    }

    function add() {
        $chk = '';
        $this->load->helper("my_helper");
        $this->load->model('common_model');
        if (parent::check_security(0, '/admin/facility/add/')) {
            if ($this->input->post('FormAction') == "Add") {
                $chk = $this->common_model->scalar('service','count(id)', array('name' => $this->input->post('name')));
                if ($chk == '0')
                {
                    $this->load->model('common_model');
                    $this->common_model->insert("service", $this->data_process());
                    redirect(base_url() . 'admin/facility/');
                }
                else
                    $this->data['msg'] = 'Error: Facility already exist. Please try again...';
            }
            $this->initialize('', $chk);
            $this->data['main_content'] = 'admin/facility_update_view';
            $this->data['FormAction'] = 'Add';
            $this->load->view('template/admin/content', $this->data);
        }
    }

    function edit() {
        $facility_id = $this->uri->segment(4);
        $chk = '';
        if (parent::check_security(0, '/admin/facility/edit/' . $facility_id)) {
            if ($this->input->post('FormAction') == "Update") 
            {
                $this->load->model('common_model');
                $chk = $this->common_model->scalar('service','count(id)', 
                                                    array('name' => $this->input->post('name'), 'id !=' => $facility_id));
                if ($chk == '0')
                {
                    $this->db->where('id', $facility_id);
                    $this->db->update('service', $this->data_process());
                    redirect(base_url() . 'admin/facility/');
                }
                else
                    $this->data['msg'] = 'Error: Facility already exist. Please try again...';                
            }
            $this->initialize($facility_id, $chk);
            $this->data['main_content'] = 'admin/facility_update_view';
            $this->data['FormAction'] = 'Update';
            $this->load->view('template/admin/content', $this->data);            
        }
    }

    function delete() {
        $facility_id = $this->uri->segment(4);
        if (parent::check_security(0, '/admin/facility/delete/' . $facility_id)) {            
            $this->load->model('common_model');
            if ($facility_id == 'selected') 
            {
                for ($i = 1; ($i <= $this->input->post('count')); $i++) 
                {
                    if ($this->input->post('facility_' . $i) <> "") 
                    {
                        $facility_id = $this->input->post('facility_' . $i);
                        $this->common_model->delete('service', array('id' => $facility_id));
                    }
                }
            } 
            else 
            {
                $this->load->model('common_model');
                $this->common_model->delete('service', array('id' => $facility_id));
            }                        
            redirect(base_url() . 'admin/facility/');
        }
    }

    function initialize($facility_id = '', $sError = '') 
    {
        $this->load->helper("my_helper");
        if ($sError == "")
        {
            $this->load->model('common_model');
            if ($facility_id <> "")
                $this->data = $this->common_model->get('service', array('id' => $facility_id), TRUE);
            else
                $this->data = $this->common_model->get('service');
            // print $this->data;
            // exit();

            $this->data['name'] = get_param('name', $this->data);
            $this->data["facility_id"] = $facility_id; 
            $this->data["facilities"] = $this->db->select('CONCAT("<li>", GROUP_CONCAT(name SEPARATOR "<li>")) as names')->get("service")->row('names'); 
            $this->data['msg'] = '';
        }
        else
        {
            $this->data['name'] = get_param('name');
            $this->data["facility_id"] = get_param("facility_id");
        }
    }

    function data_process() {
        $temp = array(
            'name' => $this->input->post('name')
        );
        // print_r ($temp);
        return $temp;
    }   
}

?>