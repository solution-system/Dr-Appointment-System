<?php
class State_xml extends MY_Common {

    function __construct() { //this could also be called function User(). the way I do it here is a PHP5 constructor
        parent::__construct();
    }

    public function index() {
    	header('Content-type: text/xml');
		$this->load->dbutil();
		$sql = 'SELECT `region`, `code` FROM `us_states` GROUP BY `region`, `code` ORDER BY `region`';
		$query = $this->db->query($sql);
		// $query = 'SELECT * from us_state';
		$config = array (
		        'root'          => 'root',
		        'element'       => 'element',
		        'newline'       => "\n",
		        'tab'           => "\t"
		);
		echo $this->dbutil->xml_from_result($query, $config);
	}
}
?>