<?php

class config extends MY_Common {

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
        if (parent::check_security(0, '/admin/config/')) {
            $this->data['msg'] = '';
            $name = $this->input->get_post('name');
            $this->data['name'] = $name;
            $page_no = $this->uri->segment(4);
            $display = 20;
            $this->load->library('table');
            $sql = 'SELECT  CONCAT(\'<input type="checkbox" name="config_\', @curRow := @curRow + 1, \'" value="\', a.id, \'">\') as chk,
                            config_variable,
                            config_value,
                            CONCAT("<a href=\"/admin/config/edit/" , a.id, "\"><img width=\"20\" heigth=\"20\" src=\"/images/edit_icon.gif\" border=\"0\" align=\"center\"></a>"),
                            CONCAT("<a onclick=\"javascript: return confirm(\'Sure to delete this Config Record: ", a.config_variable, "?\');\" href=\"/admin/config/delete/" , a.id, "\"><img src=\"/images/del.gif\" border=\"0\" align=\"center\"></a>")
                  FROM     config a
                  JOIN    (SELECT @curRow := 0) r ';
            if ($name <> "")
                $sql .= ' WHERE LOWER(a.config_variable) LIKE \'%' . strtolower($name) . '%\' ';

            $sql .= '   ORDER by a.config_variable ASC ';
            if ($page_no == "")
                $sql .= " LIMIT	0, " . $display;
            else {
                if ($page_no == "1")
                    $page_no = 0;
                $sql .= " LIMIT	" . $page_no . ", " . $display;
            }
            // print $sql;

            $query = $this->db->query($sql);
            $this->data['total'] = $this->db->count_all('config');
            $this->data['rec_now'] = $query->num_rows();
            if ($query->num_rows() == '0') {
                $this->data['msg'] = 'No record found';
                $this->data['table'] = '';
                $this->load->library('pagination');
            } else {
                $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url() . 'admin/config/listing/';
                $config['total_rows'] = $this->db->count_all('config');
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

                $this->table->set_heading('<input type="checkbox" onclick="javascript: chk_all(this.checked);"/>', 'Config Variable', 'Config Value', '', '');
                $table = $this->table->generate($query);
                $this->data['table'] = $table;
            }

            // load 'config_view' view
            $this->data['main_content'] = 'admin/config_view';
            $this->load->view('template/admin/content', $this->data);
        }
    }

    function add() {
        $chk = '';
        $this->load->helper("my_helper");
        $this->load->model('common_model');
        if (parent::check_security(0, '/admin/config/add/')) {
            if ($this->input->post('FormAction') == "Add") {                
                $chk = $this->common_model->scalar('config','count(id)', array('config_variable' => $this->input->post('config_variable')));
                if ($chk == '0')
                {
                    $this->common_model->insert("config", $this->data_process());
                    redirect(base_url() . 'admin/config/');
                }
                else
                    $this->data['msg'] = 'Error: Config Variable already exist. Please try again...';
            }
            $this->initialize('', $chk);
            $this->data['main_content'] = 'admin/config_update_view';
            $this->data['FormAction'] = 'Add';
            $this->load->view('template/admin/content', $this->data);
        }
    }

    function edit() {
        $config_id = $this->uri->segment(4);
        $chk = '';
        if (parent::check_security(0, '/admin/config/edit/' . $config_id)) 
        {
            if ($this->input->post('FormAction') == "Update") 
            {
                $this->load->model('common_model');
                $chk = $this->common_model->scalar('config','count(id)', 
                                                    array('config_variable' => $this->input->post('config_variable'), 'id !=' => $config_id));
                // print $this->db->last_query();
                if ($chk == '0')
                {
                    $this->db->where('id', $config_id);
                    $this->db->update('config', $this->data_process());
                    redirect(base_url() . 'admin/config/');
                }
                else
                    $this->data['msg'] = 'Error: Config Variable already exist. Please try again...';
            }
            $this->initialize($config_id, $chk);
            $this->data['main_content'] = 'admin/config_update_view';
            $this->data['FormAction'] = 'Update';
            $this->load->view('template/admin/content', $this->data);
        }
    }

    function delete() {
        $config_id = $this->uri->segment(4);
        if (parent::check_security(0, '/admin/config/delete/' . $config_id)) {            
            $this->load->model('common_model');
            if ($config_id == 'selected') 
            {
                for ($i = 1; ($i <= $this->input->post('count')); $i++) 
                {
                    if ($this->input->post('config_' . $i) <> "") 
                    {
                        $config_id = $this->input->post('config_' . $i);
                        $this->common_model->delete('config', array('id' => $config_id));
                    }
                }
            } 
            else 
            {
                $this->load->model('common_model');
                $this->common_model->delete('config', array('id' => $config_id));
            }                        
            redirect(base_url() . 'admin/config/');
        }
    }

    function initialize($config_id = '', $sError = '') 
    {
        $this->load->helper("my_helper");
        if ($sError == "")
        {
            $this->load->model('common_model');
            $this->data = $this->common_model->get('config', array('id' => $config_id), TRUE);
            $this->data['config_variable'] = get_param('config_variable', $this->data);
            $this->data['config_value'] = get_param('config_value', $this->data);
            $this->data["config_id"] = $config_id;
            $this->data['msg'] = '';
        }
        else
        {                        
            $this->data['config_variable'] = get_param('config_variable');
            $this->data['config_value'] = get_param('config_value');
            $this->data["config_id"] = get_param("config_id");
        }
        
    }

    function data_process() {
        $temp = array(
            'config_variable' => $this->input->post('config_variable'),
            'config_value' => $this->input->post('config_value')
        );
        // print_r ($temp);
        return $temp;
    }   
}

?>