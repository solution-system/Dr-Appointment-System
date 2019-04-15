<?php

class Calendar_model extends CI_Model {

    var $conf;

    function __construct() {

        $this->conf = array(
            'start_day' => 'monday',
            'day_type' => 'long',
            'show_next_prev' => true,
            'next_prev_url' => base_url() . 'admin/doctor/appointment/' . $this->session->userdata('doctor_id')
        );

        $this->conf['template'] = '
			{table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}
			
			{heading_row_start}<tr>{/heading_row_start}
			
			{heading_previous_cell}<th><a href="{previous_url}">
                        <img src="/images/previous_icon.png" border="0">
                        </a></th>{/heading_previous_cell}
			{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
			{heading_next_cell}<th><a href="{next_url}">
                        <img src="/images/next_icon.png" border="0">
                        </a></th>{/heading_next_cell}
			
			{heading_row_end}</tr>{/heading_row_end}
			
			{week_row_start}<tr>{/week_row_start}
			{week_day_cell}<td>{week_day}</td>{/week_day_cell}
			{week_row_end}</tr>{/week_row_end}
			
			{cal_row_start}<tr class="days">{/cal_row_start}
			{cal_cell_start}<td class="day">{/cal_cell_start}
			
			{cal_cell_content}
				<div class="day_num">{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content}
			{cal_cell_content_today}
				<div class="day_num highlight">{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content_today}
			
			{cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
			
			{cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			{cal_cell_end}</td>{/cal_cell_end}
			{cal_row_end}</tr>{/cal_row_end}
			
			{table_close}</table>{/table_close}
		';
    }

    function get_calendar_data($year, $month, $doctor_id = '', $user_id = '') {
        if ($doctor_id == '')
            $doctor_id = $this->session->userdata('doctor_id');
        // $this->load->model('common_model');
        $sql = 'SELECT  CONCAT_WS("|", id, timing) as info,  
                        `date`, 
                        if ((paid=1 AND doctor_id=' . $doctor_id;
        if ($user_id <> "")
            $sql .= ' AND user_id = ' . $user_id;
        $sql .= '),
                                CONCAT(`data`, "<br>PAID"),
                                        if ((paid=1 AND doctor_id=' . $doctor_id;
        if ($user_id <> "")
            $sql .= ' AND user_id <> ' . $user_id;
        $sql .= '),
                                                                "<br><img src=\"/images/reserved.gif\" border=\"0\">", 
                                                        if ((paid <> 1 AND doctor_id=' . $doctor_id;
        if ($user_id <> "")
            $sql .= ' AND user_id = ' . $user_id;
        $sql .= '),
                                                                        CONCAT(`data`, "<br><br><a href=\"javascript: submit_to_paypal(\'Dr. Website Appointment Payment - ", `data`, "\',", `id`, ");\"><img src=\"/images/paynow.gif\" border=\"0\"></a>"),
                                                                if ((paid <> 1 AND doctor_id=' . $doctor_id;
        if ($user_id <> "")
            $sql .= ' AND user_id <> ' . $user_id;
        $sql .= '),
                                                                                "", 1	
                                    )))) as `data`
                FROM (`calendar`) 
                WHERE `date` LIKE \'' . $year . '-' . $month . '%\'  AND
                        doctor_id=' . $doctor_id;
        //print $sql;
        $query = $this->db->query($sql);

        $cal_data = array();
        foreach ($query->result() as $row) {
            $day_num = substr($row->date, 8, 2);
            if ($day_num < 10)
                $day_num = substr($row->date, 9, 1);
            $cal_data[$day_num] = $row->data . '<span style="display:none" id="calid">' . $row->info . '</span>';
        }

        return $cal_data;
    }

    function add_calendar_data($date, $data, $doctor_id, $user_id = '', $timing) 
    {
        $ret_id = 0;
        if ($this->db->select('date')->from('calendar')
                        ->where('date', $date)->count_all_results()) 
        {
            $sql = 'UPDATE calendar SET 
                                        data="' . $data . '", 
                                        doctor_id="' . $doctor_id . '",
                                        timing=STR_TO_DATE("' . $timing . '", "%h:%i %p"),
                                        user_id="' . $user_id . '" 
                    WHERE date="' . $date . '" ';                                            
            $this->db->query($sql);
            $ret_id = $this->db->select('id')->from('calendar')->where('date', $date)->get()->row('id');
        } else {
            $sql = "INSERT INTO calendar (date, data, doctor_id, timing, user_id) VALUES ('$date', '$data', '$doctor_id', STR_TO_DATE('$timing', '%h:%i %p'), '$user_id');";
            $this->db->query($sql);
            $ret_id = $this->db->insert_id();  
        }        
        //print  $this->db->last_query();
        //print  '<br>ret_id: ' . $ret_id;
        return $ret_id;
    }

    function generate($year, $month, $doctor_id, $user_id) {

        $this->load->library('calendar', $this->conf);
        // $cal_data = $this->get_calendar_data($year, $month, $doctor_id, $user_id);
        return $this->calendar->generate($year, $month); //, $cal_data);
    }

}

?>
