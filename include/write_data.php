<?php
session_start();
include_once("common.php");
$w = get_param("data");
write_data($w);
?>