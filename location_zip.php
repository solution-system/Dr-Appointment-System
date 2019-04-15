<?php
session_start();
include_once("include/common.php");
$rec = '';
$sql='SELECT	 DISTINCT zipcode
	    FROM 	 us_city
	    WHERE    UPPER(state)='  . tosql(strtoupper(get_param("state")), "Text") . ' AND
	             UPPER(city)='  . tosql(strtoupper(get_param("city")), "Text") . '
	    ORDER BY zipcode;';
// print $sql;
$db->query($sql);
$nr = $db->next_record();
if (!$nr)
   $rec  = 'No zipcode found...';
else
{
   $rec .= '<ul>';
   while ($nr)
   {
   	$rec .= '<li><a href="/locate/result/' . get_param("state") . '-us-state/' . get_param("city") . '-us-city/' . $db->f("zipcode") . '-zipcode">' . $db->f("zipcode") . '</li>' ;
   	$nr = $db->next_record();
   }
   $rec .= '</ul>';
}
print $rec;
?>