<script type="text/javascript" src="/include/js/state_city_zip.js"></script>
<script type="text/javascript" src="/include/js/popup.js"></script>
<script type="text/javascript" src="/include/js/user_validation.js"></script>
<script type="text/javascript" src="/include/js/contact.js"></script>
<div class="wrapper">
    	<div class="contact-left">
        	<img src="/public/images/cont-left.jpg" width="285" height="200" alt=""/>
        </div>
        <div class="contact-right">
        	<h3 class="blue1">Get in touch with Dr. Website</h3>
            <p>Thank you for visiting Dr. Website! We are here to provide you with all services "Environmental". Some Services include Mold Inspection, Mold Cleanup, Mold Removal, Water Damage Repair, Water/Flood Dryout, WaterProofing, Fire Damage Repair, Smoke Damage Assessment, Energy Auditing and Restoration of Smoke Damage. That's just to name a few!</p>
        </div>
        <div class="clear"></div>
        <div class="contact">
            <div class="contact-left">
            	<h3 class="blue1">Dr. Website</h3>
                <p>Dr. Website is a Trademark of Dr. Website, LLC.<br/>
Contact a Dr. Website specialist today! </p>
				<p class="bold">Address:</p>
                <p>5437 Cedarmint Drive<br/>
Charlotte, N.C. 28227</p>
				<p class="bold">Phone Number:</p>
                <p>Corporate Office: <span class="blue1">1-888-493-0098</span><br/>
Fax Line: <span class="blue1">1-888-308-0095</span></p>
				<p class="bold">Email Address:</p>
                <p>support@Dr. Website</p>
                    
            </div>
            <div id="contact_result" class="contact-right">
            	<h3 class="heading">Contact Us</h3><!--<span class="gray">Fill your details here. We'll get back to you. Thanks.</span>-->
            	<form id="frm_contact" name="frm_contact" action="" method="post" onsubmit="javascript:return contact_form();">
               <input type="hidden" id="csrf_test_name" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>" />
               <input type="hidden" id="FormAction" name="FormAction" value="contactus">
               <!--<input type="hidden" id="to_email" name="to_email" value="abdul@solutionsystem.net">-->
               <input type="hidden" id="to_email" name="to_email" value="support@Dr. Website">
               <input type="hidden" id="to_name" name="to_name" value="Dr. Website">
                  <span id="loading">
                     Processing, Please wait...
                     <img src="/images/loading.gif" border="0">
                  </span>
                  <span id="msg"></span>
                	<div class="contact-form-left">
                        <label>First Name:</label>
                        <input tabindex="1" class="fn" type="text" name="first_name" id="first_name"/>
                      	<label>Email:</label>
                        <input tabindex="3" class="email" type="text" name="email" id="email"/>
                        <label>State:</label>
                        <select tabindex="5" class="state" name="state" id="state" onChange="javascript: ajax_action('state', 'city', this.value);"/></select>
                    </div>
                    <div class="contact-form-right">
                        <label>Last Name:</label>
                        <input tabindex="2" class="ln" type="text" name="last_name" id="last_name" />
                        <label>Phone:</label>
                        <input tabindex="4" class="ph" type="text" name="phone" id="phone" />
                        <label>City:</label>
                        <select tabindex="6" class="city" type="text" name="city" id="city"></select>
                    </div>
                    <div class="clear"></div>
                    <label class="comment">Comments:</label>
                    <textarea tabindex="7" class="comments" name="comments" id="comments"></textarea>
                    <div class="submit">
                        <input tabindex="8" type="submit" class="submit" value="submit"/>
                        <!--<div class="message">
                			<p>Thank you for contacting Dr. Website! We will respond to you as soon as possible!</p>
                		</div>-->
                    </div>
                    <div class="clear"></div>
               </form>
            </div>
            <div class="clear"></div>
            <span id="contact_result"></span>
        </div>
        <div class="thank-you">
        	<p>Thank You Visiting Dr. Website!</p>
        </div>
    </div>