<?php
$this->load->helper("my_helper");
if (count($user))
   $add_loading = true;
else
   $add_loading = false;
foreach($user as $u):
      $business_logo = "/business_logo/" . $u["business_logo"];
      if ((!file_exists($_SERVER["DOCUMENT_ROOT"] . $business_logo)) or ($u["business_logo"] == ""))
          $business_logo  = "/images/photo_not_available.png";
   ?>
      <div class="ebay-main-blk">
      	<div class="ebay-left">
          	<img src="<?=$business_logo?>" style="margin-bottom:21px;" width="207" height="137" alt=""/>
              <p><span><img src="/public/images/phone.png" style="float:left; margin-right:13px;" width="12" height="12" alt=""/>Phone:</span>
              	   <?=onclick_info('phone1', $u['phone1'], $u['uid'])?>
              <div class="clear"></div>
              <p><span><img src="/public/images/email.png" style="float:left; margin-right:9px;" width="16" height="10" alt=""/>Email:</span>
              	   <?=onclick_info('email', $u['email'], $u['uid'])?>
              <div class="clear"></div>
              <p><span><img src="/public/images/pin-map.png" style="float:left; margin-right:14px;" width="10" height="13" alt=""/>State:</span><a href="#"><?=chk_entire_nation($u["state"], $u["entire_nation"], $input_state)?></a>	<div class="clear"></div>
              <p><span><img src="/public/images/city.png" style="float:left; margin-right:9px;" width="15" height="15" alt=""/>City:</span><a href="#"><?=chk_entire_nation($u["city"], $u["entire_nation"], $input_city)?></a><div class="clear"></div>
              <p><span><img src="/public/images/zip-code.png" style="float:left; margin-right:10px;" width="14" height="12" alt=""/>Zip Code:</span><a href="#"><?=chk_entire_nation($u["zip"], $u["entire_nation"], $input_zipcode)?></a><div class="clear"></div>
          </div>
          <div class="ebay-right">
          	<div class="ebay-heading1">
                  <div class="ebay-heading-left">
                      <h2 class="large blue1"><?=$u["business_name"]?></h2>
                  </div>
                  <div class="ebay-heading-right">
                  	<p>Service indusries:</p>
                      <?=services($u['uid'])?>
                      <!--<img src="/public/images/services.png" style="margin-top:-5px;" width="102" height="27" alt=""/>-->
                  </div>
              </div>
              <div class="ebay-heading1">
              	<div class="ebay-heading-left">
                      <h3 class="large">Company Owner: <span class="blue2"><?=$u["name"]?></span></h3>
                  </div>
                  <div class="ebay-heading-right" id="approved_<?=$u['uid']?>">
                     <br>
                     <?=$u['approved']?>
                  </div>
              </div>
              <div class="description">
              	<img src="/public/images/description.png" style="margin-right:6px;" width="14" height="13" alt=""/><span class="blue2">Company Description</span>
              	<p><?=$u["business_desc"]?></p>
           		<p><?=$u["business_keyword"]?></p>
                  <p class="fl blue-light" style="white-space: nowrap;">
                     <A HREF="javascript:jQuery('#expert_business_name').html('<?=$u["business_name"]?>');jQuery('#expert_name').html('<?=$u["name"]?>');jQuery('#to_name').val('<?=$u["name"]?>');jQuery('#to_email').val('<?=$u["company_email"]?>');jQuery('#tbl_contact').show();contact_expert();"
                        onMouseOutut="javascript:window.status=''; return true;"
                        onMouseOver="javascript:window.status='Contact Dr. Website Now'; return true;"

                        id="button">
                        Contact this company using SE's secure contact form
                     </A>
                  </p>
              </div>
          </div>
      </div>
   <?php
   endforeach;
   if ($add_loading)
      print '<div align="center" id="loading">Processing, Please wait...<img alt="Dr. Website" title="Dr. Website" src=\'/images/loading.gif\' border=0></div>';
?>