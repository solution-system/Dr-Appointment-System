<?php
session_start();
include_once("include/common.php");
if (get_param("FormAction") == "get_state_cities_zip")
{
   $rec = '';   
   $sql='SELECT	 DISTINCT zipcode, city
   	    FROM 	 us_city
   	    WHERE    state='  . tosql(get_param("state"), "Text") . '
   	    ORDER BY zipcode DESC, city;';
	// print $sql;
	$db->query($sql);
	$nr = $db->next_record();
	while ($nr)
	{
		$rec .= get_param("state") . ',' . $db->f("city") . ',' . $db->f("zipcode") . '|' ;
		$nr = $db->next_record();
	}
	print $rec;
}
else if (get_param("FormAction") == "get_cities") 
{
   $sql="SELECT	DISTINCT city
   	   FROM 		us_city
   	   WHERE    state=" . tosql(get_param("state"), "Text") . '
   	   ORDER BY city';
   	// print $sql;
   	$db->query($sql);
   	$nr = $db->next_record();
      $rec = '<table>
               <tr>';
   	while ($nr)
   	{
   	  $i++;
   		$rec .= '<td nowrap><input  onclick="javascript: get_zip(\'' . get_param("state") . '\', \'' . $db->f("city") . '\')"
   		                            name="city"
   		                            type="radio"
   		                            id="' . str_replace(' ', '_', $db->f("city")) . '">' . $db->f("city") . '
                  </td>
   	    	  	';
         if (($i % 5) == "0")
            $rec .= '</tr><tr>';
   		$nr = $db->next_record();
   	}
   	print $rec . '</table>';
}
else if (get_param("FormAction") == "get_zip")
{
   $city = str_replace('_', ' ', get_param("city"));
       $sql='SELECT	 DISTINCT zipcode
      	    FROM 	 us_city
      	    WHERE    state='  . tosql(get_param("state"), "Text") . ' AND
      	             city=' . tosql($city, "Text") . '
      	    ORDER BY zipcode DESC';
   	// print $sql;
   	$db->query($sql);
   	$nr = $db->next_record();
      $rec = '<table border=0>
                  <tr><td nowrap>Selected City:<strong> ' . $city . '</strong></td></tr>
               ';
      // $rec .= '<tr><td>' . $sql . '</td></tr>';         
   	while ($nr)
   	{
   	  $i++;
   		$rec .= '<tr><td nowrap><input  onclick="javascript: get_selected(this.checked, \'' . get_param("state") . '\', \'' . get_param("city") . '\', \'' . $db->f("zipcode") . '\')"
      		                             name="zip' . $i . '"
      		                             type="checkbox"
      		                             value="' . $db->f("zipcode") . '"
      		                             id="' . $db->f("zipcode") . '">' . $db->f("zipcode") . '
                  </td><tr>
   	    	  	';
   		$nr = $db->next_record();
   	}
   	print $rec . '</table>';
}
?>