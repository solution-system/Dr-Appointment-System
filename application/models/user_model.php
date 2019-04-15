<?php

class User_model extends CI_Model {

    private $sql;

    function __construct() {
        $this->sql = '';
    }

    // get total number of services
    function getNum_Service() {
        return $this->db->count_all('service');
    }

    // get all user
    function getUsers($field = '', $sWhere = '', $page_no, $display) {
        $this->sql = 'SELECT   id,
                              name,
                              email,
                              company_email,
                              address,
                              city,
                              state,
                              zip,     
                              CONCAT("<a href=\"/admin/doctor/appointment/", u.id, "\"><img src=\"/images/apppointment.png\" border=0></a>") as appointment,                              
                              (SELECT d.name FROM doctor d WHERE u.doctor=d.id) as doctor,
                              IF (active=1,
                                    CONCAT("<a id=\"active_link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_active(", id , ", 1, \'user\');\"><img id=\"active_", id , "\" src=\"/images/banned_0.png\" title=Active alt=Active border=\"0\"></a>"),
                                       CONCAT("<a id=\"active_link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_active(", id , ", 0, \'user\');\"><img id=\"active_", id , "\" src=\"/images/banned_1.png\" title=In-active alt=In-active border=\"0\"></a>")) as active,
                              IF (ban=1,
                                 CONCAT("<a id=\"link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_banned(", id , ", 1, \'user\');\"><img id=\"ban_", id , "\" src=\"/images/banned_1.png\" border=\"0\"></a>"),
                                    CONCAT("<a id=\"link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_banned(", id , ", 0, \'user\');\"><img id=\"ban", id , "\" src=\"/images/banned_0.png\" border=\"0\"></a>")) as banned
               FROM user u ';
        if ($sWhere <> "") {
            $this->sql .= ' WHERE   ' . $field . ' LIKE \'%' . $sWhere . '%\' ';
            if ($this->session->userdata('ulevel') <> '0')
                $this->sql .= ' u.doctor=' . $this->db->escape($this->session->userdata('uid'));
        }
        if ($this->session->userdata('ulevel') <> '0')
            $this->sql .= ' WHERE u.doctor=' . $this->db->escape($this->session->userdata('uid'));
        $this->sql .= '   ORDER by u.name ';
        
        if ($page_no == "")
            $this->sql .= " LIMIT	0, " . $display;
        else {
            if ($page_no == "1")
                $page_no = 0;
            $this->sql .= " LIMIT	" . $page_no . ", " . $display;
        }
        // print $this->sql;
        $query = $this->db->query($this->sql);
        if ($query->num_rows() > 0) {
            // return result set as an associative array
            return $query->result_array();
        }
    }

    // get total number of user
    function getNumUsers() {
        return $this->db->count_all('user');
    }

    // get all user
    function getUS_State() {
        $this->db->select('region, code');
        $this->db->from('us_states');
        $this->db->order_by('region');
        $this->db->group_by("region");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            // return result set as an associative array
            return $query->result_array();
        }
    }

    // get total number of user
    function getNum_USStates() {
        return $this->db->count_all('us_states');
    }

    function user_insert($user_data) {
        $tbl = $this->db->dbprefix('user');

        $this->db->insert($tbl, $user_data);

        return !$this->db->affected_rows() == 0;
    }

    function deleteUser($id) {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

}

?>