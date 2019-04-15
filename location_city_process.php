<?php
function city_process($alphabet, $state, $i)
{
    $temp = '';
    $sql = 'SELECT COUNT(city) FROM us_city WHERE state=\'' . strtoupper($state) . '\' AND UPPER(city) like \'' . $alphabet . '%\'';
    $count = get_db_value($sql);
    //if ($count == "0")
    //  return false;
    //else
    //{
      if (($i % 7) == "0")
         $temp .= '<div class="alphabet w224">';
      else if (($i % 2) == "1")
         $temp .= '<div class="alphabet"> ';
      $temp .= ' <div class="col">
              	  <div class="alpha-left"><h4>' . $alphabet . '</h4> </div>';
      global $db;
      $sql = 'SELECT DISTINCT city from us_city WHERE state=\'' . strtoupper($state) . '\' AND UPPER(city) like \'' . $alphabet . '%\' ORDER BY city;';
      // print 'sql: ' . $sql;
      $db->query($sql);
      $nr = $db->next_record();
      if ($nr)
      {
         $temp .= '
              <div class="alpha-right">
              	<ul>';
              	while ($nr)
              	{
      	            // $temp .= '<li>' . $db->f("city") . ' ==> 8: ' . ($i % 8) .  ' ==> 2: ' . ($i % 2) . '</li>';
      	            $temp .= '<li><a href="javascript: show_state_city_zip(\'' . $state . '\', \'' . $db->f("city") . '\');">' . $db->f("city") . '</a>
                               	    <span id="locate_' . $state . '_' . $db->f("city") . '"></span>
      	                      </li>';
      	            $nr = $db->next_record();
              	}
                $temp .= '
                </ul>
              </div>
              <div class="clear"></div>
               ';
     }
     else
      $temp .= '<div class="alpha-right">
              	<ul><li></li>
                </ul>
              </div>
              <div class="clear"></div>';
     $temp .= ' </div> ';
     if (($i % 2) == "0")
        $temp .= '</div>';
     return $temp;
   //}
}