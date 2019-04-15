<?php
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
function get_param($param_name)
{
   $param_value = "";
   if (isset($_POST[$param_name]))
       $param_value = $_POST[$param_name];
   else if (isset($_GET[$param_name]))
       $param_value = $_GET[$param_name];
   return $param_value;
}

$To = get_param("to_email");
$To_name = get_param("to_name");
$from = 'lead@snellexperts.com';
$from_name = get_param("first_name") . ' ' . get_param("last_name");
// print $To . ' --> ' . $To_name . ' --> ' . $from . ' --> ' . $from_name . '<hr>';
$subject = 'Someone has contact you at Snell Experts';
$body = nl2br('

Hello Again Snell Experts,

Please check out the user’s submitted information and return to them soon:
At his Email Address: ' . chk_input(get_param('email')) . '
Or via Phone: ' . chk_input(get_param('phone')) . '

<b>Submitted information:</b>
<b>Contact First Name:</b> ' . chk_input(get_param('first_name')) . '
<b>Contact Last Name:</b> ' . chk_input(get_param('last_name')) . '
<b>Contact Phone Number:</b> ' . chk_input(get_param('phone')) . '
<b>State:</b> ' . chk_input(get_param('state')) . '
<b>City:</b> ' . chk_input(get_param('city')) . '
<b>Zip Code:</b> ' . chk_input(get_param('zip')) . '
<b>Comments:</b> ' . nl2br(get_param('comments')) . '


---
This is an automated message. Please do not reply to the Email sent. 
Godspeed Technologies, LLC has brought you this message ');
// Include this needed file
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Swift-4.2.1/lib/swift_required.php');

// Start the mailer
$mailer = new Swift_Mailer(new Swift_MailTransport());

// Create a message
// SYNTAX is $message = Swift_Message::newInstance('SUBJECT', 'MESSAGE', 'text/html')
// ->setFrom(array('from@email.address' => 'Graham Gillett'))
// ->setTo(array('to@email.address' => 'Test Person'));
$message = Swift_Message::newInstance($subject, $body, 'text/html')
->setFrom(array($from => $from_name))
->setTo(array($To => $To_name, 'lead@snellexperts.com' => 'Snell Experts'));


// Send it
print $mailer->send($message); ?>