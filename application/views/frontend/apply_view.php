<?php
$this->load->helper("my_helper");
?>
<script type="text/javascript" src="/include/js/apply_advertiser.js"></script>
<script type="text/javascript" src="/include/js/apply.js"></script>
<script type="text/javascript" src="/include/js/main.js"></script>
<script type="text/javascript" src="/include/js/date.js"></script>
<script type="text/javascript" src="/public/js/apply.js"></script>
<script type="text/javascript" src="/include/js/state_city_zip.js"></script>
<script type="text/javascript" src="/include/js/user.js?<?=time()?>"></script>
<script type="text/javascript" src="/include/js/user_validation.js?<?=time()?>"></script>
  <div class="no-slider">
    <div class="wrapper">
      <div class="apply">
        <div class="blk">
          <h4 class="blue-light">Service Experts Sign up <span>(Click here)</span></h4>
          <div class="left-blk"> 
            <img src="/public/images/apply-blk-img1.png" width="168" height="111" alt="" /> </div>
          <div class="right-blk">
            <ul>
              <li>Be seen in up to 43,000+ Zip Codes</li>
              <li>Access to free Snell Experts Premium Support</li>
              <li>Exposure from our brand provides industry distinction</li>
              <li>Retain customers that only need your offered services</li>
              <li>Gain full access to Snell Experts entire contractor network</li>
            </ul>
          </div>
          <div class="clear"></div>
        </div>
        <div class="blk-rev">
          <h4 class="blue-light">Product Advertisers <span>(Click here)</span></h4>
          <div class="left-blk"> 
            <img src="/public/images/apply-blk-img2.png" width="168" height="111" alt="" /> </div>
          <div class="right-blk">
            <ul>
              <li>Banners can be seen on our entire network</li>
              <li>Every site search can expose your product to new people</li>
              <li>Clicking on your banner goes directly to your website</li>
              <li>Brand blasting for short term and long term campaigns</li>
              <li>Dynamic Ads Supported (changing ads dynamically possible)</li>
            </ul>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <div class="form apply-form">
    <div class="wrapper">
      <h3 class="blue-light">Service Experts Application Form</h3>
      <span id="loading">Processing, Please wait...<br><img alt="Snell Expert" title="Snell Expert" src='/images/loading.gif' border=0></span>
      <span id="debug"></span>
      <p>Service professionals are hand selected after submission. This process is done to help ensure quality contractors for </p>
      <div class="form-boxes">
        <form id="frm_expert" name="frm_expert" method="post" action="/apply" onsubmit="javascript:return chk_field(document.frm_expert, 'frontend');">
         <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
         <input type="hidden" name="FormAction" id="FormAction" value="Add">
         <input type="hidden" name="FormType" id="FormType" value="expert">
         <input type="hidden" name="has_error" id="has_error" value="<?=$has_error?>">
         <input type="hidden" name="temp_state" id="temp_state" value="<?=$temp_state?>" />
         <input type="hidden" name="temp_city" id="temp_city" value="<?=$temp_city?>" />
         <input type="hidden" name="temp_zip" id="temp_zip" value="<?=$temp_zip?>" />
          <div class="form-left">
            <label class="first_name"><span class="red">*</span>First Name:</label>
            <input value="<?=$first_name?>" type="text" id="first_name" name="first_name" class="w240" />
          </div>
          <div class="form-right">
            <label class="last_name"><span class="red">*</span>Last Name:</label>
            <input value="<?=$last_name?>" type="text" id="last_name" name="last_name" class="w240" />
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="ph_num1"><span class="red">*</span>Phone Number 1:</label>
            <input value="<?=$phone1?>" type="text" id="phone1" name="phone1" class="w240" />
          </div>
          <div class="form-right">
            <label class="ph_num2">Phone Number 2:</label>
            <input value="<?=$phone2?>" type="text" id="phone2" name="phone2" class="w240" />
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="zip"><span class="red">*</span>State:</label>
          	<select name="state" id="state" class="w240" onChange="javascript: ajax_action('state', 'city', this.value);"></select>
          </div>
          <div class="form-left">
            <label class="email"><span class="red">*</span>City:</label>
            <select name="city" id="city" class="w240" onChange="javascript: ajax_action('city', 'zip', this.value);"></select>
          </div>
          <div class="form-left">
            <label class="zip"><span class="red">*</span>Zip Code:</label>
            <select name="zip" id="zip" class="w240"></select>
          </div>
          <div class="form-right">
            <label class="email"><span class="red">*</span>Email Address:</label>
            <input value="<?=$email?>" type="text" id="email" name="email"  class="w240"/>
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="company">Company Name:</label>
            <input value="<?=$business_name?>" type="text" id="business_name" name="business_name" class="w240" />
          </div>
          <div class="form-right">
            <label class="services"><span class="red">*</span>Company Services:<br />
            <span class="grey">(may select more than one)</span></label>

            <?php
         	if (is_array($services))
         	{
            	$i=0;
            	foreach($services as $service):
            	  $i++; ?>
                   <span class="yes"><?=$service['name']?> Service<br/>
                     <input <?=service_chk($this->input->post('service' . $i))?> type="checkbox" id="service<?=$i?>" name="service<?=$i?>" title="services" value="<?=$service['id']?>" />
                   </span>
               <?php
               endforeach;
            }
         	?>
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="comp_detail">Company Phone Number:</label>
            <input value="<?=$company_phone_no?>" type="text" id="company_phone_no" name="company_phone_no" class="w211" />
          </div>
          <div class="form-right">
            <label class="comp_detail">Company Email Address:</label>
            <input value="<?=$company_email?>" type="text" id="company_email" name="company_email" class="w211" />
          </div>
          <div class="clear"></div>
          <div class="full-width">
            <div class="row">
              <label class="coverage">Areas of Coverage: </label>
              <input value="<?=$area_coverage?>" type="text" id="area_coverage" name="area_coverage"  class="w385"/>
            </div>
            <div class="row">
              <label class="certification">Certifications and Accreditations: </label>
              <input value="<?=$certification?>" type="text" id="certification" name="certification" class="w303" />
            </div>
            <div class="row">
              <label class="coverage">Website URL: </label>
              <input value="<?=$web1?>" type="text" id="web1" name="web1" class="w385" />
            </div>
            <div class="row">
              <label class="coverage">Guesstimated Exposure Budget*: </label>
              <input    value="<?=$budget?>"
                        class="grey"
                        onfocus="if (this.value == 'Example: $300 to $600 per month') {this.value=''; jQuery('#budget').removeClass('grey').addClass('email');}" onblur="if (this.value == '') {this.value='Example: $300 to $600 per month'; jQuery('#budget').removeClass('email').addClass('grey');}"
                        type="text" id="budget" name="budget" class="w385" />
            </div>
            <div class="row">
              <label class="time">Best Time to Contact You? <?=$best_time?></label>
              <span>
              <select class="time" name="best_time" id="best_time">
                <?=clock_loop($best_time)?>
              </select>
              </span> <span>
              <select class="ampm" name="am_pm" id="am_pm">
                <option <?=$time_am_pm1?> value="AM"><span class="grey">AM</span></option>
                <option <?=$time_am_pm2?> value="PM"><span class="grey">PM</span></option>
              </select>
              <div class="clear"></div>
              </span> </div>
            <div class="row">
              <label class="member">Are You a Better Business Bureau Member:</label>
              <span class="yes">Yes
              <input <?=$member1?> type="radio" id="bureau_member" name="bureau_member" value="1" />
              </span> <span class="yes">No
              <input <?=$member2?> type="radio" id="bureau_member" name="bureau_member" value="0" />
              <span class="grey">( Select One )</span></span>
              <div class="clear"></div>
            </div>
            <div class="row">
              <label class="member">Do You Agree to the <a href="javascript:void();" onclick="javascript:return popup('/terms_and_services');" target="_blank"><u>Terms of Use</u></a>?:</label>
              <span class="yes">Yes
              <input <?=$agree1?> type="radio" id="terms" name="terms" title="terms" value="1" onclick="javascript: jQuery('#apply_expert').removeAttr('disabled'); jQuery('#error').html('');" />
              </span> <span class="yes">No
              <input <?=$agree2?> type="radio" id="terms" name="terms" title="no" value="0"  onclick="javascript: jQuery('#apply_expert').attr('disabled', 'disabled'); jQuery('#error').html('<font color=\'red\'><b>ERROR: </b>You must agree to the Terms of Use before submit...</font>');" />
              <span class="grey">( Select One )</span></span>
              <div class="clear"></div>
            </div>
            <div class="row">
               <label class="member">Captcha:
               <?php echo $image;  // this will show the captcha image?></label>
               <input  type="text" name="word"  />
               <span class="grey">( Enter these words )</span>
              <div class="clear"></div>
              <span id="error"><?=$debug?></span>
            </div>
            <div class="apply-button">
              <input type="submit" class="apply-now" name="apply_expert" id="apply_expert" value="Apply Now" />
            </div>
            <div class="clear"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="form product-form">
    <div class="wrapper">
      <h3 class="blue-light">Product Advertisers Form</h3>
      <span id="ad_loading">Processing, Please wait...<br><img alt="Snell Expert" title="Snell Expert" src='/images/loading.gif' border=0></span>
      <span id="ad_debug"></span>
      <div class="form-boxes">
        <form id="frm_advertiser" name="frm_advertiser" method="post" action="/apply" onsubmit="javascript:return chk_advertiser(document.frm_advertiser, 'frontend');">
         <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
         <input type="hidden" name="FormAction" id="FormAction" value="Add">
         <input type="hidden" name="FormType" id="FormType" value="advertiser">
         <input type="hidden" name="ad_has_error" id="ad_has_error" value="<?=$ad_has_error?>">
         <input type="hidden" name="ad_temp_state" id="ad_temp_state" value="<?=$ad_temp_state?>" />
         <input type="hidden" name="ad_temp_city" id="ad_temp_city" value="<?=$ad_temp_city?>" />
         <input type="hidden" name="ad_temp_zip" id="ad_temp_zip" value="<?=$ad_temp_zip?>" />
          <div class="form-left">
            <label class="first_name"><span class="red">*</span>First Name:</label>
            <input value="<?=$ad_first_name?>" type="text" id="ad_first_name" name="ad_first_name"/>
          </div>
          <div class="form-right">
            <label class="com_brand_name"><span class="red">*</span>Company Brand Name:</label>
            <input value="<?=$ad_brand_name?>" type="text" id="ad_brand_name" name="ad_brand_name" />
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="last_name"><span class="red">*</span>Last Name:</label>
            <input value="<?=$ad_last_name?>" type="text" id="ad_last_name" name="ad_last_name"/>
          </div>
          <div class="form-right">
            <label class="comp_detail">Company Phone Number:</label>
            <input value="<?=$ad_company_phone_no?>" type="text" id="ad_company_phone_no" name="ad_company_phone_no"/>
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="ph_num"><span class="red">*</span>Phone Number:</label>
            <input value="<?=$ad_phone1?>" type="text" id="ad_phone1" name="ad_phone1"/>
          </div>
          <div class="form-right">
            <label class="comp_detail">Company Email Address:</label>
            <input value="<?=$ad_company_email?>" type="text" id="ad_company_email" name="ad_company_email"/>
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="email"><span class="red">*</span>Email Address:</label>
            <input value="<?=$ad_email?>" type="text" id="ad_email" name="ad_email"/>
          </div>
          <div class="form-right">
            <label class="website">Website URL: </label>
            <input value="<?=$ad_web1?>" type="text" id="ad_web1" name="ad_web1" />
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="zip"><span class="red">*</span>State:</label>
          	<select name="ad_state" id="ad_state" onChange="javascript: ad_ajax_action('state', 'city', this.value);"></select>
          </div>
          <div class="form-right">
            <label class="email"><span class="red">*</span>City:</label>
            <select name="ad_city" id="ad_city" onChange="javascript: ad_ajax_action('city', 'zip', this.value);"></select>
          </div>
          <div class="clear"></div>
          <div class="form-left">
            <label class="zip"><span class="red">*</span>Zip Code:</label>
            <select name="ad_zip" id="ad_zip"></select>
          </div>
          <div class="row">
              <label class="coverage">Guesstimated Exposure Budget*: </label>
              <input value="<?=$ad_budget?>"
                     class="grey"
                     onfocus="if (this.value == 'Example: $300 to $600 per month') {this.value=''; jQuery('#ad_budget').removeClass('grey').addClass('email');}" onblur="if (this.value == '') {this.value='Example: $300 to $600 per month'; jQuery('#ad_budget').removeClass('email').addClass('grey');}"
                     type="text" id="ad_budget" name="ad_budget" class="w385" />
          </div>
          <div class="row">
            <label class="website">Product or Service you are advertising: </label>
            <input value="<?=$ad_advertising?>" type="text" id="ad_advertising" name="ad_advertising" />
          </div>
          <div class="row">
            <label class="website">General areas you want your Brand to be seen in: </label>
            <input value="<?=$ad_areas?>" type="text" id="ad_areas" name="ad_areas" />
          </div>
          <div class="row">
              <label class="member">Do You Agree to the <a href="javascript:void();" onclick="javascript:return popup('/terms_and_services');" target="_blank"><u>Terms of Use</u></a>?:</label>
              <span class="yes">Yes
              <input <?=$ad_agree1?> type="radio" id="ad_terms" name="ad_terms" title="terms" value="1" onclick="javascript: jQuery('#apply_advertise').removeAttr('disabled'); jQuery('#ad_error').html('');" />
              </span> <span class="yes">No
              <input <?=$ad_agree2?> type="radio" id="ad_terms" name="ad_terms" title="no" value="0"  onclick="javascript: jQuery('#apply_advertise').attr('disabled', 'disabled'); jQuery('#ad_error').html('<font color=\'red\'><b>ERROR: </b>You must agree to the Terms of Use before submit...</font>');" />
              <span class="grey">( Select One )</span></span>
              <div class="clear"></div>
            </div>
          <div class="row">
            <label class="member">Captcha:<?php echo $image;  // this will show the captcha image?></label>
            <input size="10" type="text" name="ad_word"  /><span class="grey">( Enter these words )</span>
            <div class="clear"></div>
            <span id="ad_error"><?=$ad_debug?></span>
         </div>
          <div class="apply-button">
            <input type="submit" class="apply-now" name="apply_advertise" id="apply_advertise" value="Apply Now" />
          </div>
          <div class="clear"></div>
        </form>
      </div>
    </div>
  </div>
  <div class="bottom-content">
    <div class="wrapper">
      <div class="bottom-left"> <img src="/public/images/apply-bottom-content.jpg" width="362" height="254" alt=""/> </div>
      <div class="bottom-right">
        <h3 class="blue-light">The Process to Applicants</h3>
        <p>Snell Experts appreciates your time! Less than the majority of our applicants do not get accepted to be on our website, however if you do not meet the requirements for Snell Experts you may re-apply during a later date. All applications received are reviewed multiple times by multiple people; the companies we recommend on here are highly rated and have an excellent standing with the Better Business Bureau. This is to ensure the best and most awesome companies are shown here on Snell Experts. After all we do want happy customers don’t we?</p>
      </div>
    </div>
  </div>
  <div class="clear"></div>