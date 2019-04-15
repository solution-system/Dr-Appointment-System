<?php
error_reporting(E_ALL ^ E_NOTICE);
include("db_mysql.inc");

require_once('config.php');

// Database Initialize
$db = new DB_Sql();
$db->Database = DATABASE_NAME;
$db->User     = DATABASE_USER;
$db->Password = DATABASE_PASSWORD;
$db->Host     = DATABASE_HOST;

//===============================
// Common functions
//-------------------------------
// Convert non-standard characters to HTML
//-------------------------------
if (!function_exists('tohtml')) {

    function tohtml($strValue) {
        return htmlspecialchars($strValue);
    }

}
//-------------------------------
// Convert value to URL
//-------------------------------
if (!function_exists('tourl')) {

    function tourl($strValue) {
        return urlencode($strValue);
    }

}
//-------------------------------
// Obtain specific URL Parameter from URL string
//-------------------------------
/*
  function get_param($param_name)
  {
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;

  $param_value = "";
  if(isset($HTTP_POST_VARS[$param_name]))
  $param_value = $HTTP_POST_VARS[$param_name];
  else if(isset($HTTP_GET_VARS[$param_name]))
  $param_value = $HTTP_GET_VARS[$param_name];

  return $param_value;
  }
 */

if (!function_exists('get_param')) {

    function get_param($param_name) {
        $param_value = "";
        if (isset($_POST[$param_name]))
            $param_value = $_POST[$param_name];
        else if (isset($_GET[$param_name]))
            $param_value = $_GET[$param_name];
        return $param_value;
    }

}

if (!function_exists('get_session')) {

    function get_session($param_name) {
        /* global $HTTP_POST_VARS;
          global $HTTP_GET_VARS;
          global ${$param_name};

          $param_value = "";
          if(!isset($HTTP_POST_VARS[$param_name]) && !isset($HTTP_GET_VARS[$param_name]) && session_is_registered($param_name))
          $param_value = ${$param_name};
         */
        $param_value = isset($_SESSION[$param_name]) ? $_SESSION[$param_name] : "";
        return $param_value;
    }

}

if (!function_exists('set_session')) {

    function set_session($param_name, $param_value) {
        /* global ${$param_name};
          if(session_is_registered($param_name))
          session_unregister($param_name);
          ${$param_name} = $param_value;
          session_register($param_name); */
        $_SESSION[$param_name] = $param_value;
    }

}
if (!function_exists('is_number')) {

    function is_number($string_value) {
        if (is_numeric($string_value) || !strlen($string_value))
            return true;
        else
            return false;
    }

}
//-------------------------------
// Convert value for use with SQL statament
//-------------------------------
if (!function_exists('tosql')) {

    function tosql($value, $type) {
        if ($value == "")
            return "NULL";
        else
        if ($type == "Number")
            return str_replace(",", ".", doubleval($value));
        else 
        {
            if (get_magic_quotes_gpc() == 0) 
            {
                $value = str_replace("'", "''", $value);
                $value = str_replace("\\", "\\\\", $value);
               // $value .= '==========>if';
            } 
            else if ((strpos($value, "'")) or (strpos($value, '"'))) 
            {
                $value = mysql_real_escape_string($value);
            }
            else 
			{
            	$value = str_replace("'", "\'", $value);
                 $value = str_replace("\\\"", "\"", $value);
                // $value .= '=====>else';
            }
            return "'" . $value . "'";
        }
    }

}

if (!function_exists('strip')) {

    function strip($value) {
        if (get_magic_quotes_gpc() == 0)
            return $value;
        else
            return stripslashes($value);
    }

}

if (!function_exists('db_fill_array')) {

    function db_fill_array($sql_query) {
        global $db;
        $db_fill = new DB_Sql();
        $db_fill->Database = $db->Database;
        $db_fill->User = $db->User;
        $db_fill->Password = $db->Password;
        $db_fill->Host = $db->Host;

        $db_fill->query($sql_query);
        if ($db_fill->next_record()) {
            do {
                $ar_lookup[$db_fill->f(0)] = $db_fill->f(1);
            } while ($db_fill->next_record());
            return $ar_lookup;
        }
        else
            return false;
    }

}

//-------------------------------
// Deprecated function - use get_db_value($sql)
//-------------------------------
if (!function_exists('dlookup')) {

    function dlookup($table_name, $field_name, $where_condition) {
        $sql = "SELECT " . $field_name . " FROM " . $table_name . " WHERE " . $where_condition;
        return get_db_value($sql);
    }

}

//-------------------------------
// Lookup field in the database based on SQL query
//-------------------------------
if (!function_exists('get_db_value')) {

    function get_db_value($sql) {
        global $db;
        $db_look = new DB_Sql();
        $db_look->Database = $db->Database;
        $db_look->User = $db->User;
        $db_look->Password = $db->Password;
        $db_look->Host = $db->Host;

        $db_look->query($sql);
        if ($db_look->next_record())
            return $db_look->f(0);
        else
            return "";
    }

}

//-------------------------------
// Obtain Checkbox value depending on field type
//-------------------------------
if (!function_exists('get_checkbox_value')) {

    function get_checkbox_value($value, $checked_value, $unchecked_value, $type) {
        if (!strlen($value))
            return tosql($unchecked_value, $type);
        else
            return tosql($checked_value, $type);
    }

}
//-------------------------------
// Obtain lookup value from array containing List Of Values
//-------------------------------
if (!function_exists('get_lov_value')) {

    function get_lov_value($value, $array) {
        $return_result = "";

        if (sizeof($array) % 2 != 0)
            $array_length = sizeof($array) - 1;
        else
            $array_length = sizeof($array);
        reset($array);

        for ($i = 0; $i < $array_length; $i = $i + 2) {
            if ($value == $array[$i])
                $return_result = $array[$i + 1];
        }

        return $return_result;
    }

}

//-------------------------------
// Verify user's security level and redirect to login page if needed
//-------------------------------

function check_security($ulevel="", $area="") {
    $user_level = $_SESSION["user_level"];
    if ($_SESSION["loginid"] == "") 
    {
        if (isset($_COOKIE["cat"]))
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php?group=sales&querystring=' . urlencode($_SERVER['QUERY_STRING']) . '&ret_page=' . urlencode($_SERVER['SCRIPT_NAME']));
        else
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php?querystring=' . urlencode($_SERVER['QUERY_STRING']) . '&ret_page=' . urlencode($_SERVER['SCRIPT_NAME']));
        exit;
    }
    elseif ($ulevel > $user_level) 
    {
        if (($area == 'sales-rep') and ($_SESSION['cat']=='sales-rep'))
        	return true;
        else 
        {
	    	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/message.php?FormAction=prohibited');
	        exit;
        }    
    }
}

//===============================
//  GlobalFuncs begin
if (!function_exists('get_config')) {

    function get_config($var) {
        if (!dlookup("config", "count(*)", "config_variable='$var'")) {

            //  Create if doesn't exist
            $db = new DB_Sql();
            $db->Database = DATABASE_NAME;
            $db->User = DATABASE_USER;
            $db->Password = DATABASE_PASSWORD;
            $db->Host = DATABASE_HOST;
            $db->query("INSERT INTO config (config_variable) VALUES (" . ToSQL($var, "Text") . ")");
        }
        return dlookup("config", "config_value", "config_variable='$var'");
    }

}

if (!function_exists('now')) {

    function now() {
        return date("Y-m-d G:i:s");
    }

}

if (!function_exists('vdate')) {

    function vdate($ldate) {
        $ldate = str_replace(":", "-", $ldate);
        $ldate = str_replace(" ", "-", $ldate);
        list ($year, $month, $day, $hour, $minute) = explode("-", $ldate);
        if ($newdate = mktime($hour, $minute, 0, $month, $day, $year)) {
            if (@date("H-i", $newdate) == "00-00")
                return @date("m/d/y", $newdate);
            else
                return @date("m/d/y h:i A", $newdate);
        }
    }

}

if (!function_exists('sdate')) {

    function sdate($ldate) {
        list ($year, $month, $day, $hour, $minute) = explode("-", $ldate);
        $newdate = mktime(0, 0, 0, $month, $day, $year);
        return date("m/d/y", $newdate);
    }

}

if (!function_exists('datetodb')) {

    function datetodb($edate) {
        return date("Y-m-d H:i:s", strtotime($edate));
    }

}

if (!function_exists('sendemails')) {

    function sendemails($email_sql, $email_from, $email_subject, $email_body) {
        $db = new DB_Sql();
        $db->Database = DATABASE_NAME;
        $db->User = DATABASE_USER;
        $db->Password = DATABASE_PASSWORD;
        $db->Host = DATABASE_HOST;

        $db->query($email_sql);
        while ($db->next_record())
            mail($db->f(0), $email_subject, $email_body, "From: $email_from");
    }

}

if (!function_exists('sendemail')) 
{
	function sendemail($To, $from, $subject, $body, $fullname="") 
	{
        if ($fullname == "")
            $fullname = $To;
        $from_name = "Detroit Radiator Corp.";
        $mailbody = '
		<html>
			<head>
				<LINK HREF="' . ServerAddress() . 'include/css/style.css" REL="stylesheet" TYPE="Text/css">
			</head>
			<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
				<table bgcolor="#FFFFFF" align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center">
						<img 	src="' . ServerAddress() . 'images/header_email.jpg" 
								border="0">
					</td>
				</tr>
				<tr>
					<td>' . $body . '</td>
				</tr>
				</table>
			</body>
		</html>';


        include_once( $_SERVER['DOCUMENT_ROOT'] . '/phpMailer_v2.1/class.phpmailer.php');
        $mail = new PHPMailer(); // defaults to using php "mail()"
        $mail->From = "admin@snellexpert.com";
        $mail->FromName = "Snell Expert Web Access";
        $mail->Subject = stripslashes($subject);
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->MsgHTML($mailbody);
        $mail->AddAddress($To, $fullname);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            exit();
        }
    }

}

//  GlobalFuncs end
//===============================

if (!function_exists('dos')) {

    function dos($table, $realID) {
        return dlookup($table, "date_of_submit", "realid=" . tosql($realID, "Number"));
    }

}

if (!function_exists('ServerAddress')) {

    function ServerAddress() {
        return("http://" . $_SERVER["SERVER_NAME"] . substr($_SERVER["PATH_INFO"], 1, strrpos($_SERVER["PATH_INFO"], "/")) . "/");
    }

}

if (!function_exists('putDate')) {

    function putDate($input) {
        $time = strtotime($input);
        $output = date("m/d/Y", $time);
        return ($output);
    }

}

function paging($page_no, $page_name, $display, $total) {
    if (get_param("param4") == "")
        $skip_page = 1;
    else
        $skip_page = get_param("param4");
    $page_count = 0;
    $paging = "<b>Pages:</b>";
    for ($i = 1; $i <= $total; $i = $i + $display) {
        $page_count = ($page_count + 1);
        if ($page_count == $skip_page)
            $paging .= "&nbsp;<b>[" . $page_count . "]</b>&nbsp;";
        else {
            if (str_contains($page_name, 'search_view_all.php'))
                $paging .= "&nbsp;<a href=\"" . $page_name . "&param3=" . $i . "&param4=" . $page_count . "\"><font class=txt><U>" . $page_count . "</u></font></a>&nbsp;";
            else
                $paging .= "&nbsp;<a href=\"" . $page_name . "_" . $i . "_" . $page_count . ".htm\"><font class=txt><U>" . $page_count . "</u></font></a>&nbsp;";
        }
    }
    return $paging;
}

if (!function_exists('str_contains')) {

    function str_contains($haystack, $needle, $ignoreCase = false) {
        if ($ignoreCase) {
            $haystack = strtolower($haystack);
            $needle = strtolower($needle);
        }
        $needlePos = strpos($haystack, $needle);
        return ($needlePos === false ? false : ($needlePos + 1));
    }

}

if (!function_exists('alert')) {

    function alert($str) {
        print '<script language="javascript">alert("' . $str . '");</script>';
    }

}

function write_data($str)
{
      $File = $_SERVER['DOCUMENT_ROOT'] . "/log/log_" . date("Y-m-d") . ".txt";
      $Handle = fopen($File, 'a');
      $Data = "\n-------------------------------------------\n
               Date: " .  date('l jS \of F Y h:i:s A') . "\n
               $str
               \n---------------------------------------------\n";
      fwrite($Handle, $Data);
      fclose($Handle);
}
?>
