<?php
class Search_model extends CI_Model
{
   function update_search_string($txt, $keyword, $varname)
   {
       $search_url = $txt . '-' . $varname . '/';
       $arr = explode(' ', $txt);
       for ($i=0; ($i < count($arr)); $i++)
       {
         $varname = strtolower($arr[$i]);
         // print '$varname: ' . $varname . '<br>';
         // print 'keyword b4: ' . $keyword . '<br>';
         $keyword = trim(preg_replace('/' . $varname . '/', '', $keyword));
         // print 'keyword after: ' . $keyword . '<br>';
       }
       $this->session->set_userdata('keyword', $keyword);
       $this->session->set_userdata('search_url', $this->session->userdata("search_url") . str_replace(' ', '+', $search_url));
       // print 'search URL: ' . $this->session->userdata("search_url") . '<br>';
       // print 'Keyword: ' . $this->session->userdata("keyword") . '<br>';
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
         // print $sql . '<br>';
         return $this->db->query($sql)->row()->total;
       }
       else
       {
            $sql = 'SELECT   DISTINCT LOWER(' . $field . ') as fld
                    FROM     ' . $table . '
                    WHERE    ' . $field . " REGEXP '[[:<:]]" . $keyword . "[[:>:]]' ";
            if (($table == "service_subtype") and ($service <> ""))
               $sql .= ' AND frn_service=(SELECT s.id FROM service s WHERE s.name="' . $service . '") ';
           // print $sql . '<br>';
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
      $keyword = $this->session->userdata("keyword");
      if ($keyword == "")
        return -1;
      $sql = '';
      if ($type == 'count')
      {
         $sql = "SELECT    COUNT(IF(MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . "), 1, NULL)) as total
                  FROM      " . $table . "
                  WHERE     MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . ")  ";
         if (($table == "service_subtype") and ($service <> ""))
            $sql .= ' AND frn_service=(SELECT s.id FROM service s WHERE s.name="' . $service . '") ';
         if (($table == "us_city") and ($us_state <> ""))
            $sql .= ' AND (LOWER(state)="' . $us_state . '") ';
         $sql .= " ORDER BY  total desc;";
         // print $sql . '<br>';
         return $this->db->query($sql)->row()->total;
       }
       else
       {
         $sql = "SELECT    DISTINCT LOWER(" . $field . ") as fld,
                           MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . ") as Relevance
                  FROM      " . $table . "
                  WHERE     MATCH (" . $field . ") AGAINST (" . $this->db->escape($keyword) . ")   ";
         if (($table == "service_subtype") and ($service <> ""))
              $sql .= ' AND frn_service=(SELECT s.id FROM service s WHERE s.name="' . $service . '") ';
         if (($table == "us_city") and ($us_state <> ""))
            $sql .= ' AND (LOWER(state)="' . $us_state . '") ';
         $sql .= "
                  HAVING Relevance  = MAX(Relevance )
                  ORDER BY  Relevance desc;";
         // print $sql . '<br>';
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
      $keyword = $this->session->userdata("keyword");
      $co = $this->chk_string_by_locate("service", "name");
      if ($co > 0)
      {
         $service_selected = $this->chk_string_by_locate("service", "name", "value");
         $this->session->set_userdata('service_selected', $service_selected);
         // print 'ss: ' . $service_selected . '<br>';
         $this->update_search_string($service_selected, $keyword, "service");

      }
   }
   function contain_service_subtype()
   {
       $keyword = $this->session->userdata("keyword");
       $co = $this->chk_string_by_locate("service_subtype", "sub_type");
       // print 'co1 @ contain_service_subtype: ' . $co . '<br>';
       if ($co > 0)
       {
           $sub_type = $this->chk_string_by_locate("service_subtype", "sub_type", "value");
           $this->update_search_string($sub_type, $keyword, "subtype");
           
       }
       else
       {
          $co = $this->chk_string("service_subtype", "sub_type");
          // print 'co 2 @ contain_service_subtype: ' . $co . '<br>';
         if ($co > 0)
         {
             $sub_type = $this->chk_string("service_subtype", "sub_type", "value");
             $this->update_search_string($sub_type, $keyword, "subtype");
             
         }
       }
   }
   function contain_us_state()
   {
        $keyword = $this->session->userdata("keyword");
        $co = $this->chk_string_by_locate("us_states", "region");
        if ($co > 0)
        {
           $us_state = $this->chk_string_by_locate("us_states", "region", "value");
           $this->session->set_userdata('us_state', $us_state);
           $this->update_search_string($us_state, $keyword, "us-state");
           
        }
        else
        {
           $co = $this->chk_string_by_locate("us_states", "code");
           // print('3- co @ contain_us_state CODE: ' . $co . '<br>');
           if ($co > 0)
           {
             $us_state = $this->chk_string_by_locate("us_states", "code", "value");
             $this->session->set_userdata('us_state', $us_state);
             $this->update_search_string($us_state, $keyword, "us-state");
             
           }
        }
   }
   function contain_city()
   {
        $keyword = $this->session->userdata("keyword");
        $co = $this->chk_string("us_city", "city");
        if ($co > 0)
        {
            $city = $this->chk_string("us_city", "city", "value");
            $this->update_search_string($city, $keyword, "us-city");
            
        }
   }
   function contain_zipcode()
   {
        $keyword = $this->session->userdata("keyword");
        $co = $this->chk_string("us_city", "zipcode");
        if ($co > 0)
        {
            $zipcode = $this->chk_string("us_city", "zipcode", "value");
            $this->update_search_string($zipcode, $keyword, "zipcode");
            
        }
   }
   function contain_name()
   {
      $keyword = $this->session->userdata("keyword");
      $co = $this->chk_string("user", "name");
      if ($co > 0)
      {
        $name = $this->chk_string("user", "name", "value");
        $this->update_search_string($name, $keyword, "fullname");
        
      }
   }
   function contain_phone()
   {
        $keyword = $this->session->userdata("keyword");
        $co = $this->chk_string("user", "phone1");
        if ($co > 0)
        {
            $phone = $this->chk_string("user", "phone1", "value");
            $this->update_search_string($phone, $keyword, "phone1");
            
        }
        else
        {
           $co = $this->chk_string("user", "phone2");
           if ($co > 0)
           {
               $phone = $this->chk_string("user", "phone2", "value");
               $this->update_search_string($phone, $keyword, "phone2");
               
           }
        }
   }
   function contain_company_name()
   {
        $keyword = $this->session->userdata("keyword");
        $co = $this->chk_string("user", "business_name");
        if ($co > 0)
        {
            $business_name = $this->chk_string("user", "business_name", "value");
            $this->update_search_string($business_name, $keyword, "company");
            
        }
   }
}
?>