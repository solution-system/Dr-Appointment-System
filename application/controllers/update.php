<?php

class Update extends CI_Controller 
{
    public function index()
    {
        $calid = $this->uri->segment(3);
        $sql = 'UPDATE calendar SET paid=1 WHERE id=' . $this->db->escape($calid);
        $this->db->query($sql);
        redirect(base_url() . '/message/success/');
    }
}
?>
