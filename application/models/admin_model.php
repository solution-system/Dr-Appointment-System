<?php
class Admin_model extends CI_Model
{
   public function verify_user($user_name, $password, $table)
   {
      $q = $this
            ->db
            ->where('username', $user_name)
            ->where('pass', $password)
            ->limit(1)
            ->get($table);

      if ( $q->num_rows > 0 ) {
         // person has account with us
         return $q->row();
      }
      return false;
   }
   function verify_pass($old_password, $user_type)
   {
      if ($user_type == "")
      {
         redirect('/message/alert/prohibited/');
         exit();
      }
      $q = $this
            ->db
            ->where('id', $this->session->userdata('uid'))
            ->where('password', $old_password)
            ->limit(1)
            ->get($user_type);

      // print $this->db->last_query();
      // exit();
      // print '<hr>num: ' . $q->num_rows();
      if ( $q->num_rows() > 0 ) {
         // person has account with us
         return true;
      }
      return false;
   }
   public function verify_user_user($username, $password, $table)
   {
      $q = $this
            ->db
            ->where('username', $username)
            ->where('password', $password)
            ->limit(1)
            ->get($table);

      if ( $q->num_rows > 0 ) {
         // person has account with us
         return $q->row();
      }
      return false;
   }
   function verify_pass_user($username, $old_password, $table)
   {
      $q = $this
            ->db
            ->where('username', $username)
            ->where('password', $old_password)
            ->limit(1)
            ->get($table);

      if ( $q->num_rows > 0 ) {
         // person has account with us
         return $q->row();
      }
      return false;
   }
}
?>