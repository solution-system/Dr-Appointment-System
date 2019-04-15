<script src="/include/js/user.js"></script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

	<form action="?" method="post" enctype="multipart/form-data" name="frm1">

	<? if($msg!='') {?>

    <tr>

      <td align="left"><span style="font-weight: bold">Add + User</span></td>

    </tr>

    <tr>

    <td align="center"><?=$msg;?></td>

    </tr>

<? }?>

  <tr>

    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td height="30" colspan="2"><u><strong>Personal</strong></u></td>

        <td width="3%">&nbsp;</td>

        <td width="11%">&nbsp;</td>

        <td width="26%" height="30"><u><strong>Origin</strong></u></td>

        <td width="32%" height="30"><u><strong>Origin</strong></u></td>

      </tr>

      <tr>

        <td width="12%">Name :          </td>

        <td width="16%" height="30"><input name="name" type="text" id="name" /></td>

        <td>&nbsp;</td>

        <td>Address:          </td>

        <td height="30"><input name="addr" type="text" id="addr" /></td>

        <td height="30">Website1 

          :

          <input name="web1" type="text" id="web1" /></td>

      </tr>

      <tr>

        <td>Business Name :          </td>

        <td height="30"><input name="b_name" type="text" id="b_name" /></td>

        <td>&nbsp;</td>

        <td>State :          </td>

        <td height="30">
            <select name="state"  onchange="clrcity();getCity(this);"></select>
		  </td>

        <td height="30">Website2:

          <input name="web2" type="text" id="web2" /></td>

      </tr>

      <tr>

        <td>Email:          </td>

        <td height="30"><input name="email" type="text" id="email" /></td>

        <td>&nbsp;</td>

        <td>City:

          <input name="city" type="hidden" id="city" /></td>

        <td height="30"><div id="addcity"><select name="city3" id="city3">

          <option value="">Select City</option>         

        </select></div></td>

        <td height="30">Website3:

          <input name="web3" type="text" id="web3" /></td>

      </tr>

      <tr>

        <td>Phone:          </td>

        <td height="30"><input name="phone1" type="text" id="phone1" /></td>

        <td>&nbsp;</td>

        <td>Zip code:          </td>

        <td height="30"><input name="zip" type="text" id="zip" /></td>

        <td height="30">Website4 

          :

          <input name="web4" type="text" id="web4" /></td>

      </tr>

      <tr>

        <td>Phone2:          </td>

        <td height="30"><input name="phone2" type="text" id="phone2" /></td>

        <td>&nbsp;</td>

        <td>Business Logo:          </td>

        <td height="30"><input name="b_logo[]" type="file" id="b_logo[]" /></td>

        <td height="30">Website5 

          :

          <input name="web5" type="text" id="web5" /></td>

      </tr>

      <tr>

        <td height="30" colspan="2"><u><strong>Membership:</strong></u></td>

        <td rowspan="4">&nbsp;</td>

        <td rowspan="4">&nbsp;</td>

        <td height="30" rowspan="4">&nbsp;</td>

        <td height="30"><u><strong>Service Industries :</strong></u> </td>

      </tr>

      <tr>

        <td>Start Date:          </td>

        <td height="30"><input name="start_dt" type="text" id="start_dt" /></td>

        <td height="30"><label>

          <input name="services[]" type="checkbox" id="services[]" value="Mold Services" />

          Mold Services</label> <label>

          <input name="services[]" type="checkbox" id="services[]" value="Water Services" />

          Water Services</label></td>

      </tr>

      <tr>

        <td>End Date :          </td>

        <td height="30"><input name="end_dt" type="text" id="end_dt" /></td>

        <td height="30"><label>

          <input name="services[]" type="checkbox" id="services[]" value="Fire Services" />

Fire Services</label>

          <label>

          <input name="services[]" type="checkbox" id="services[]" value="Emergy Services" />

Energy Services</label></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

        <td height="30">&nbsp;</td>

        <td height="30"><label>

          <input name="services[]" type="checkbox" id="services[]" value="Home Repair Services" />

          Home Repair Services</label></td>

      </tr>

    </table></td>

    </tr>

  <tr>

    <td><hr /></td>

  </tr>

  <tr>

    <td>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="28%" height="30"><u><strong>Business Keywords :</strong> </u></td>

        <td width="72%" height="30"><u><strong>Business Description :</strong></u> </td>

      </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        <td height="30" rowspan="10" valign="top"><textarea name="busi_desc" cols="75" rows="15" id="busi_desc"></textarea></td>

      </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30">&gt;&gt;

          <input name="b_keyword[]" type="text" id="b_keyword[]" /></td>

        </tr>

      <tr>

        <td height="30"><u><strong>Areas : </strong></u></td>

        <td height="30" align="right" valign="top"><label>

          <input name="entirestate" type="checkbox" id="entirestate" value="1" />

          Select Entire State Listing</label></td>

      </tr>

      <tr>

        <td height="30" colspan="2">

		<a class="prevPage browse left"></a>



		<!-- root element for scrollable -->

		<div class="scrollable" id="infinite">	

			

			<!-- root element for the items -->

			<div class="items">

            <?

		  	$sq="SELECT distinct(state_name) as st_name FROM `us_states`";

			$res_st = $db->RunSql($sq);

			$tot_st=$db->num_rows;

			$i=0;

			if($res_st)

				while($row_st=mysql_fetch_assoc($res_st))

				{

					$i++;

		  ?>

            <input type="checkbox" name="B_state[]" value="<?=$row_st['st_name'];?>" /><a href="javascript:void(0);" onclick="shdivgroup(<?=$tot_st;?>,'dv','none');shdiv('dv<?=$i;?>','block');" tyle="vertical-align:super; font-size:16px; background-color:#DFDFDF; color:#000000"><?=$row_st['st_name'];?></a> &nbsp; 

            <? }?>

		</div>

	

	</div>

	

	<!-- "next page" action -->

	<a class="nextPage browse right"></a>

	

	

	<br clear="all" />

	

	

	<script>

// What is $(document).ready ? See: http://flowplayer.org/tools/using.html#document_ready

$(document).ready(function() {



// initialize scrollable together with the autoscroll plugin

window.api = $("#infinite").scrollable().autoscroll({

	autoplay: false,

	api: true

});



	

});

</script>



         

         </td>

        </tr>

      <tr>

        <td height="30" colspan="2">

		<?

			$sq1="select distinct(state_name) as st1 from us_states";

			$r1 = $db->RunSql($sq1);

			$cnt=0;

			if($r1)

				while($row_st1=mysql_fetch_assoc($r1))

				{

					$cnt++;

					

				?>

				<div id="dv<?=$cnt;?>" style="display:<? if($cnt>1) echo 'none';?>">

					<h2><?="$row_st1[st1]";?></h2>

					<table width="100%" border="0" cellspacing="0" cellpadding="0">

					<? $sq2="select city_name from us_states where state_name='$row_st1[st1]' ";

					$r2 = $db->RunSql($sq2);

									

					if($r2)

					{

						$ch_cnt=0;

						$j=0;

						echo '<tr>';

						while($row_ct=mysql_fetch_assoc($r2))

						{

							$ch_cnt++;

							$j++;

							

						if($j>8)

						{

							$j=1;

							echo "</tr><tr>";

						}

		?>	

		   <td><label style="cursor:pointer;">

              <input name="B_city[]" type="checkbox" id="B_city[]" value="<?=$row_ct['city_name'];?>" />

              <?=$row_ct['city_name'];?></label></td>

		 <? } 

	   		echo '</tr>';

			}

	   // end of inner while?>

	   </table></div>

       <? } // end of outer while?>   

	   </td>

	   </tr>

        </table>

		</td>

        </tr>

   <tr>

    <td align="center" height="30">&nbsp;</td>

  </tr>

  <tr>

  <td align="center" height="30"><input type="submit" name="submit" value="Submit Directory Listing" />

    <input name="doadd" type="hidden" id="doadd" value="1" /></td>

  </tr></form>

	

</table>