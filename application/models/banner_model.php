<?php
class Banner_model extends CI_Model
{
   function __construct()
   {

   }
   function banner_load($id)
   {
      return $this->db->get_where('banners', array('id' => $id))->result();
   }

   // get all banners
   function getBanners()
   {
      $this->db->from('banners');
      $this->db->order_by('name');
      $query = $this->db->get();
      if ($query->num_rows()>0)
      {
         // return result set as an associative array
         return $query->result_array();
      }
   }
   function getBannersWhere($field,$param)
   {
      $this->db->like($field,$param);
      $query=$this->db->get('banners');
      // return result set as an associative array
      return $query->result_array();
   }
   // get total number of banners
   function getNumBanners()
   {
      return $this->db->count_all('banners');
   }

   function banner_insert( $banner_data )
   {
      $tbl = $this->db->dbprefix('banners');

      $this->db->insert($tbl, $banner_data);

      return !$this->db->affected_rows() == 0;
   }
   function deleteBanner($id)
   {
      $this->db->where('id', $id);
      $this->db->delete('banners');
   }
}
?>