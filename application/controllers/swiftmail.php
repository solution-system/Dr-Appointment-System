<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/swift_mailer/swift_required.php';

class Swiftmail extends Controller {

  function __construct() {
      parent::__construct();
  }

  function index() {
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
      $message->setSubject('Your subject')
              ->setFrom('info@solutionsystem.net')
              ->setTo('abdul@solutionsystem.net')
              ->setBody('Here is the message itself')
              ->addPart('<q>Here is the message itself</q>', 'text/html')
      ;

      //Create the Mailer using your created Transport
      $mailer = Swift_Mailer::newInstance($transport);

      //Send the message
      $result = $mailer->send($message);

      if ($result) {
          echo "Email sent successfully";
      } else {
          echo "Email failed to send";
      }
  }
} ?>