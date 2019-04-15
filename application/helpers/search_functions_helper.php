<?php
function update_search_string($txt, $kw, $varname)
{
    $this->search_url .= '/'. str_replace(' ', '+', $txt) . '-' . $varname;
    $arr = explode('+', $txt);
    for ($i=0; ($i < count($arr)); $i++)
    {
     $varname = strtolower($arr[$i]);
     // parent::print_msg('varname: ' . $varname . '-->' . $kw . '<br>');
    	$this->keyword = trim(preg_replace('/' . $varname . '/', '', $kw));
    }

}
function chk_string_by_locate($table, $field, $type='count')
{
   if ($this->keyword == "")
     return -1;
   $sql = '';
   if ($type == 'count')
   {
      $sql = 'SELECT   COUNT(' . $field . ') as total
              FROM     ' . $table . '
              WHERE    LOCATE(LOWER(' . $field . '), ' . $this->db->escape($this->keyword) . ') OR
                       LOCATE(' . $this->db->escape($this->keyword) . ', LOWER(' . $field . '));';
        parent::print_msg($sql . '<br>');
        return $this->db->query($sql)->row()->total;
    }
    else
    {
      $sql = 'SELECT   DISTINCT LOWER(' . $field . ') as fld
              FROM     ' . $table . '
              WHERE    LOCATE(' . $field . ', ' . $this->db->escape($this->keyword) . ') OR
                       LOCATE(' . $this->db->escape($this->keyword) . ', ' . $field . ');';
        parent::print_msg($sql . '<br>');
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
                // parent::print_msg('rec: ' . $rec);
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
   if ($this->keyword == "")
     return -1;
   $sql = '';
   if ($type == 'count')
   {
     $sql = "SELECT    COUNT(IF(MATCH (" . $field . ") AGAINST (" . $this->db->escape($this->keyword) . "), 1, NULL)) as total
             FROM      " . $table . "
             WHERE     MATCH (" . $field . ") AGAINST (" . $this->db->escape($this->keyword) . "  in boolean mode)
             order by  total desc;";
      // parent::print_msg($sql . '<br>');
        return $this->db->query($sql)->row()->total;
    }
    else
    {
          $sql = "SELECT    DISTINCT " . $field . " as fld
                   FROM      " . $table . "
                   WHERE     MATCH (" . $field . ") AGAINST (" . $this->db->escape($this->keyword) . "  in boolean mode)
                   order by  MATCH (" . $field . ") AGAINST (" . $this->db->escape($this->keyword) . " in boolean mode) desc;";
       // parent::print_msg($sql . '<br>');
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
                // parent::print_msg('rec: ' . $rec);
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
     $co = $this->chk_string("service", "name");
     if ($co > 0)
     {
         $this->service_selected = $this->chk_string("service", "name", "value");
         $this->update_search_string($service, $this->keyword, "service");
     }
}
function contain_service_subtype()
{
    $co = $this->chk_string("service_subtype", "sub_type");

    if ($co > 0)
    {
        $sub_type = $this->chk_string("service_subtype", "sub_type", "value");
        $this->update_search_string($sub_type, $this->keyword, "subtype");
    }
}
function contain_us_state()
{
     $co = $this->chk_string("us_states", "region");
     if ($co > 0)
     {
        $us_state = $this->chk_string("us_states", "region", "value");
        $this->update_search_string($us_state, $this->keyword, "us-state");
     }
     else
     {
        $co = $this->chk_string("us_states", "code");
       // parent::print_msg('3- co @ contain_us_state CODE: ' . $co . '<br>');
        if ($co > 0)
        {
          $us_state = $this->chk_string("us_states", "code", "value");
          $this->update_search_string($us_state, '', strtoupper($this->keyword), "us-state");
        }
     }
}
function contain_city()
{
     $co = $this->chk_string("us_city", "city");
     if ($co > 0)
     {
         $city = $this->chk_string("us_city", "city", "value");
         $this->update_search_string($city, $this->keyword, "us-city");
     }
}
function contain_zipcode()
{
     $co = $this->chk_string("us_city", "zipcode");
     if ($co > 0)
     {
         $zipcode = $this->chk_string("us_city", "zipcode", "value");
         $this->update_search_string($zipcode, $this->keyword, "zipcode");
     }
}
function contain_name()
{
    $co = $this->chk_string("user", "name");
     if ($co > 0)
     {
         $name = $this->chk_string("user", "name", "value");
         $this->update_search_string($name, $this->keyword, "fullname");
     }
}
function contain_phone()
{
     $co = $this->chk_string("user", "phone1");
     if ($co > 0)
     {
         $phone = $this->chk_string("user", "phone1", "value");
         $this->update_search_string($phone, $this->keyword, "phone1");
     }
     else
     {
         $co = $this->chk_string("user", "phone2");
        if ($co > 0)
        {
            $phone = $this->chk_string("user", "phone2", "value");
            $this->update_search_string($phone, $this->keyword, "phone2");
        }
     }     
}
function contain_company_name()
{
     $co = $this->chk_string("user", "business_name");
     if ($co > 0)
     {
         $business_name = $this->chk_string("user", "business_name", "value");
         $this->update_search_string($business_name, $this->keyword, "company");
     }
}
?>