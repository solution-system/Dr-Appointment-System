<?php
function get_dropdown($fld_txt, $table, $fld_val='id', $fld_where='', $fld_where_value='', $FormAction='Add', $set_val='')
{
    $ret = '<select name="' . $table . '" id="' . $table . '">';
    if ($FormAction == 'Add')
        $ret .= '<option value="">Select any option</option>';
    $ci =& get_instance();
    $ci->load->model('common_model');   
    if ($fld_val == "")
        $fld_val = $fld_txt;
    $sql = "SELECT $fld_txt, $fld_val "; 
    $sql .= " FROM $table "; 
    if ($fld_where_value <> "")
        $sql .= " WHERE $fld_where='$fld_where_value' ";
    $chk = $ci->common_model->explicit($sql);
    if (is_array($chk)) {
        foreach ($chk as $item): 
            if ($set_val == trim($item[$fld_val]))
                $sel = ' SELECTED ';
            else
                $sel = '';
            $ret .= '<option ' . $sel . ' value="' . $item[$fld_val] . '">' . $item[$fld_txt] . '</option>';
        endforeach;
    }
    return $ret . '</select>';
}
function typeofdr($combo, $type='', $FormAction='')
{
    $ret = '<select name="' . $combo . '" id="' . $combo . '">';
    if ($FormAction == 'Add')
        $ret .= '<option value="">Select any option</option>';
    $arr = explode(',', get_config_ext($combo));    
    for ($i=0; $i < count($arr); $i++)
    {
        if ($type == trim($arr[$i]))
            $sel = ' SELECTED ';
        else
            $sel = '';
        $ret .= '<option ' . $sel . ' value="' . trim($arr[$i]) . '">' . trim($arr[$i]) . '</option>';
    }
    return $ret . '</select>';
}
function get_config_ext($var)
{
    $ci =& get_instance();
    $ci->load->model('common_model');    
    $chk = $ci->common_model->scalar('config','count(id)', array('config_variable' => $var));
    //print 'chk 1:' . $chk . '<br>';
    //print 'chk 111:' . $ci->db->last_query() . '<br>';
    if ($chk == '0')
    {
        $ci->db->query("INSERT INTO config (config_variable) VALUES (" . $ci->db->escape($var) . ")");
    }
    $var = $ci->common_model->scalar('config','config_value', array('config_variable' => $var));
    // print 'chk 2:' . $var . '<br>';
    return $var;
}
function update_tracking()
{
   $ci =& get_instance();
   if ($ci->session->userdata("temp_search_url") <> $ci->session->userdata("search_url"))
   {
      $ci->session->set_userdata("temp_search_url", $ci->session->userdata("search_url"));
      $sql = 'INSERT INTO tracking (state,
                                   city,
                                   zip,
                                   url,
                                   user)
              VALUES(' . $ci->db->escape($ci->session->userdata('us_state')) . ',
                     ' . $ci->db->escape($ci->session->userdata('city')) . ',
                     ' . $ci->db->escape($ci->session->userdata('zip')) . ',
                     ' . $ci->db->escape($ci->session->userdata("search_url")) . ',
                     ' . $ci->db->escape($ci->session->userdata('session_id')) . ');';
      $ci->db->query($sql);
   }
}
function chk_input($input, $fld='')
{
    if ($fld == "bureau_member")
    {
       if ($input == "1")
         return "Yes";
       else
         return "No";
    }
    else if ($input == "")
      return ' N/A ';
    else
      return $input;
}
function service_chk($ser)
{
    if ($ser<>"")
      return ' CHECKED ';
}
function captcha()
{
   $ci =& get_instance();
   // load codeigniter captcha helper
   $ci->load->helper('captcha');

   $vals = array(
   'img_path'	 => './captcha/',
   'img_url'	 => base_url() . '/captcha/',
   'img_width'	 => '100',
   'img_height' => 30,
   'border' => 0,
   'expiration' => 7200
   );

    // create captcha image
   $cap = create_captcha($vals);

   // store image html code in a variable
   $data['image'] = $cap['image'];

   // store the captcha word in a session
   $ci->session->set_userdata('word', $cap['word']);
   // store image html code in a variable
   return $cap['image'];
}
function clock_loop($time)
{
   $temp = '<option value="">Select any time</option>';
   $this_time = '';
    for ($i=1; $i<=12;$i++)
    {
      if (strlen($i) == "1")
         $i = '0' . $i;
      $tick = '00:00';
      $tick_text = '00';
      $this_time = $i . ':' . $tick;
      $this_time_text = $i . ':' . $tick_text;
      if ($this_time == $time)
         $sel = ' SELECTED ';
      else
         $sel = '';
      $temp .= '<option ' . $sel . ' value="' . $this_time . '">' . $this_time_text . '</option>';
      $tick = '30:00';
      $tick_text = '30';
      $this_time = $i . ':' . $tick;
      $this_time_text = $i . ':' . $tick_text;
      if ($this_time == $time)
         $sel = ' SELECTED ';
      else
         $sel = '';
      $temp .= '<option ' . $sel . ' value="' . $this_time . '">' . $this_time_text . '</option>';
    }
    return $temp;
}
function chk_registration($sError, $pre='')
{
   $ci =& get_instance();
   $i = 1;
   $ser = '0';
   if (trim($ci->input->post($pre . 'first_name')) == "")
      $sError .= '- Please enter First Name...<br>';
   if (trim($ci->input->post($pre . 'last_name')) == "")
      $sError .= '- Please enter Last Name...<br>';
   if (trim($ci->input->post($pre . 'state')) == "")
      $sError .= '- Please select State...<br>';
   if ($pre == '')
   {
      if (trim($ci->input->post($pre . 'business_name')) == "")
         $sError .= '- Please enter Company Name...<br>';
   }
   if ($pre == 'ad_')
   {
      if (trim($ci->input->post($pre . 'brand_name')) == "")
         $sError .= '- Please enter Company Brand Name...<br>';
   }
   if (trim($ci->input->post($pre . 'email')) == "")
      $sError .= '- Please enter email address...<br>';
   if (trim($ci->input->post($pre . 'city')) == "")
      $sError .= '- Please select city...<br>';
   if (trim($ci->input->post($pre . 'phone1')) == "")
      $sError .= '- Please enter Phone Number 1...<br>';
   if (trim($ci->input->post($pre . 'zip')) == "")
      $sError .= '- Please select Zip-Code...<br>';
   if ($pre == '')
   {
      for ($i=1; $i < 6; $i++)
      {
         if ($ci->input->post('service' . $i))
         {
             $ser = '1';
             break;
         }
      }
      if ($ser == '0')
         $sError .= '- Please select atleast one service...<br>';
   }
   return $sError;   
}
function doctor_service_update($user_id)
{
   $ci =& get_instance();
   $ci->load->model('common_model');
   $ci->common_model->delete('doctor_service',array('frn_user'=>$user_id));
   for ($s=1; $s <= 5; $s++)
   {
     if ($ci->input->post('service' . $s) <> "")
     {
        $service =  $ci->input->post('service' . $s);
        $data = array(
          'frn_user' => $user_id,
          'frn_service' => $service
        );
        $ci->common_model->insert("doctor_service",$data);
     }
   }
}
function onclick_info($fld, $info, $id)
{
   $ci =& get_instance();
   if ($ci->session->userdata('username') == "")
      $show = false;
   else if ($id <> $ci->session)
      $show = false;
   else
     $show = true;   
   if ($show)
       return $info;
   else
   {
      $class = '';
      $font = '';
      if ($fld == 'email')
      {
         $class = 'class="blue"';
         // $font = 'blue';
         $text = 'Click to Show Email';
      }
      else if ($fld == 'phone1')
      {
         $class = 'class="red"';
         $font = '#3e6b08';
         $text = 'Click to Show Phone#';
      }
     return '<span id="fld_' . $fld . '_' . $id . '"><a ' . $class . ' href="javascript:void(0);" onclick="javascript: return get_info(\'' . $id . '\', \'' . $fld . '\');"><font color="' . $font . '">' . $text . '</font></a></span>
              <span class="loading" id="loading_' . $fld . $id . '"><img alt="Dr. Website" title="Dr. Website" src=\'/images/loading.gif\' border=0></span>
              <script>jQuery("#loading_' . $fld . $id . '").hide();</script>
              ';
   }
}
function services($user_id)
{
   $ser = '';
   $ci =& get_instance();
   $ci->load->model('user_model');
   $us = $ci->user_model->get_Service($user_id);
   if ($us)
   {
     foreach($us as $s)
     {
        $ser .= '<img src="/images/service/' . strtolower($s['name']) . '.png" style="margin-top:-5px;" alt="' . $s['name'] . ' Service" title="' . $s['name'] . ' Service" border="0">';
     }
     return $ser;
   }
}
function get_param($param_name, $data='')
{
   $ci =& get_instance();
   if ($ci->input->get_post($param_name) <> "")
      return $ci->input->get_post($param_name);
   else
   {
      if (is_array($data))
      {
         if (isset($data[$param_name]))
         {
            // print $param_name . ': ' . $data[$param_name];  
            return $data[$param_name];
          }else
            return '';
      }
   }
}
?>