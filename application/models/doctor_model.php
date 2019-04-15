<?php
class Doctor_model extends CI_Model
{
   private $sql;
   function __construct()
   {
      $this->sql = '';
   }
   function get_Service($doctor_id="", $area='')
   {
      $this->load->model('common_model');
      $this->sql = 'SELECT   s.* ';
      // if ($doctor_id <> "")
         $this->sql .= ',
                        (if (s.id in (SELECT 	us.frn_service
                                      FROM 		doctor_service us
                                      WHERE 	   us.frn_user=' . $this->db->escape($doctor_id) . '), "CHECKED", "")) as is_selected ';
      $this->sql .= ' FROM     service s  ';
      if ($area == '')
      {
         if ($doctor_id <> "")
            $this->sql .= ' WHERE s.id in (SELECT 	us.frn_service
                                           FROM 	doctor_service us
                                           WHERE 	us.frn_user=' . $this->db->escape($doctor_id) . ') ';
      }         								    
      $this->sql .= ' ORDER BY s.name;';
       // print 'sql: ' . $this->sql;
       return $this->common_model->explicit($this->sql);
   }
   // get total number of services
   function getNum_Service()
   {
      return $this->db->count_all('service');
   }
   // get all user
   function getDoctor($field='', $sWhere='', $page_no, $display)
   {
      $this->sql = 'SELECT   id,
                              name,
                              email,
                              company_email,
                              address,
                              city,
                              state,
                              zip,
                              CONCAT("<a href=\"/admin/doctor/appointment/", u.id, "\"><img src=\"/images/apppointment.png\" border=0></a>") as appointment,                              
                              IF (active=1,
                                    CONCAT("<a id=\"active_link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_active(", id , ", 1, \'user\');\"><img id=\"active_", id , "\" src=\"/images/banned_0.png\" title=Active alt=Active border=\"0\"></a>"),
                                       CONCAT("<a id=\"active_link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_active(", id , ", 0, \'user\');\"><img id=\"active_", id , "\" src=\"/images/banned_1.png\" title=In-active alt=In-active border=\"0\"></a>")) as active,
                              IF (ban=1,
                                 CONCAT("<a id=\"link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_banned(", id , ", 1, \'user\');\"><img id=\"ban_", id , "\" src=\"/images/banned_1.png\" border=\"0\"></a>"),
                                    CONCAT("<a id=\"link", id , "\" href=\"javascript:void(0);\" OnClick=\"javascript:rec_banned(", id , ", 0, \'user\');\"><img id=\"ban", id , "\" src=\"/images/banned_0.png\" border=\"0\"></a>")) as banned
               FROM doctor u ';
      if ($sWhere <> "")
         $this->sql .= ' WHERE   ' . $field . ' LIKE \'%' . $sWhere . '%\' ';
      $this->sql .= '   ORDER by u.name ';
      if ($page_no=="")
          $this->sql .=	" LIMIT	0, " . $display;
      else
      {
        if ($page_no == "1")
            $page_no=0;
        $this->sql .=	" LIMIT	" . $page_no . ", " . $display;
      }
      $query = $this->db->query($this->sql);
      if ($query->num_rows() > 0)
      {
         // return result set as an associative array
         return $query->result_array();
      }
   }
   // get total number of doctor
   function getNumDoctor()
   {
      return $this->db->count_all('doctor');
   }
   // get all doctor
   function getUS_State()
   {
      $this->db->select('region, code');
      $this->db->from('us_states');
      $this->db->order_by('region');
      $this->db->group_by("region, code");

      $query = $this->db->get();
      if ($query->num_rows()>0)
      {
         // return result set as an associative array
         return $query->result_array();
      }
   }
   // get total number of doctor
   function getNum_USStates()
   {
      return $this->db->count_all('us_states');
   }
   function doctor_insert( $doctor_data )
   {
      $tbl = $this->db->dbprefix('doctor');

      $this->db->insert($tbl, $doctor_data);

      return !$this->db->affected_rows() == 0;
   }
   function deleteUser($id)
   {
      $this->db->where('id', $id);
      $this->db->delete('doctor');
   }   
}
?>