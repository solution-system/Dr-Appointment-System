<?php
require_once('contact/popup-contactform.php');
?>
<link rel="STYLESHEET" type="text/css" href="/include/css/popup-contact.css">
<table width="800" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
		   <td valign="top"><?=$business_img_large?></td> 
			<td><table width="100%" border="1" cellspacing="0" cellpadding="5">
               <tr>
               	<td colspan=2>
                  	<h1><?=$name?> Profile</h1>
                     <p align=right>
                     <a href='javascript:fg_popup_form("fg_formContainer","fg_form_InnerContainer","fg_backgroundpopup");'>Contact Your Expert</a>
                     </p>
                  	<!--<span align=right><a href="javascript:void(0);" onclick="javascript:contact_form('<?=$id?>');"></a></span>-->
               	</td>
               </tr>
					<tr>
						<td>Name:</td>
						<td><?=$name?></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><?=$address?></td>
					</tr>
					<tr>
						<td>Website1:</td>
						<td><?=$web1?></td>
					</tr>
					<tr>
						<td>Business Name:</td>
						<td><?=$business_name?></td>
					</tr>
					<tr>
						<td>State:</td>
						<td><?=$state?></td>
					</tr>
					<tr>
						<td>Website2:</td>
						<td><?=$web2?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
					<tr>
						<td>City:</td>
						<td><?=$city?></td>
					</tr>
					<tr>
						<td>Website3:</td>
						<td><?=$web3?></td>
					</tr>
					<tr>
						<td>Phone1:</td>
						<td><?=$phone1?></td>
					</tr>
					<tr>
						<td>Phone2:</td>
						<td><?=$phone2?></td>
					</tr>
					<tr>
						<td>Zip code:</td>
						<td><?=$zip?></td>
					</tr>
					<tr>
						<td>Website4:</td>
					   <td><?=$web4?></td>
					</tr>
					
					<tr>
						<td>Website5:</td>
						<td><?=$web5?></td>
					</tr>
            	<?php
            	if (is_array($services))
            	{
            	   print '
                    	   <tr>
                        	<td><strong>Service Industries:</strong></td>
                        	<td>
            	   ';
               	foreach($services as $service):
                     print $service['name'] . ' Service<br>';
                  endforeach;
               }   
            	?>
                  </td>
               </tr>
<!--                  <tr>
                     <td colspan="2"><u><strong>Membership Detail:</strong> </u></td>
               	<tr>
                    	<td>Membership Start:</td>
                     <td><?=$membership_start?></td>
               	</tr>
               	<tr>
                    	<td>Membership End:</td>
                     <td><?=$membership_end?></td>
               	</tr>-->
            		<tr>
            		   <td></td>
            			<td align="center">
            				<table align="center" width="100%" border="1" cellspacing="0" cellpadding="5">
            					<tr>
            						<td  width="50%"><u><strong>Business Keywords:</strong>
            						</u></td>
            						<td width="50%"><u><strong>Business Description:</strong>
            						</u></td>
            					</tr>
            					<tr>
            						<td width="50%" valign=top>
                              	<?=$business_keyword?>
            						</td>
            						<td width="50%" valign=top>
            						   <?=$business_desc?>
            						</td>
            					</tr>
            				</table>
            			</td>
            		</tr>
            		<tr>
   						<td><u><strong>Areas:</strong> </u></td>
   						<td align="right"><?=$entire_nation?></td>
   					</tr>
   					<tr>
   						<td colspan="2">
                        Zip-Code Selected:
                        <ul>
                           <li>
                        <?php
                        print str_replace('|', '</li><li>', $user_zip);
                        ?>
                        	</li>
                        </ul>
   						</td>
   					</tr>
            </table>
         </td>
   	</tr>
</table>
<?php
require_once('contact/contactform-code.php');
?>