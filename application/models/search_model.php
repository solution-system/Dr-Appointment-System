<?php
class Search_model extends MY_Model
{
   function __construct()
   {
       parent::__construct();
   }
    public function extract_no_str($string, $typed)
	 {
      $ret = '';
      $chars = '';
      $nums = '';
      $str   = False;
      // print '<br>extract_no_str($string,: ' . $string;
      for ($index=0; $index<strlen($string); $index++) { 
          if (( ctype_digit($string[$index]) ) or ( ($string[$index] == '-') ))
          {
              if ($str)  $nums .= ' ';
                $nums .= $string[$index];
                $str   = False;
           }else{
              if (!$str)  $chars.= ' ';
                $chars .= $string[$index];
                $str    = True;
          }
      } 
      // print "Chars: $chars<br >Nums: $nums";
      if ($typed == 'no')
         $ret = $nums;
      else
         $ret = $chars;
      // exit();
      return $ret;
	 }
   function update_search_string($txt, $keyword, $varname)
   {
       $search_url = $txt . '-' . $varname . '/';
       $arr = explode(' ', $txt);
       for ($i=0; ($i < count($arr)); $i++)
       {
         if (trim($keyword) == "")
            break;
         $varname = strtolower($arr[$i]);
         // print '<br>$varname: ' . $varname . '<br>';
         // print '<br>keyword b4: ' . $keyword . '<br>';
         $keyword = trim(preg_replace('/' . $varname . '/', '', $keyword));
         // print '<br>keyword after: ' . $keyword . '<br>';
       }
       $keyword = preg_replace('/\s\s+/', ' ', $keyword);
       if (($varname <> 'zipcode') and ($varname <> 'phone'))
         $this->session->set_userdata('keyword', $keyword);
       else
         $this->session->set_userdata('keyword_no', $keyword);
       $this->session->set_userdata('search_url', $this->session->userdata("search_url") . str_replace(' ', '+', $search_url));
       // print '<br>search URL: ' . $this->session->userdata("search_url") . '<br>';
       // print '<br>Keyword: ' . $this->session->userdata("keyword") . '<br>';
   }
   function chk_string_by_like($table, $field, $type='count')
   {
      $keyword = str_replace(' ', '|', $this->session->userdata("keyword"));
      if ($keyword == "")
        return -1;
      $sql = '';
      if ($type == 'count')
      {
         $sql = 'SELECT   COUNT(' . $field . ') as total
                 FROM     ' . $table . '  u
                 WHERE    ' . $field . " LIKE '%" . $keyword . "%' AND
                          (!IFNULL(ban, 0)) AND
                          (active=1) AND
                          ((NOW() > u.membership_start) AND (NOW() < u.membership_end));";
         return $this->db->query($sql)->row()->total;
       }
       else
       {
            $sql = 'SELECT   DISTINCT LOWER(' . $field . ') as fld
                    FROM     ' . $table . '  u
                    WHERE    ' . $field . " LIKE '%" . $keyword . "%' AND
                              (!IFNULL(ban, 0)) AND
                              (active=1) AND
                              ((NOW() > u.membership_start) AND (NOW() < u.membership_end))
                     LIMIT 1;";

           // print $sql . '<hr>';
           $q = $this->db->query($sql);
           if ($q->num_rows() > 0)
           {
             if(is_object($q))
             {
                if ($q->num_rows() == "1")
                   return $this->db->query($sql)->row()->fld;
                else
                {
                    $rec = '';
                    $temp = $q->result_array();
                    foreach($temp as $t):
                       $rec .= $t["fld"] . ' ';
                    endforeach;
                    $rec = substr($rec, 0, (strlen($rec)-1));
                    // print('rec: ' . $rec);
                    return $rec;
                }
             }
             else
             {
               return $q;
             }
           }
       }
   }
   function chk_string_by_locate($table, $field, $type='count')
   {
      if ($table == 'service_subtype')
         $service = $this->session->userdata("service_selected");
      else
         $service = '';
      $keyword = str_replace(' ', '|', $this->session->userdata("keyword"));
      if ($keyword == "")
        return -1;
      $sql = '';
      if ($type == 'count')
      {
         $sql = 'SELECT   COUNT(' . $field . ') as total
                 FROM     ' . $table . '
                 WHERE    ' . $field . " REGEXP '[[:<:]]" . $keyword . "[[:>:]]' ";
         if (($table == "service_subtype") and ($service <> ""))
              $sql .= ' AND frn_service=(SELECT s.id FROM service s WHERE s.name="' . $service . '") ';
         if ($table == ' user ')
            $sql .= '
                      AND (!IFNULL(ban, 0))
                      AND (active=1)
                      AND ((NOW() > u.membership_start) AND (NOW() < u.membership_end)) ';
         $sql .= '; ';
         // if ($table == "business_name")
         // // print $sql . '<hr>';
         return $this->db->query($sql)->row()->total;
       }
       else
       {
            $sql = 'SELECT   DISTINCT LOWER(' . $field . ') as fld
                    FROM     ' . $table . '
                    WHERE    ' . $field . " REGEXP '[[:<:]]" . $keyword . "[[:>:]]' ";
            if (($table == "service_subtype") and ($service <> ""))
               $sql .= ' AND frn_service=(SELECT s.id FROM service s WHERE s.name="' . $service . '") ';
           if ($table == ' user ')
               $sql .= '
                         AND (!IFNULL(ban, 0))
                         AND (active=1)
                         AND ((NOW() > u.membership_start) AND (NOW() < u.membership_end)) ';
           $sql .= ' LIMIT 1 ';
           // print $sql . '<hr>';
           $q = $this->db->query($sql);
           if ($q->num_rows() > 0)
           {
             if(is_object($q))
             {
                if ($q->num_rows() == "1")
                   return $this->db->query($sql)->row()->fld;
                else
                {
                    $rec = '';
                    $temp = $q->result_array();
                    foreach($temp as $t):
                       $rec .= $t["fld"] . ' ';
                    endforeach;
                    $rec = substr($rec, 0, (strlen($rec)-1));
                    // print('rec: ' . $rec);
                    return $rec;
                }    
             }
             else
             {
               return $q;
             }
           }
       }   
   }
   function chk_string($table, $field, $type='count')
   {
      if ($table == 'service_subtype')
         $service = $this->session->userdata("service_selected");
      else
         $service = '';
      if ($table == 'us_city')
         $us_state = $this->session->userdata("us_state");
      else
         $us_state = '';
      if (($field == 'phone1') or ($field == 'phone2'))
         $keyword = trim($this->session->userdata("keyword_no"));
      else
         $keyword = trim($this->session->userdata("keyword"));
      if ($keyword == "")
        return "-1";
      $sql = '';
      if ($type == 'count')
      {
         $sql = "SELECT    COUNT(IF(MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . "  IN BOOLEAN MODE), 1, NULL)) as total
                 FROM      " . $table . "
                 WHERE     MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . "  IN BOOLEAN MODE)  ";
         if ($table == ' user ')
            $sql .= '
                      AND (!IFNULL(ban, 0))
                      AND (active=1)
                      AND ((NOW() >= u.membership_start) AND (NOW() <= u.membership_end)) ';
         if (($table == "service_subtype") and ($service <> ""))
            $sql .= ' AND frn_service=(SELECT s.id FROM service s WHERE s.name="' . $service . '") ';
         if (($table == "us_city") and ($us_state <> ""))
            $sql .= ' AND (LOWER(state_name)="' . $us_state . '") ';
         $sql .= " ORDER BY  total desc;";
         // if ($field == 'business_name')
         //   print $sql . '<hr>';
         return $this->db->query($sql)->row()->total;
       }
       else
       {
         $sql = "SELECT    DISTINCT LOWER(" . $field . ") as fld,
                           MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . "  IN BOOLEAN MODE) as Relevance
                  FROM      " . $table . "
                  WHERE     MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . "  IN BOOLEAN MODE)   ";
         if ($table == ' user ')
            $sql .= '
                      AND (!IFNULL(ban, 0))
                      AND (active=1)
                      AND ((NOW() > u.membership_start) AND (NOW() < u.membership_end)) ';
         if (($table == "service_subtype") and ($service <> ""))
              $sql .= ' AND frn_service=(SELECT s.id FROM service s WHERE s.name="' . $service . '") ';
         if (($table == "us_city") and ($us_state <> ""))
            $sql .= ' AND (LOWER(state_name)="' . $us_state . '") ';
         $sql .= "
                  HAVING Relevance  = MAX(Relevance )
                  ORDER BY  Relevance desc
                  LIMIT 1;";
         // print $sql . '<hr>';
         $q = $this->db->query($sql);
         if ($q->num_rows() > 0)
         {
            if(is_object($q))
            {
               if ($q->num_rows() == "1")
                  return $this->db->query($sql)->row()->fld;
               else
               {
                   $rec = '';
                   $temp = $q->result_array();
                   foreach($temp as $t):
                      $rec .= $t["fld"] . '+';
                   endforeach;
                   $rec = substr($rec, 0, (strlen($rec)-1));
                   // print('rec: ' . $rec);
                   return $rec;
               }    
            }
            else
            {
              return $q;
            }
         }
       }   
   }
   function contain_service()
   {
      $keyword = trim($this->session->userdata("keyword"));
      $service_selected = $this->get_service($keyword);
      // print '<br>ss: ' . $service_selected . '<br>';
      if ($service_selected <> "")
      {
         $this->session->set_userdata('service_selected', $service_selected);
         $arr = explode("+", $service_selected);
         $a = 0;
         $service_selected = '';
      	for ($i=0;$i<count($arr);$i++)
      	{
      	   if ($a > 0)
      	     $service_selected .= ' ';
      	   $service_selected .= str_replace('-', ' ', $arr[$i]);
      	   $a++;
         }
         // print '<br>ss: ' . $i . '- ' . $service_selected . '<br>';
         // print '<br>keyword: ' . $i . '- ' . $keyword . '<br>';
         $this->update_search_string($service_selected, $keyword, "service");
      }
   }
   function contain_service_subtype()
   {
       $keyword = trim($this->session->userdata("keyword"));
       // print '<br>keyword 2- ' . $keyword . '<br>';
       $co = $this->chk_string_by_locate("service_subtype", "sub_type");
       // print '<br>co1 @ contain_service_subtype: ' . $co . '<br>';
       if ($co > 0)
       {
           $sub_type = $this->chk_string_by_locate("service_subtype", "sub_type", "value");
           $this->update_search_string($sub_type, $keyword, "sub-type");
           
       }
       else
       {
          $co = $this->chk_string("service_subtype", "sub_type");
          // print '<br>co 2 @ contain_service_subtype: ' . $co . '<br>';
         if ($co > 0)
         {
             $sub_type = $this->chk_string("service_subtype", "sub_type", "value");
             $this->update_search_string($sub_type, $keyword, "sub-type");
             
         }
       }
   }
   function contain_us_state()
   {
        $keyword = trim($this->session->userdata("keyword"));
        $to_remove = '';
        $to_url = '';
        $us_state = '';
        $temp_state = '';
        $temp_state .= $this->state_chk($keyword);
        // print '<br>$temp_state: ' . $temp_state;

         if ($temp_state <>"")
            $us_state .= $temp_state;
         else
            $us_state .= $this->state_shortform_chk($keyword);
         // print '<br>$us_state: ' . $us_state;
         $temp_state = '';
         // print '<br>us-state: ' . $us_state . '<br>';
         if ($us_state <>"")
         {
             $this->session->set_userdata('us_state', $us_state);
             $arr = explode("+", $us_state);
             $a = 0;
       		for ($i=0;$i<count($arr);$i++)
       		{
               $usa = explode(",", $arr[$i]);
               $to1 = $usa[1];
               $to2 = $usa[0];
               if ($a > 0)
               {
                   $to_remove .= ' ' . $to1;
                   $to_url .= '-' . $to2;
               }
               else
               {
                   $to_remove = $to1;
                   $to_url .= $to2;
               }
       		   $a++;
             }
             $this->session->set_userdata('us_state', $to_url);
             $this->update_search_string($to_remove, $keyword, "us-state");
         }
   }
   function contain_city()
   {
        $keyword = trim($this->session->userdata("keyword"));
        $co = $this->chk_string("us_city", "city");
        if ($co > 0)
        {
            $city = $this->chk_string("us_city", "city", "value");
            $this->session->set_userdata('city', $city);
            $this->update_search_string($city, $keyword, "us-city");            
        }
        else
        {
        	   $co = $this->chk_string_by_locate("us_city", "city");
            if ($co > 0)
            {
                $city = $this->chk_string_by_locate("us_city", "city", "value");
                $this->session->set_userdata('city', $city);
                $this->update_search_string($city, $keyword, "us-city");            
            }
        }
   }
   function contain_zipcode($keyword)
   {
        // $keyword = trim($this->session->userdata("keyword"));
        $co = $this->chk_zip($keyword);
        if ($co > 0)
        {
            $zipcode = $this->chk_zip($keyword, "value");
            $this->session->set_userdata('zip', $zipcode);
            $this->update_search_string($zipcode, $keyword, "zipcode");
        }
   }
   function contain_name()
   {
      $keyword = trim($this->session->userdata("keyword"));
      $co = $this->chk_string_by_like("user", "name");
      if ($co > 0)
      {
        $name = $this->chk_string_by_like("user", "name", "value");
        $this->update_search_string($name, $keyword, "fullname");
      }
      else
      {
         $co = $this->chk_string_by_locate("user", "name");
         if ($co > 0)
         {
           $name = $this->chk_string_by_locate("user", "name", "value");
           $this->update_search_string($name, $keyword, "fullname");
         }
      }
   }
   function contain_phone($keyword)
   {
      $keyword_no = trim($this->session->userdata("keyword_no"));
      $co = $this->chk_string("user", "phone1");
      if ($co > 0)
      {
       $phone = trim($this->chk_string("user", "phone1", "value"));
       $this->update_search_string($phone, $keyword_no, "phone");
      }
      $co = $this->chk_string("user", "phone2");
      if ($co > 0)
      {
        $phone = $this->chk_string("user", "phone2", "value");
        $this->update_search_string($phone, $keyword_no, "phone");
      }
   }
   function contain_company_name()
   {
      $keyword = trim($this->session->userdata("keyword"));
      // print 'kw @ contain_company_name: ' . $keyword . '<br>';
      $co = $this->chk_string("user", "business_name");
      // print '1co @ contain_company_name: ' . $co . '<br>';
      if ($co > 0)
      {
          $business_name = $this->chk_string("user", "business_name", "value");
          // print '1business_name @ contain_company_name: ' . $business_name;
          $this->update_search_string($business_name, $keyword, "company");
      }
      else
      {
         $co = $this->chk_string_by_locate("user", "business_name");
         // print '2co @ contain_company_name: ' . $co . '<br>';
         if ($co > 0)
         {
             $business_name = $this->chk_string_by_locate("user", "business_name", "value");
             // print '2business_name @ contain_company_name: ' . $business_name;
             $this->update_search_string($business_name, $keyword, "company");
         }
         else
         {
            $co = $this->chk_string_by_like("user", "business_name");
            // print '2co @ contain_company_name: ' . $co . '<br>';
            if ($co > 0)
            {
                $business_name = $this->chk_string_by_like("user", "business_name", "value");
                // print '2business_name @ contain_company_name: ' . $business_name;
                $this->update_search_string($business_name, $keyword, "company");
            }
         }
      }
   }
}
?>