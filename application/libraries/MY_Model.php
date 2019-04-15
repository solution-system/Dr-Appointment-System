<?php
class MY_model extends CI_Model
{
   function chk_zip($str, $type='count')
   {
      $b = 0;
      if ($str == "")
         return "";
      $zip = '';
      // print 'str @ chk_zip: ' . $str . '<br>';
      $arr = preg_split("/[\s,]+/", $str);
      $this->load->model('common_model');
   	for ($a=0; $a < count($arr); $a++)
   	{
   	   $w = trim($arr[$a]);
   	   // print 'w @ chk_zip: ' . $w . '<br>';
         if ((strlen($w) == "5") and (is_numeric($w)))
         {
            $sql = "SELECT   count(*) as c
                    FROM     us_city
                    WHERE    zipcode=" . $this->db->escape($w);
            // print 'chk_zip: ' . $sql . '<br>'; 
            $total = $this->db->query($sql)->row()->c;
            if ($type == 'count')
               return $total;
   		   // print 'total @ chk_zip: ' . $total . '<br>';
   			if ($total)
   			{
   				if ($b > 0)
   				  $zip .= '+';
   				$zip .= $w;
   				$b++;
   				// print 'zip @ chk_zip: ' . $zip . '<br>';
   			}
   		}
   	}
   	// print 'TOTAL zip @ chk_zip: ' . $zip . '<br>';
   	return $zip;
   }
   function state_shortform_chk($str)
   {
      // // // print '<br>str: ' . $str . '<br>';
      $arr = explode(",","AL,AK,AO,AZ,AR,CA,CO,CT,DE,DC,FL,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,US,UT,VT,VA,WA,WE,WV,WI,WY");
   	$state = '';
   	$words = preg_split("/[\s,]+/", $str);
   	for ($a=0; $a < count($words); $a++)
   	{
   	   $w = trim($words[$a]);
   	   // // // print '<br>w: ' . $w . '<br>';
         if (strlen($w) == "2")
         {
            $b = 0;
      		for ($i=0;$i<count($arr);$i++)
      		{
               // // // print '<br>' . strtoupper($w) . '==' . $arr[$i];
      			if (strtoupper($w) == $arr[$i])
      			{
      				if ($b > 0)
      				  $state .= '+';
      				$state .=  $this->state_chk('', $i) . ',' . $w;
      				// $arr[$i];
      				$b++;
      			}
      		}
   	  }
   	}
   	return $state;
   }

   function state_chk($str, $get_state='')
   {
      $state = '';
      $arr = explode(",","Alabama,Alaska,AOL,Arizona,Arkansas,California,Colorado,Connecticut,Delaware,District of Columbia,Florida,Hawaii,Idaho,Illinois,Indiana,Iowa,Kansas,Kentucky,Louisiana,Maine,Maryland,Massachusetts,Michigan,Minnesota,Mississippi,Missouri,Montana,Nebraska,Nevada,New Hampshire,New Jersey,New Mexico,New York,North Carolina,North Dakota,Ohio,Oklahoma,Oregon,Pennsylvania,Rhode Island,South Carolina,South Dakota,Tennessee,Texas,United States,Utah,Vermont,Virginia,Washington,WebTV,West Virginia,Wisconsin,Wyoming");
      if ($get_state<>"")
      {
           return strtolower($arr[$get_state]);
      }
      else
      {
          $a = 0;
      	for ($i=0;$i<count($arr);$i++)
      	{
      		if (stristr($str, $arr[$i]))
      		{
      			if ($a > 0)
      			  $state .= '+';
      			$state .= strtolower(str_replace(' ', '-', $arr[$i])) . ',' . $arr[$i];
      			$a++;
      		}
      	}
      }
      return $state;
   }
   function get_service($str)
   {
      $service = '';
      $arr = explode(",","Mold,Water,Fire,Energy,Home");
      $a = 0;
      for ($i=0;$i<count($arr);$i++)
      {
      	if (stristr($str, $arr[$i]))
      	{
      		if ($a > 0)
      		  $service .= '+';
      		$service .= strtolower($arr[$i]);
      		$a++;
      	}
      }
      return $service;
   }
}   
?>