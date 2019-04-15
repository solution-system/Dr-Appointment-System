<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Frontend extends CI_Controller
{
    function __construct()
    {
       parent::__construct();
       $GLOBALS['title'] = '';
       $GLOBALS['sel1'] = '';
       $GLOBALS['sel2'] = '';
       $GLOBALS['sel3'] = '';
       $GLOBALS['sel4'] = '';
       $GLOBALS['sel5'] = '';

	 }
	 
	 function get_Service($sid="")
    {
      $this->sql = 'SELECT   s.*,
                  			  (if (s.id=' . $this->db->escape($sid) . '), "CHECKED", "") as is_selected
                    FROM     service s
                    ORDER BY s.name;';
       // print 'sql: ' . $this->sql;
       return $this->common_model->explicit($this->sql);
    }
    function print_msg($str)
    {
       print '<pre>' . trim($str) . '</pre>';
    }
    function require_thirdparty_package($package = '')
    {
      switch($package)
      {
         case 'swift_mailer':
             require_once APPPATH.'libraries/swift_mailer/swift_required.php';
             break;
      }
    }
    function sendmail($To, $from, $subject, $body, $To_name="", $from_name="")
    {
      if (($To <> "") and ($from <> ""))
      {
         $this->require_thirdparty_package("swift_mailer");
         //Create the Transport
         $transport = Swift_MailTransport::newInstance();

         /*
         You could alternatively use a different transport such as Sendmail or Mail:

         //Sendmail
         $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

         //Mail
         $transport = Swift_MailTransport::newInstance();
         */

         //Create the message
         $message = Swift_Message::newInstance();

         //Give the message a subject
         $message->setSubject($subject)
                 ->setFrom(array($from => $from_name))
                 ->setTo(array($To => $To_name))
                 ->setBody($body)
                 ->addPart($body, 'text/html')
         ;

         //Create the Mailer using your created Transport
         $mailer = Swift_Mailer::newInstance($transport);

         //Send the message
         $result = $mailer->send($message);
         return $result;
      }
      else
         return false;
  }
}
?>