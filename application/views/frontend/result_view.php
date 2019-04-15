<?php
print '<script type="text/javascript" language="javascript" src="/include/js/locate.js"></script>';
if (!is_array($user))
 {
   print '
      <input type="hidden" value="' . $text1 . '" id="text1" name="text1">
      <input type="hidden" value="' . $link1 . '" id="link1" name="link1">
      <input type="hidden" value="' . $text2 . '" id="text2" name="text2">
      <input type="hidden" value="' . $link2 . '" id="link2" name="link2">
      <input type="hidden" value="' . $text3 . '" id="text3" name="text3">
      <input type="hidden" value="' . $link3 . '" id="link3" name="link3">
      <script language="javascript">
         load_heading();
      </script>
      <div><br><br>No Record found for search criteria. Please try again...</div>';
}
else
{
   $this->load->helper("my_helper");
   update_tracking();
   print '
      <script type="text/javascript" language="javascript" src="/include/js/infinite_scrolling.js"></script>   
      <input type="hidden" value="' . $text1 . '" id="text1" name="text1">
      <input type="hidden" value="' . $link1 . '" id="link1" name="link1">
      <input type="hidden" value="' . $text2 . '" id="text2" name="text2">
      <input type="hidden" value="' . $link2 . '" id="link2" name="link2">
      <input type="hidden" value="' . $text3 . '" id="text3" name="text3">
      <input type="hidden" value="' . $link3 . '" id="link3" name="link3">
      <input type="hidden" value="' . $actual_count . '" id="actual_count" name="actual_count">
      <script language="javascript">
         load_heading();
      </script>
      <div class="wrapper">';
      if (($service1 <> "") or ($service2 <> ""))
    	    print '
    	    <ul id="breadcrum">
         	<li><a href="' . $service_link1 . '">' . $service1 . '</a></li>
             <li><a href="' . $service_link2 . '">' . $service2 . '</a></li>
          </ul>';
    print '
            <link rel="stylesheet" type="text/css" href="/include/css/popup.css" />
      <script type="text/javascript" src="/include/js/state_city_zip.js"></script>
      <script type="text/javascript" src="/include/js/popup.js"></script>
      <script type="text/javascript" src="/include/js/user_validation.js"></script>
      <script type="text/javascript" src="/include/js/contact.js"></script>
      <div id="popupContact">
         <a id="popupContactClose">x</a>
         <p id="contactArea">
            <h3 class="heading">Contact: <span id="expert_name"></span> Company: <span id="expert_business_name"></span></h3>
            
            <form id="frm_contact" name="frm_contact" action="" method="post" onsubmit="javascript:return contact_form();">
            <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="' . $this->security->get_csrf_hash() . '" />
            <input type="hidden" id="FormAction" name="FormAction" value="company_contact">
            <input type="hidden" id="to_email" name="to_email" value="">
            <input type="hidden" id="to_name" name="to_name"  value="">
            <input type="hidden" id="from_email" name="from_email" value="">
         	<table cellpadding="4" cellspacing="2" id="tbl_contact">
         	  <tr>
         	     <td colspan=4 id="msg"></td>
         	  </tr>
         	  <tr>
         	     <td><font color="red">*</font>First Name: </td>
                 <td><input class="fn" type="text" name="first_name" id="first_name"/></td>
         	     <td><font color="red">*</font>Last Name: </td>
                 <td><input class="fn" type="text" name="last_name" id="last_name"/></td>
              </tr>
              <tr>
               <td><font color="red">*</font>Phone: </td>
               <td><input class="email" type="text" name="phone" id="phone"/></td>
               <td><font color="red">*</font>Zip code: </td>
               <td><input class="zip" name="zip" id="zip"></td>
              </tr>
              <tr>
               <td valign=top>Comments: </td>
               <td colspan=3><textarea rows="10" cols="40" class="comments" name="comment" id="comments"></textarea></td>
              </tr>
              <tr>
                <td colspan="4" class="submit">
                  <input type="submit" class="submit" value="Send"/>
                </td>
              </tr>
            </table>
            </form>
            <span id="contact_result"></span>
         </p>
      </div>
      <div id="backgroundPopup"></div>
    	<div class="ebay-blk">
        	<div id="debug"></div>
        	<div class="ebay-main">
   ';
   include_once(APPPATH . '/views/frontend/user_list.php');
   print '
         </div>
         <div class="ebay-sidebar">';
               if ($ad_zip <> "")
               	print '<h3 class="blue-light">' . $ad_zip_heading . '</h3>
               	<div class="ebay-sidebar-blk">' . $ad_zip . '</div>';
               if ($ad_city <> "")
                   print '<h3 class="blue-light">' . $ad_city_heading . '</h3>
               	<div class="ebay-sidebar-blk">' . $ad_city . '</div>';
               if ($ad_state <> "")
                   print '<h3 class="blue-light">' . $ad_state_heading . '</h3>
               	<div class="ebay-sidebar-blk">' . $ad_state . '</div>';
               print '
                   <a target="_blank" href="http://www.bbb.org/charlotte/business-reviews/mold-and-mildew-inspection/executive-restoration-116681"><img src="/public/images/rating.png" style="margin-bottom:16px;" width="221" height="64" alt=""/></a><br/>
                   <a target="_blank" href="https://knowledge.rapidssl.com/support/ssl-certificate-support/index?page=content&id=SO14424"><img src="https://knowledge.rapidssl.com/library/VERISIGN/ALL_OTHER/Frank/RapidSSL_SEAL-90x50.gif" width="221" height="50" border=0 alt=""/></a>
               </div>
               <div class="clear"></div>
           </div>
       </div>';
} ?>
