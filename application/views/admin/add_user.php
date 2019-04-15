<?
	include "../includes/config.php";	
	$site=new site("Snell");
	$er = new error();
	$db=new database();
	if(!isset($_SESSION['isadmin']))
	{
		$site->RedirectPage("login.php");
		exit();
	}
	$msg='';
	if (isset($_POST["doadd"])&& $_POST['doadd']==1) 
	{
		extract($_POST);
		if($_FILES['b_logo']['error'][0]==0)
		{
			//echo "come here";
			// include image processing code
			require_once(DIR_CLASS.'upload.php');
			
			$upld=new upload();
			$upld->filetypes = "jpg,jpeg,gif,png";
			$upld->filesiz = 1048576;
			$upld->filenames =  $_FILES['b_logo'];
			$upld->save_file=0;
			$upld->filepath = SITE_PATH."b_photos/";
			$upld->random=false;
			$tmp_ar=$upld->DoUpload();
			$er->pop();
			
		}
		//print_r($_FILES['b_logo']);
		
		//print_r($tmp_ar);
		//die();
		$logo_path=($tmp_ar[0]!='')?$tmp_ar[0]:'';
		$service = @implode('|',$services);
		$b_keyw = @implode('|',$b_keyword);
		$b_stat = @implode('|',$B_state);
		$b_city = @implode('|',$B_city);
		$entirestate=isset($entirestate)?$entirestate:0;
		
		$db->table="user";
		$db->db_key=array("name","b_name","email","phone1","phone2","address","city","state","zip","web1","web2","web3","web4","web5","m_start_dt","m_end_dt","busi_logo","service_indu","busi_keyword","busi_desc","busi_state","busi_city","entire_nation","add_date");
		$db->data_key=array("'$name'","'$b_name'","'$email'","'$phone1'","'$phone2'","'$addr'","'$_REQUEST[city]'","'$state'","'$zip'","'$web1'","'$web2'","'$web3'","'$web4'","'$web5'","'$start_dt'","'$end_dt'","'$logo_path'","'$service'","'$b_keyw'","'$busi_desc'","'$b_stat'","'$b_city'","'$entirestate'","'".TODAY."'");
		$rs=$db->insert_record();
		if($rs)
				$msg="User Added Successfuly to the Directory.";
			else
				$msg="Some technical error found to Add User";
		
	}

?>
<?
	include("header.php");
?>

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
		<?
		$sq1="select distinct(state_name) as st1 from us_states";
		$r2 = $db->RunSql($sq1);
			
		if($r2)
		{
			$ch_cnt=0;
			$j=0;
			echo '<select name="state"  onchange="clrcity();getCity(this);">';
				while($row_ct=mysql_fetch_assoc($r2))
				{
				?>		   
				  <option value="<?=$row_ct['st1'];?>" /><?=$row_ct['st1'];?></option>
			 <? } 
			echo '</select>';
	
		}
		?>
		</td>
        <td height="30">Website2 
          :
          <input name="web2" type="text" id="web2" /></td>
      </tr>
      <tr>
        <td>Email :          </td>
        <td height="30"><input name="email" type="text" id="email" /></td>
        <td>&nbsp;</td>
        <td>City :          
          <input name="city" type="hidden" id="city" /></td>
        <td height="30"><div id="addcity"><select name="city3" id="city3">
          <option value="">Select City</option>         
        </select></div></td>
        <td height="30">Website3 
          :
          <input name="web3" type="text" id="web3" /></td>
      </tr>
      <tr>
        <td>Phone :          </td>
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
<?
	include("footer.php");
?>
<script language="javascript" type="text/javascript">

	var xmlhttp;
	var objcitydiv;

	function getCity(statnam)
	{
		statnam = statnam.value;
		objcitydiv = document.getElementById("addcity");
		objcitydiv.innerHTML ="Loading...";
		
		//alert(str);
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		}
		var url="get_city.php";
		url=url+"?stat="+statnam;	
		xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}
	
	function stateChanged()
	{
		if (xmlhttp.readyState==4)
		{
			//alert("Good is response");
			//alert(xmlhttp.responseText);
			objcitydiv = document.getElementById("addcity");
			objcitydiv.innerHTML = xmlhttp.responseText;
			//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	}
	
	function GetXmlHttpObject()
	{
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			return new XMLHttpRequest();
		}
		if (window.ActiveXObject)
		{
			// code for IE6, IE5
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
		return null;
	}


    function shdiv(divid,disp)
	{
		//alert(divid);
		//alert(disp);
		obj = document.getElementById(divid);
		//alert(obj);
		if(obj)
			obj.style.display=disp;
	//	else
		//	alert(divid);
	}
function shdivgroup(cnt,obj,disp)
{
	//alert("comes into grp")
	for(i=1;i<=cnt;i++)
		shdiv(obj+i,disp);
}
function secity(selobj)
{
	document.getElementById("city").value=selobj.value;
}
function clrcity(selobj)
	{
	
		document.getElementById("city").value='';
	}
</script>