<?php

class Tracking extends MY_Common {

    var $sError;
    var $fields;
    function __construct() {
        // load controller parent
        parent::__construct();
        $this->sError = '';
        $this->fields = explode(', ', 'Visitors, user, Lead by Phone 1, phone1, Lead by Phone 2, phone2, Lead by Email, email, Lead by Form, form');
    }

   function index() 
   {
       if (parent::check_security(1, '/admin/tracking/')) 
       {            
            $this->load->library('table');
            $this->load->library('pagination');
            $data['start_date'] = '';
            $data['end_date'] = '';
            $data['company'] = '';
            $data['state'] = '';
            $data['city'] = '';
            $data['zip'] = '';
            $data['msg'] = '';
            $data['total_msg'] = '';
            $data['rec_now'] = '';
            $data['table'] = '';
            //$fields = explode(', ', 'Visitors, user, Lead by Phone 1, phone1, Lead by Phone 2, phone2, Lead by Email, email, Lead by Form, form');

            $data['fields'] = $this->fields; 
            $data['main_content'] = 'admin/tracking_view';
            $this->load->view('template/admin/content', $data);
       }
    }
    function listing($query_id = 0)  {
        if (parent::check_security(1, '/admin/tracking/')) 
        {
            $this->load->library('input'); 
            $this->input->load_query($query_id);
            $query_array = array(
                'start_date' => $this->input->get('start_date'),
                'end_date' => $this->input->get('end_date'),
                'company' => $this->input->get('company'),
                'state' => $this->input->get('state'),
                'city' => $this->input->get('city'),
                'zip' => $this->input->get('zip'),
                'field_clicked_0' => $this->input->get('field_clicked_0'),
                'field_clicked_2' => $this->input->get('field_clicked_2'),
                'field_clicked_4' => $this->input->get('field_clicked_4'),
                'field_clicked_6' => $this->input->get('field_clicked_6'),
                'field_clicked_8' => $this->input->get('field_clicked_8')
            );
            //$data['query_id'] = $query_id;
            $temp_state = $this->input->get('state');
            $rows = $this->db->get_where('us_states', array('region' => $temp_state))->result();
            if (isset($rows[0])) {
                $temp_state = strtoupper($rows[0]->code);
            }
            
            // $this->save_search_qs();
            $this->load->library('pagination');
            $data['fields'] = $this->fields; 
            $data['start_date'] = $this->input->get('start_date');
            $data['end_date'] = $this->input->get('end_date');
            $data['company'] = $this->input->get('company');
            $data['state'] = $temp_state;
            $data['city'] = $this->input->get('city');
            $data['zip'] = $this->input->get('zip');
            $data['msg'] = '';                        
            $data['fields'] = $this->fields;
            $page_no = $this->uri->segment(5);
            $display = 20;
            $this->load->library('table');

            $sql = 'SELECT  CONCAT(\'<input type="checkbox" name="tracking_\', @curRow := @curRow + 1, \'" value="\', t.id, \'">\') as chk,
                            DATE_FORMAT(dos, "%c/%e/%Y %T") as `Date of Submit`,
                            chk_input(ucwords(zip)) as `Zip Code`,
                            chk_input(ucwords(city)) as City,
                            chk_input(ucwords(state)) as State,
                            chk_input((SELECT u.name FROM user u WHERE t.user=u.id)) as User,
                            chk_input((SELECT u.name FROM user u WHERE t.profile_id=u.id)) as `Profile`,
                            if (LENGTH(field_clicked) = 0, "Keyword Search", CONCAT("Click to see: ", UPPER(field_clicked))) as `Search Type`,
                            IF (chk_input(url) = "<font class=not_applicable>N/A</font>", "<font class=not_applicable>N/A</font>", concat("<a target=_blank href=/", url, ">/", url, "</a>")) as URL,
                            CONCAT("<a onclick=\"javascript: return confirm(\'Sure to delete this Tracking URL Record: ", t.url, "?\');\" href=\"/admin/tracking/delete/" , t.id, "\"><img src=\"/images/del.gif\" border=\"0\"></a>")                            
                  FROM      tracking t
                  JOIN      (SELECT @curRow := 0) r
                  WHERE     id is not null ';
            if (strlen($query_array['start_date'])) 
                $sql .= ' AND (dos >= STR_TO_DATE(' . $this->db->escape($query_array['start_date']) . ', "%m/%d/%Y")) ';
            if (strlen($query_array['end_date'])) 
                $sql .= ' AND (dos <= STR_TO_DATE(' . $this->db->escape($query_array['end_date']) . ', "%m/%d/%Y")) ';
            if ((strlen($query_array['state'])) or (strlen($query_array['city'])) or (strlen($query_array['zip'])))
            {
                // if ($query_array['zip']<>0)            
                $sql .= ' AND (';
            }
            if (strlen($query_array['state']))
                $sql .= '  (state=' . $this->db->escape($query_array['state']) . ') ';
            if (strlen($query_array['city']))
                $sql .= ' AND (city=' . $this->db->escape($query_array['city']) . ') ';
            if (strlen($query_array['zip']))
            {
                if ($query_array['zip']<>0)
                    $sql .= ' AND (zip=' . $this->db->escape($query_array['zip']) . ') ';
            }
            if (strlen($query_array['company']) <> "")
                $sql .= ' AND (t.profile_id IN (SELECT u.id FROM user u WHERE u.business_name LIKE "%' . $query_array['company'] . '%")) ';
            $temp = '';
            //$temp_count = 0;
            $visitor_selected = FALSE;
            for ($i = 0; $i < count($this->fields); $i = ($i + 2)) {
                if (strlen($query_array['field_clicked_' . $i])) {
                    if ($query_array['field_clicked_' . $i] <> "0")
                    {
                        if ($query_array['field_clicked_' . $i] == 'user')
                           $visitor_selected = TRUE;
                        else
                            $temp .= ' (field_clicked=' . $this->db->escape($query_array['field_clicked_' . $i]) . ') OR ';
                    }
                    //$temp_count++;
                }
            }
            if ($temp <> "") {
                //if ($temp_count == "1")
                $sql .= ' AND (' . substr($temp, 1, (strlen($temp) - 4)) . ') ';
                //else
                //   $sql .= ' AND ('
            }
            if ((strlen($query_array['state'])) or (strlen($query_array['city'])) or (strlen($query_array['zip'])))
            {
                // if ($query_array['zip']<>0)
                    $sql .= ')';
            }
            if ($visitor_selected == TRUE)
                $sql .= ' GROUP BY user ';
            $sql .= '   ORDER by t.dos DESC ';
            // print $sql;
            $query = $this->db->query($sql);
            $total = $query->num_rows();            
            if (($page_no == "") or ($this->input->post('FormAction') == 'tracking'))
                $sql .= " LIMIT	0, " . $display;
            else {
                if ($page_no == "1")
                    $page_no = 0;
                $sql .= " LIMIT	" . $page_no . ", " . $display;
            }
           // print 'sql1: ' . $sql;

            $query = $this->db->query($sql);
            $rec_now = $query->num_rows();
            $data['rec_now'] = $rec_now;
            $data['total_msg'] =  ($page_no+1) . ' to ' . ($page_no + $rec_now). ' of total: ' . $total;
            if ($query->num_rows() == '0') {
                $data['msg'] = 'No record found';
                $data['table'] = '';
            } else {
                $config['uri_segment'] = 5;
                $config['base_url'] = base_url() . 'admin/tracking/listing/' . $query_id;
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

                $tmpl = array('table_open' => '<table id="table_sort" class="tablesorter">',
                    'row_start' => '<tr nowrap onmouseover="this.className = \'mover\';" onmouseout="this.className = \'tr\';">'
                );
                $this->table->set_template($tmpl);
                $this->table->set_heading('<input type="checkbox" onclick="javascript: chk_all(this.checked);"/>', 'Date of Submit', 'Zip-Code', 'City', 'State', 'User', 'User Profile', 'Search Type', 'URL', '');
                $table = $this->table->generate($query);
                $data['table'] = $table;
            }
            $data['main_content'] = 'admin/tracking_view';
            $this->load->view('template/admin/content', $data);
        }
    }

    function delete() {
        $tracking_id = $this->uri->segment(4);
        if (parent::check_security(1, '/admin/tracking/delete/' . $tracking_id)) {
            if ($tracking_id == 'selected') {
                for ($i = 1; ($i <= $this->input->post('count')); $i++) {
                    if ($this->input->post('tracking_' . $i) <> "") {
                        $tracking_id = $this->input->post('tracking_' . $i);
                        $this->delete_tracking($tracking_id);
                    }
                }
                redirect(base_url() . 'admin/tracking/');
            } else {
                $this->delete_tracking($tracking_id);
                redirect(base_url() . 'admin/tracking/');
            }
        }
    }

    function delete_tracking($tracking_id) {
        $this->load->model('common_model');
        $this->common_model->delete('tracking', array('id' => $tracking_id));
    }
    function search()  {
        if (parent::check_security(1, '/admin/tracking/')) 
        {
            //$this->load->library('input'); 
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $company = $this->input->post('company');
            $state = $this->input->post('state');
            $city = $this->input->post('city');
            $zip = $this->input->post('zip');
            $checked1 = (isset($_POST['field_clicked_0']))?$this->input->post('field_clicked_0'):"";
            $checked2 = (isset($_POST['field_clicked_2']))?$this->input->post('field_clicked_2'):"";
            $checked3 = (isset($_POST['field_clicked_4']))?$this->input->post('field_clicked_4'):"";
            $checked4 = (isset($_POST['field_clicked_6']))?$this->input->post('field_clicked_6'):"";
            $checked5 = (isset($_POST['field_clicked_8']))?$this->input->post('field_clicked_8'):"";
            
            $rows = $this->db->get_where('us_states', array('code' => $state))->result();
            if (isset($rows[0])) {
                $state = strtoupper($rows[0]->region);
            }
        
            $query_array = array(
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company' => $company,
                'state' => $state,
                'city' => $city,                
                'zip' => $zip,
                'field_clicked_0' => $checked1,
                'field_clicked_2' => $checked2,
                'field_clicked_4' => $checked3,
                'field_clicked_6' => $checked4,
                'field_clicked_8' => $checked5
            );             
            $query_id = $this->input->save_query($query_array);
            redirect(base_url() . "admin/tracking/listing/$query_id");
        }
    }
}

?>