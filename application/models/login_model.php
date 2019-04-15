<?php
class Login_model extends CI_Model
{
   public function verify_user($username, $password, $table)
   {
      $q = $this
            ->db
            ->where('username', $username)
            ->where('password', $password)
            ->where('ban', NULL)
            ->where('active', 1)
            ->limit(1)
            ->get($table);
      // print $this->db->last_query();
      // print '$q->num_rows: ' . $q->num_rows . ')';
      if ( $q->row() > 0 ) {
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