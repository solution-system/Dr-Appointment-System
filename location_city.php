<?php
session_start();
include_once("include/common.php");
include_once("location_city_process.php");
$state = get_param("state");
$state_fullname = dlookup("us_states", "region", "code=" . tosql($state, "Text"));  
?>
<div class="finding-city-blk">
   <div class="city-left">
     <p><?=$state_fullname?> - Type city and press enter to see result</p>
   </div><!-- .city-left -->
   <div class="city-right">
     <form id="frm_keyword" name="frm_keyword" method="get" onsubmit="javascript: if (document.frm_keyword.us_city.value.length==0) return false; else { location.href = '/locate/result/' + document.frm_keyword.us_state.value + '-us-state/' + document.frm_keyword.us_city.value + '-us-city'; return false;} ">
       <input name="us_city" id="us_city" type="text" class="find-city" value="type your keyword" onfocus="if (this.value == 'type your keyword') {this.value=''}" onblur="if (this.value == '') {this.value='type your keyword'}" />
       <input type="hidden" value="<?=$state?>" name="us_state" id="us_state"/>
     </form>
   </div><!-- .city-right -->
   <div class="clear"></div>
 </div><!-- .finding-city-blk --> 
 <p class="note"><span class="red">Note:</span>&nbsp; Click each City to show Zip Codes for the selected City</p>
 <div class="indexing">
   <?php
   $a = 1;
   $alpha = explode(',', 'A,B,C,D,E,F,G,H');
   for ($i=0; $i<count($alpha); $i++)
   {
     $chk = city_process($alpha[$i], $state, ($a));
     if ($chk)
     {
         print $chk;
         $a++;
     }
   }
   ?>
   <div class="clear"></div>
 </div>
 <div class="indexing">
   <?php
   $a = 1;
   $alpha = explode(',', 'I,J,K,L,M,N,O,P');
   for ($i=0; $i<count($alpha); $i++)
   {
     $chk = city_process($alpha[$i], $state, ($a));
     if ($chk)
     {
         print $chk;
         $a++;
     }
   }
   ?>
   <div class="clear"></div>
 </div>
 <div class="indexing">
   <?php
   $a = 1;
   $alpha = explode(',', 'Q,R,S,T,U,V,W,X');
   for ($i=0; $i<count($alpha); $i++)
   {
     $chk = city_process($alpha[$i], $state, ($a));
     if ($chk)
     {
         print $chk;
         $a++;
     }
   }
   ?>
   <div class="clear"></div>
 </div>
 <div class="indexing">
   <?php
   $a = 1;
   $alpha = explode(',', 'Y,Z');
   for ($i=0; $i<count($alpha); $i++)
   {
     $chk = city_process($alpha[$i], $state, ($a));
     if ($chk)
     {
         print $chk;
         $a++;
     }
   }
   ?>
   <div class="clear"></div>
 </div>