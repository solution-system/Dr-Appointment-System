<?php

class Common_model extends CI_Model {

//   function __construct()
//   {
//
//   }
    function f($table, $fld, $id) {
        $this->db->select($fld);
        $this->db->from($table);
        $this->db->where('id', $id);
        $q = $this->db->get();
        $rec = $q->row($fld);
        return $rec;
    }

    function get($table, $where = array(), $single = FALSE) {
        // print $where;

        $q = $this->db->get_where($table, $where);
        $result = $q->result_array();
        if (count($result)) {
            if ($single) {
                // print 'if get';
                return $result[0];
            }
            return $result;
        }
        else
            return "";
    }

    function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function update($table, $where = array(), $data) {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    function delete($table, $where = array()) {
        $this->db->delete($table, $where);
        return $this->db->affected_rows();
    }

    function explicit($query) {
        // print 'query: ' . $query . '<br>';
        $q = $this->db->query($query);
        // print '$q->num_rows(): ' . $q->num_rows() . '<br>';
        if ($q->num_rows() > 0) {
            if (is_object($q)) {
                //print 'if 2';
                return $q->result_array();
            } else {
                //print 'else @ explicit';
                return $q;
            }
        }
    }

    function scalar($table, $field, $where = "", $where_not = "") {
        $this->db->select($field); #Because I need the value
        if ($where <> "")
            $this->db->where($where);#Because I need the variable column    entitled siteoverview
        if ($where_not <> "")
            $this->db->where($where_not);#Because I need the variable column    entitled siteoverview
        $query = $this->db->get($table); #From the settings table
        if ($query->num_rows() > 0) {
            $row = $query->row_array(); // get the row
            return $row[$field]; // return the value
        }
    }
    
}

?>