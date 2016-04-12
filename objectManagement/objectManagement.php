<script>

$(document).ready(function(){

    $('#object_user_username').on('change', function(){
        var current = $(this).val();
		// console.log(current);
		$('#object_asset_id').html('<select required="required" class="validate[\'required\'] text-input" name="object_asset_id" id="object_asset_id" >'+'<option disabled selected value="">--กำลังโหลดกลุ่มสินทรพย์ของ '+current+'</option>'+'</select>');
		// $('#object_asset_id').html();	
		$.getJSON('/gpsv4/getAssetByUser.php',{
			user_username : current
		}, function (responses) {
			console.log(responses);
			$('#object_asset_id').html('<select required="required" class="validate[\'required\'] text-input" name="object_asset_id" id="object_asset_id" ></select>');
			var options = '';
			$(responses).each(function(index,response){
				// console.log(response);
				options += '<option value="'+response.asset_id+'">'+response.asset_name+'</option>'; // fetch options
			});
			if(options == ''){
				options = '<option disabled selected value="">--ไม่มีกลุ่มสินทรัพย์ กรุณาเพิ่มกลุ่มสินทรัพย์</option>'; // fetch options
			}
			$('#object_asset_id').html(options); // add options
			
		});

		
    });
		 /*$("#object_payment").click(function(){
		if ($(this).val()=="บัตรเครดิต"||"เงินสด"||"จ่ายเช็ค") {
                    $("#object_money").show();
		
                } 
				if($(this).val()== ""){
					$("#object_money").hide();
				}
		 }); */
	//$("#object_money").onchange(function(){
          //  if ($(this).val()=="") {
			    // alert("กรอก กรอก กรอก");
			//}
     
			//$('#object_name_sell').html(<?php echo $query_object["object_name_sell"]; ?>);
//$('#object_payment_date').html("<?php echo $_POST["object_name_sell"]; ?>");
//$('#object_payment_date').html("<?php echo $query_object["object_name_sell"]; ?>");

  
  $("#object_money").keypress(function (e) {
    
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });


});
</script>

<?php
if(isset($_SESSION["authen_admin"])){
	if($_SESSION["user_usergroup_id"]==6){
		$_COOKIE['config_menu'] = 'profileConfig.php';
		$_COOKIE['config_submenu'] = '';
		echo '<meta http-equiv="refresh" content="0">';
		echo 'ขออภัย : ผู้ใช้ทดลองไม่สามารถแก้ไขข้อมูลในส่วนนี้ได้';
		exit();
	}
	if(isset($_REQUEST["deleteobject"])){
		if($_SESSION["user_usergroup_id"]==4){
				$permission = " and object_user_username='".$_SESSION["user_username"]."' ";
		}else if($_SESSION["user_usergroup_id"]==6){
				$permission = " and object_id in (".$_SESSION['user_object_id'].")  ";
		}
		$sql_object  = "DELETE FROM ".$table_prefix."_object WHERE  object_id=".$_REQUEST["object_id"]." ".$permission;
		mysql_query($sql_object)or  die(mysql_error());
		?>
		<script language="javascript">
			alert("ลบทรัพย์สินเสร็จเรียบร้อยแล้ว.");
			window.location ="?";
		</script>
		<?php
	}
	if(isset($_POST["addobject"])){
				$permission_a = $_POST["object_user_username"];
		$sql_user  = "SELECT * FROM ".$table_prefix."_user where user_username='".$permission_a."' ";
		$result_user = mysql_query($sql_user);
		if(mysql_num_rows($result_user)>0){
			$sql_object  = "SELECT * FROM ".$table_prefix."_object where object_IMEI='".$_POST["object_IMEI"]."' ";
			$result_object = mysql_query($sql_object);
			if(mysql_num_rows($result_object)<=0){
				$sql = "INSERT INTO ".$table_prefix."_object(object_IMEI
				,object_user_username
				,object_asset_id,object_categories_id
				,object_box_id,object_name
				,object_number,object_color
				,object_oil,object_oilconsume
				,object_ngvconsume
				,object_oilconsume2
				,object_ngvconsume2
				,object_overspeed
				,object_dateadded
				,object_simnumber
				,object_gpsboxpassword
				,object_active
				,object_AD2
				,object_input4
				,object_input2
				,object_input3
				,object_input1
				,object_inputAD1
				,object_inputAD2
				,object_fueltype
				,object_AD1LH
				,object_number_province
				,object_car_model
				,object_car_chassis
				,object_car_type
				,object_car_approve_id
				,object_car_mile
				,object_car_maintenance_tyre_mile
				,object_car_maintenance_oil_mile
				,object_car_maintenance_tyre
				,object_car_maintenance_oil
				,object_driver
				,object_park_limit
				,object_oil_tank
				,object_ngv_tank
				,object_temp_sensor
				,object_overtemp
				,object_camera
				,object_oil_mail
				,object_oil_sms
				,object_register_type
				,object_add_by";
if($_POST["object_magnetic_reader"] === "0" || $_POST["object_magnetic_reader"] === "1"){
 $sql .=",object_magnetic_reader";
}
if($_POST["object_dlt"] === "0" || $_POST["object_dlt"] === "1"){
 $sql .=",object_dlt";
}

$sql .=",object_name_sell";
$sql .=",object_payment";
$sql .=",object_payment_date";
$sql .=",object_money";
 $sql .=") VALUES(
				'".$_POST["object_IMEI"]."'
				,'".$permission_a."'
				,'".$_POST["object_asset_id"]."'
				,'".$_POST["object_categories_id"]."'
				,'".$_POST["object_box_id"]."'
				,'".$_POST["object_name"]."'
				,'".$_POST["object_number"]."'
				,'".$_POST["object_color"]."'
				,'".$_POST["emty_oil"]."|".$_POST["full_oil"]."'
				,'".$_POST["object_oilconsume"]."'
				,'".$_POST["object_ngvconsume"]."'
				,'".$_POST["object_oilconsume2"]."'
				,'".$_POST["object_ngvconsume2"]."'
				,'".$_POST["object_overspeed"]."'
				,'".date("Y-m-d H:i:s")."'
				,'".$_POST["object_simnumber"]."'
				,'".$_POST["object_gpsboxpassword"]."'
				,'".$_POST["object_active"]."'
				,'".$_POST["emty_ngv"]."|".$_POST["full_ngv"]."'
				,'".$_POST["object_input4"]."'
				,'".$_POST["object_input2"]."'
				,'".$_POST["object_input3"]."'
				,'".$_POST["object_input1"]."'
				,'".$_POST["object_inputAD1"]."'
				,'".$_POST["object_inputAD2"]."'
				,'".$_POST["object_fueltype"]."'
				,'".$_POST["min_AD1"]."|".$_POST["max_AD1"]."'
				,'".$_POST["object_number_province"]."'
				,'".$_POST["object_car_model"]."'
				,'".$_POST["object_car_chassis"]."'
				,'".$_POST["object_car_type"]."'
				,'".$_POST["object_car_approve_id"]."'
				,'".$_POST["object_car_mile"]."'
				,'".$_POST["object_car_mile"]."'
				,'".$_POST["object_car_mile"]."'
				,'".$_POST["object_car_maintenance_type"]."'
				,'".$_POST["object_car_maintenance_oil"]."'
				,'".$_POST["object_driver"]."'
				,'".$_POST["object_park_limit"]."'
				,'".$_POST["object_oil_tank"]."'
				,'".$_POST["object_ngv_tank"]."'
				,'".$_POST["object_temp_sensor"]."'
				,'".$_POST["object_overtemp"]."'
				,'".$_POST["object_camera"]."'
				,'".$_POST["object_oil_mail"]."'
				,'".$_POST["object_oil_sms"]."'
				,'".$_POST["object_register_type"]."'
				,'".$_SESSION['user_username']."'";
if($_POST["object_magnetic_reader"] === "0" || $_POST["object_magnetic_reader"] === "1"){
 $sql .=",'".$_POST["object_magnetic_reader"]."'";
}
if($_POST["object_dlt"] === "0" || $_POST["object_dlt"] === "1"){
 $sql .=",'".$_POST["object_dlt"]."'";
}

$sql .=",'".$_POST["object_name_sell"]."'";
$sql .=",'".$_POST["object_payment"]."'";
$sql .=",'".date("Y-m-d H:i:s")."'";
$sql .=",'".$_POST["object_money"]."'";
	$sql .=")";
				$result = mysql_query($sql) or die(mysql_error());
				
				// ADD DLT 's MASTER FILE
				if($_POST["object_dlt"] === "1"){
					include("masterFileService.php");
					addOrUpdateMasterFile($_POST);

				}
				
				?>
				<script language="javascript">
					alert("เพิ่มสินทรัพย์สำเร็จ.");
					window.location ="?";
				</script>
				<?php
			}else{
				?>
				<script language="javascript">
					alert("หมายเลข IMEI ถูกใช้งานแล้ว, กรุณาเปลี่ยนหมายเลข IMEI");
				</script>
				<?php
			}
		}else{
				?>
				<script language="javascript">
					alert("ชื่อผู้ใช้งานมีข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
				</script>
				<?php
		}
	}
	if(isset($_POST["editobject"])){
		if($_SESSION["user_usergroup_id"]==4){
						// $permission_a = " and object_user_username='".$_SESSION["user_username"]."'";
			// $permission2= " object_asset_id='".$_POST["object_asset_id"]."', ";
			if($_SESSION["user_usergroup_id"]==1){
			$permission2 = " object_user_username='".$_POST["object_user_username"]."', ";
			$permission2 .= " object_asset_id='".$_POST["object_asset_id"]."', ";
		}
		if($_SESSION["user_usergroup_id"]==6){
			$permission_a = " and object_id in (".$_SESSION['user_object_id'].") ";
			// $permission2= " object_asset_id='".$_POST["object_asset_id"]."', ";
		}
		if ($_POST['object_car_mile'] != $_POST['old_object_car_mile']){
			$changeMaintenanceMile = "object_car_maintenance_tyre_mile = '".$_POST["object_car_mile"]."',
			object_car_maintenance_oil_mile = '".$_POST["object_car_mile"]."',";
		} else $changeMaintenanceMile = "";
		$sql = "Update  ".$table_prefix."_object SET ".$permission2."
			
			
			object_name='".$_POST["object_name"]."',
			object_driver='".$_POST["object_driver"]."',
			object_number='".$_POST["object_number"]."',
			object_color='".$_POST["object_color"]."',
			object_overspeed='".$_POST["object_overspeed"]."',
			object_oilconsume='".$_POST["object_oilconsume"]."',
			object_ngvconsume='".$_POST["object_ngvconsume"]."',
			object_oilconsume2='".$_POST["object_oilconsume2"]."',
			object_ngvconsume2='".$_POST["object_ngvconsume2"]."',
			object_oil='".$_POST["emty_oil"]."|".$_POST["full_oil"]."',
			
			
			object_active='".$_POST["object_active"]."',
			object_AD2='".$_POST["emty_ngv"]."|".$_POST["full_ngv"]."',
			object_input4='".$_POST["object_input4"]."',
			object_input1='".$_POST["object_input1"]."',
			object_input2='".$_POST["object_input2"]."',
			object_input3='".$_POST["object_input3"]."',
			object_inputAD1='".$_POST["object_inputAD1"]."',
			object_inputAD2='".$_POST["object_inputAD2"]."',
			object_fueltype='".$_POST["object_fueltype"]."',
			object_AD1LH='".$_POST["min_AD1"]."|".$_POST["max_AD1"]."',
			object_number_province='".$_POST["object_number_province"]."',
			object_car_model='".$_POST["object_car_model"]."',
			object_car_chassis='".$_POST["object_car_chassis"]."',
			object_car_type='".$_POST["object_car_type"]."',
			object_car_approve_id='".$_POST["object_car_approve_id"]."',
			object_car_mile='".$_POST["object_car_mile"]."',".$changeMaintenanceMile."
			object_car_maintenance_tyre = '".$_POST["object_car_maintenance_tyre"]."',
			object_car_maintenance_oil = '".$_POST["object_car_maintenance_oil"]."',
			object_car_last_check = now(),
			object_check_poi = '".$_POST["object_check_poi"]."',
			object_oil_tank = '".$_POST["object_oil_tank"]."',
			object_ngv_tank = '".$_POST["object_ngv_tank"]."',
			object_park_limit = '".$_POST["object_park_limit"]."',
			object_overtemp = '".$_POST["object_overtemp"]."',
			object_temp_sensor = '".$_POST["object_temp_sensor"]."',
			object_camera = '".$_POST["object_camera"]."',
			object_oil_mail = '".$_POST["object_oil_mail"]."',
			object_oil_sms = '".$_POST["object_oil_sms"]."',
			object_check_zone = '".$_POST["object_check_zone"]."',
			object_over_park_alert = '".$_POST["object_over_park_alert"]."',
			object_register_type = '".$_POST["object_register_type"]."'";
if($_POST["object_magnetic_reader"] === "0" || $_POST["object_magnetic_reader"] === "1"){
$sql .=",object_magnetic_reader = '".$_POST["object_magnetic_reader"]."'";
}


$sql .="where object_id=".$_POST["object_id"]." ".$permission_a;
			mysql_query($sql) or die(mysql_error());

		
			?>
			
		<script language="javascript">
			alert("แก้ไขข้อมูลสินทรัพย์สำเร็จ");
			window.location ="?";
		</script>
		<?php


	//usergroupid!=4	------------------------------------------------------------------------------


		}else{
	
		// if($_SESSION["user_usergroup_id"]==4){
			// $permission_a = " and object_user_username='".$_SESSION["user_username"]."'";
			// $permission2= " object_asset_id='".$_POST["object_asset_id"]."', ";
		// }
		if($_SESSION["user_usergroup_id"]==1 || $_SESSION["user_usergroup_id"]==8){
			$permission2 = " object_user_username='".$_POST["object_user_username"]."', ";
			$permission2 .= " object_asset_id='".$_POST["object_asset_id"]."', ";
		}
		if($_SESSION["user_usergroup_id"]==6){
			$permission_a = " and object_id in (".$_SESSION['user_object_id'].") ";
			// $permission2= " object_asset_id='".$_POST["object_asset_id"]."', ";
		}
		if ($_POST['object_car_mile'] != $_POST['old_object_car_mile']){
			$changeMaintenanceMile = "object_car_maintenance_tyre_mile = '".$_POST["object_car_mile"]."',
			object_car_maintenance_oil_mile = '".$_POST["object_car_mile"]."',";
		} else $changeMaintenanceMile = "";
		$sql = "Update  ".$table_prefix."_object SET ".$permission2."
			object_IMEI='".$_POST["object_IMEI"]."',
			object_categories_id='".$_POST["object_categories_id"]."',
			object_box_id='".$_POST["object_box_id"]."',
			object_name='".$_POST["object_name"]."',
			object_driver='".$_POST["object_driver"]."',
			object_number='".$_POST["object_number"]."',
			object_color='".$_POST["object_color"]."',
			object_overspeed='".$_POST["object_overspeed"]."',
			object_oilconsume='".$_POST["object_oilconsume"]."',
			object_ngvconsume='".$_POST["object_ngvconsume"]."',
			object_oilconsume2='".$_POST["object_oilconsume2"]."',
			object_ngvconsume2='".$_POST["object_ngvconsume2"]."',
			object_oil='".$_POST["emty_oil"]."|".$_POST["full_oil"]."',
			object_simnumber='".$_POST["object_simnumber"]."',
			object_gpsboxpassword='".$_POST["object_gpsboxpassword"]."',
			object_active='".$_POST["object_active"]."',
			object_AD2='".$_POST["emty_ngv"]."|".$_POST["full_ngv"]."',
			object_input4='".$_POST["object_input4"]."',
			object_input1='".$_POST["object_input1"]."',
			object_input2='".$_POST["object_input2"]."',
			object_input3='".$_POST["object_input3"]."',
			object_inputAD1='".$_POST["object_inputAD1"]."',
			object_inputAD2='".$_POST["object_inputAD2"]."',
			object_fueltype='".$_POST["object_fueltype"]."',
			object_AD1LH='".$_POST["min_AD1"]."|".$_POST["max_AD1"]."',
			object_number_province='".$_POST["object_number_province"]."',
			object_car_model='".$_POST["object_car_model"]."',
			object_car_chassis='".$_POST["object_car_chassis"]."',
			object_car_type='".$_POST["object_car_type"]."',
			object_car_approve_id='".$_POST["object_car_approve_id"]."',
			object_car_mile='".$_POST["object_car_mile"]."',".$changeMaintenanceMile."
			object_car_maintenance_tyre = '".$_POST["object_car_maintenance_tyre"]."',
			object_car_maintenance_oil = '".$_POST["object_car_maintenance_oil"]."',
			object_car_last_check = now(),
			object_check_poi = '".$_POST["object_check_poi"]."',
			object_oil_tank = '".$_POST["object_oil_tank"]."',
			object_ngv_tank = '".$_POST["object_ngv_tank"]."',
			object_park_limit = '".$_POST["object_park_limit"]."',
			object_overtemp = '".$_POST["object_overtemp"]."',
			object_temp_sensor = '".$_POST["object_temp_sensor"]."',
			object_camera = '".$_POST["object_camera"]."',
			object_oil_mail = '".$_POST["object_oil_mail"]."',
			object_oil_sms = '".$_POST["object_oil_sms"]."',
			object_check_zone = '".$_POST["object_check_zone"]."',
			object_over_park_alert = '".$_POST["object_over_park_alert"]."',
			object_register_type = '".$_POST["object_register_type"]."',
			object_name_sell = '".$_POST["object_name_sell"]."',
			object_payment = '".$_POST["object_payment"]."',
			object_payment_date = '".date("Y-m-d H:i:s")."',
			object_money = '".$_POST["object_money"]."'
			
			";
if($_POST["object_magnetic_reader"] === "0" || $_POST["object_magnetic_reader"] === "1"){
$sql .=",object_magnetic_reader = '".$_POST["object_magnetic_reader"]."'";
}

if($_SESSION["user_usergroup_id"]==1){
if($_POST["object_dlt"] === "0" || $_POST["object_dlt"] === "1"){
$sql .=",object_dlt = '".$_POST["object_dlt"]."'";
}
}

//$sql .=",object_name_sell = '".$_POST["object_name_sell"]."'";
//$sql .=",object_payment = '".$_POST["object_payment"]."'";
//$sql .=",object_payment_date = '".date("Y-m-d H:i:s")."'";
//$sql .=",object_money = '".$_POST["object_money"]."'";

$sql .="where object_id=".$_POST["object_id"]." ".$permission_a;
			mysql_query($sql) or die(mysql_error());

			// UPDATE DLT 's MASTER FILE
			if($_SESSION["user_usergroup_id"]==1){
			if($_POST["object_dlt"] === "1"){
					include("masterFileService.php");
					addOrUpdateMasterFile($_POST);
			}else{
				include("masterFileService.php");
				// echo "<script> alert('updateMasterFile'); </script>";
				updateMasterFile($_POST);
			}
			}
		?>
		<script language="javascript">
			alert("แก้ไขข้อมูลสินทรัพย์สำเร็จ");
			window.location ="?";
		</script>
		<?php
			} 
		}
if(isset($_REQUEST["Action_type"])){
	?>
	<DIV class="">
	<SCRIPT type=text/javascript>
			window.addEvent('domready', function(){
				new FormCheck('addObjectForm');
			});
		</SCRIPT>
	<form name="addObjectForm" id="addObjectForm" action="?" method="post" enctype="multipart/form-data">
	<TABLE  border="0" cellpadding="1" cellspacing="0" width="100%" style="font-size:12px;font-weight:bold;color:#969696;max-width:700px;margin:0 auto;">
	<TR>
		<TD style="width:200px;" align="left" class="context">&nbsp;</TD>
		<TD style="width:10px;">&nbsp;</TD>
		<TD align="left">&nbsp;</TD>
	</TR>
	<?php
	if($_REQUEST["Action_type"]=="editobject"){
		$sql_object  = "SELECT * FROM ".$table_prefix."_object where object_id=".$_REQUEST["object_id"];
		$result_object = mysql_query($sql_object);
		if(mysql_num_rows($result_object)>0){
			$query_object = mysql_fetch_array($result_object, MYSQL_ASSOC);
		}
		?>
		<input type="hidden" name="editobject" value="1">
		<input type="hidden" name="object_id" value="<?=$query_object["object_id"]?>">
		<?php
	}else{?>
		<input type="hidden" name="addobject" value="1">
	<?php }?>
	<?php if($_SESSION["user_usergroup_id"] == 8 || $_SESSION["user_usergroup_id"] == 1){ ?>
	<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<tr>
		<td colspan="3">
			<hr>
			<strong>Data Sell Section</strong>
		</td>
	</tr>
	<TR>
		<TD align="right">ชื่อผู้ขาย &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input required="required type="text" class="validate['required'] text-input"  name="object_name_sell" id="object_name_sell" oninvalid="setCustomValidity('กรุณากรอกชื่อผู้ขาย')" onchange="try{setCustomValidity('')}catch(e){}" value="<?=$query_object["object_name_sell"]?><?=$_POST["object_name_sell"]?>" size="15"> <FONT COLOR="red">*</FONT>
		</TD>
	</TR>
	
	<TR>
		<TD align="right">การชำระ &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<select name="object_payment" id="object_payment" required="required" oninvalid="setCustomValidity('กรุณาเลือกประเภทการชำระเงิน')" onchange="try{setCustomValidity('')}catch(e){}" >
				<option value="">---เลือการชำระเงิน---</option>
				<option value="บัตรเครดิต">บัตรเครดิต</option>
				<option value="เงินสด">เงินสด</option>
				<option value="จ่ายเช็ค">จ่ายเช็ค</option>
			</select> <FONT COLOR="red">*</FONT>
			<script>
			  	  	document.getElementById('object_payment').value = '<?php echo $query_object['object_payment'];?>';
			  	  </script>
		</TD>
	</TR>
	<TR  id="object_money">
		<TD align="right">จำนวนเงิน &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" required="required" oninvalid="setCustomValidity('กรุณากรอกจำนวนเงิน')" onchange="try{setCustomValidity('')}catch(e){}"  class="validate['required'] text-input" name="object_money" id="object_money" value="<?=$query_object["object_money"]?><?=$_POST["object_money"]?>" size="15"> บาท  <FONT COLOR="red">*</FONT>
		</TD>
	</TR>
			<?php
			
    $date = $query_object["object_payment_date"];

				  $phpdate = strtotime($date);
					$mysqldate = date( 'Y-m-d', $phpdate );
			?>

	<TR>
		<TD align="right">วันที่จะชำระ &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="date" name="object_payment_date" id="object_payment_date" 
			value="<?=$mysqldate?>"> <FONT COLOR="red">*</FONT>
		</TD>
	</TR>
	

	<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	<?php } ?>
	<tr>
		<td colspan="3">
			<hr>
			<strong>Vehicle Profile Section</strong>
		</td>
	</tr>
	<TR>
		<TD align="right" valign="top">Username &raquo; </TD>
		<TD>&nbsp;</TD>
		<?php if($_SESSION["user_usergroup_id"]==4){?>
			<TD  align="left"><?=$query_object["object_user_username"]?></TD>
		<?php }else{?>
			<TD align="left" valign="top">
					<SELECT required="required" class="validate['required'] text-input" name="object_user_username" id="object_user_username">
					<OPTION value="" disabled selected >---เลือก user---</OPTION>
					<?php			
						$user_permission = "";
						if($_SESSION["user_usergroup_id"]==8){
							$user_permission = " AND user_add_by = '{$_SESSION["user_username"]}'";
						}
						$sql_user = "SELECT * FROM gps_user WHERE 1=1 ".$user_permission;
						$result_user = mysql_query($sql_user);
						if(mysql_num_rows($result_user)>0){
							while($query_user = mysql_fetch_assoc($result_user)){
							?>
								<OPTION value="<?=$query_user["user_username"]?>" <? if($query_user["user_username"]==$query_object["object_user_username"]||$query_user["user_username"]==$_POST["object_user_username"]){ echo "selected"; } ?> ><?=$query_user["user_username"]?></OPTION>
							<?php
							}
						}
					?>
			</SELECT> 
				<input type="hidden" name="object_user_username_old" id="object_user_username_old" value="<?=$query_object["object_user_username"]?><?=$_POST["object_user_username"]?>">
				<!--<input type="text" class="validate['required'] text-input" name="object_user_username" id="object_user_username" value="<?=$query_object["object_user_username"]?><?=$_POST["object_user_username"]?>"> <?php if($_SESSION["user_usergroup_id"]<3 || $_SESSION["user_usergroup_id"] == 8){?><a href="#" onclick="document.getElementById('searchUser1').style.display='block';document.getElementById('searchUser2').style.display='block';"><img src="images/profiles.png" border="0"><span class="configSubMenuActive">?????</span></a><?php }?>-->
			</TD>
		<?php }?>
	</TR>
	<TR>
		<TD align="right" valign="top" height="1"><div id="searchUser1" style="display:none;">ค้นหา &raquo; </DIV></TD>
		<TD></TD>
		<TD align="left">
				<div id="resultUserName"></div>
				<div id="searchUser2" style="display:none;">
							<input type="text" name="searchName" id="searchName" onkeyup="ajaxSend('POST','searchUser.php?user_name='+document.getElementById('searchName').value,'searchResult');">
							<div id="searchResult" class="scroll_searchResult"></div>
				</div>
		</TD>
	</TR>
	
	<TR>
		<TD align="right">กลุ่ม &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<SELECT required="required" class="validate['required'] text-input" name="object_asset_id" id="object_asset_id" oninvalid="setCustomValidity('กรุณาเลือกกลุ่มสินทรัพย์')" onchange="try{setCustomValidity('')}catch(e){}">
				<OPTION value="" disabled selected >---เลือกกลุ่ม---</OPTION>
				<?php
					$permission = "";
					if($_SESSION["user_usergroup_id"]==4){
						$permission = " and asset_user_id=".$_SESSION["user_id"];
					}else if($_SESSION["user_usergroup_id"]==8){
						$permission = " and user_add_by = '".$_SESSION["user_username"]."'";
					}else{
						$permission = " and asset_name<>'Buddy' and  asset_name<>'Personal' ";
					}

					$sql_search = "SELECT * 
									FROM ".$table_prefix."_asset,".$table_prefix."_user 
									WHERE ".$table_prefix."_asset.asset_user_id=".$table_prefix."_user.user_id 
									AND not ".$table_prefix."_asset.asset_name='' ".$permission." ".$orderby;
					$result_asset = mysql_query($sql_search);
					for($i_asset=1;$i_asset<=mysql_num_rows($result_asset);$i_asset++){
						$query_asset = mysql_fetch_array($result_asset, MYSQL_ASSOC);
					?>
						<OPTION value="<?=$query_asset["asset_id"]?>" <?php if($query_asset["asset_id"]==$query_object["object_asset_id"]||$query_asset["asset_id"]==$_POST["object_asset_id"]){echo "selected";}?>><?=$query_asset["asset_name"]?></OPTION>
					<?php
				}
				?>
			</SELECT>  <FONT COLOR="red">*</FONT>
		</TD>
	</TR>
	
	<TR>
		<TD align="right">IMEI &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="hidden" name="object_IMEI_old" id="object_IMEI_old" value="<?=$query_object["object_IMEI"]?><?=$_POST["object_IMEI"]?>">
			<input type="text" required="required" class="validate['required'] text-input"  name="object_IMEI" id="object_IMEI" value="<?=$query_object["object_IMEI"]?><?=$_POST["object_IMEI"]?>" 
			
			<?php 
					if($_SESSION["user_usergroup_id"]==4)
						{ 
							echo "disabled='disabled'"; 
						}
			?>
			
			> <FONT COLOR="red">*</FONT>
		</TD>
		</TD>
	</TR>
	<TR>
		<TD align="right">รหัสผ่านอุปกรณ์ &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_gpsboxpassword" id="object_gpsboxpassword" value="<?=$query_object["object_gpsboxpassword"]?><?=$_POST["object_gpsboxpassword"]?>" <?php if($_SESSION["user_usergroup_id"]==4){ echo "disabled='disabled'"; }?>>
		</TD>
	</TR>
	<TR>
		<TD align="right">SIM No. &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_simnumber" id="object_simnumber" value="<?=$query_object["object_simnumber"]?><?=$_POST["object_simnumber"]?>" <?php if($_SESSION["user_usergroup_id"]==4){ echo "disabled='disabled'"; }?>> <FONT COLOR="red">*</FONT>
		</TD>
	</TR>
	<TR>
		<TD align="right">รถลำดับที่ &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="hidden" name="object_name_old" id="object_name_old" value="<?=$query_object["object_name"]?><?=$_POST["object_name"]?>">
			<input type="text" class="validate['required'] text-input" name="object_name" id="object_name" value="<?=$query_object["object_name"]?><?=$_POST["object_name"]?>">
		</TD>
	</TR>
	<TR>
		<TD align="right">ชื่อผู้ขับ &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input" name="object_driver" id="object_driver" value="<?=$query_object["object_driver"]?><?=$_POST["object_driver"]?>">
		</TD>
	</TR>
	<TR>
		<TD align="right" valign="top">ประเภททรัพย์สิน &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<SELECT required="required" class="validate['required'] text-input" name="object_categories_id" id="object_categories_id" <?php if($_SESSION["user_usergroup_id"]==4){ echo "disabled='disabled'"; }?>>
				<OPTION value="">---เลือกประเภททรัพย์สิน---</OPTION>
				<?php
				$result_categories = mysql_query("select * from ".$table_prefix."_categories order by categories_id DESC");
				for($i_categories=1;$i_categories<=mysql_num_rows($result_categories);$i_categories++){
					$query_categories = mysql_fetch_array($result_categories, MYSQL_ASSOC);
					?>
					<OPTION value="<?=$query_categories["categories_id"]?>" <?php if($i_categories==1){echo "checked";}?> <?php if($query_categories["categories_id"]==$query_object["object_categories_id"]||$query_categories["categories_id"]==$_POST["object_categories_id"]){echo "selected";}?>><?=$query_categories["categories_name"]?></OPTION>
					<?php
				}
				?>
			</SELECT> <FONT COLOR="red">*</FONT>
		</TD>
	</TR>
	<TR>
		<TD align="right" valign="top">ใช้กล่องรุ่น &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<SELECT required="required" class="validate['required'] text-input" name="object_box_id" id="object_box_id" <?php if($_SESSION["user_usergroup_id"]==4){ echo "disabled='disabled'"; }?>>
				<OPTION value="">---เลือกรุ่นของกล่อง---</OPTION>
				<?php
				$result_box = mysql_query("select * from ".$table_prefix."_box order by box_id DESC");
				for($i_box=1;$i_box<=mysql_num_rows($result_box);$i_box++){
					$query_box = mysql_fetch_array($result_box, MYSQL_ASSOC);
					?>
					<OPTION value="<?=$query_box["box_id"]?>" <?php if($i_box==1){echo "checked";}?> <?php if($query_box["box_id"]==$query_object["object_box_id"]||$query_box["box_id"]==$_POST["object_box_id"]){echo "selected";}?>><?=$query_box["box_name"]?></OPTION>
					<?php
				}
				?>
			</SELECT> <FONT COLOR="red">*</FONT>
		</TD>
	</TR>

	<TR>
		<TD align="right">ป้ายทะเบียน &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" pattern="([0-9]?[ก-ฮ]{2}|[0-9]{2})-[0-9]{1,4}$" oninvalid="setCustomValidity('กรุณากรอกป้ายทะเบียนตามความจริง')" onchange="try{setCustomValidity('')}catch(e){}"  class="validate['required'] text-input"  name="object_number" id="object_number" value="<?=$query_object["object_number"]?><?=$_POST["object_number"]?>"> <FONT COLOR="red">*</FONT> [xx-xxxx] หรือ [xxx-xxxx]
		</TD>
	</TR>
	<TR>
		<TD align="right">เลขไมล์ &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_car_mile" id="object_car_mile" value="<?=$query_object["object_car_mile"]?><?=$_POST["object_car_mile"]?>"> กม.
			[Milage :
			<?php
				$milagecmd = "select * from gps_log".date('Ymd')." where log_IMEI = '".$query_object['object_IMEI']."' order by log_dateupdated desc limit 1";
				$milagequery = mysql_query($milagecmd);
				$milageresult = mysql_fetch_assoc($milagequery);
				echo ($milageresult['log_milage']/1000).' | '.number_format($query_object["object_car_mile"]-($milageresult['log_milage']/1000),2);
			?>
			Km.]
			<button type="button" id="sendMilage" onclick="sendMilageToId('<?php echo $query_object['object_id'];?>','<?php echo $query_object['object_IMEI'];?>')">ส่งเลขไมล์</button>
			<script>
				function sendMilageToId(id,imei){
					if(!confirm('กำลังจะส่งเลขไมล์ไปยัง IMEI : '+imei+'\nเลขไมล์ : '+$('#object_car_mile').val()+' กม.\nการส่งเลขไมล์จะใช้งานได้เฉพาะรุ่น T1/MVT380\nยืนยันการทำงาน?')) return false;
					$('#sendMilage').remove();
					$.get('/newgps/setMilage.php',{
						object_id : id,
						milage : $('#object_car_mile').val()
					}).done(function(resp,status,xhr){
						alert(resp);
					}).error(function(resp,status,xhr){
						alert(status);
					})
				}
			</script>
			<input type="hidden" name="old_object_car_mile" id="old_object_car_mile" value="<?=$query_object["object_car_mile"]?>"/>
		</TD>
	</TR>
	<TR>
		<TD align="right">จังหวัด &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<SELECT required="required" class="validate['required'] text-input" name="object_number_province" id="object_number_province" oninvalid="setCustomValidity('กรุณาระบุจังหวัด')" onchange="try{setCustomValidity('')}catch(e){}">
<option selected disabled value="">---- กรุณาเลือกจังหวัด ----</option>
<option value="กระบี่">กระบี่</option><option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option><option value="กาญจนบุรี">กาญจนบุรี</option><option value="กาฬสินธุ์">กาฬสินธุ์</option><option value="กำแพงเพชร">กำแพงเพชร</option><option value="ขอนแก่น">ขอนแก่น</option><option value="จันทบุรี">จันทบุรี</option><option value="ฉะเชิงเทรา">ฉะเชิงเทรา</option><option value="ชลบุรี">ชลบุรี</option><option value="ชัยนาท">ชัยนาท</option><option value="ชัยภูมิ">ชัยภูมิ</option><option value="ชุมพร">ชุมพร</option><option value="เชียงราย">เชียงราย</option><option value="เชียงใหม่">เชียงใหม่</option><option value="ตรัง">ตรัง</option><option value="ตราด">ตราด</option><option value="ตาก">ตาก</option><option value="นครนายก">นครนายก</option><option value="นครปฐม">นครปฐม</option><option value="นครพนม">นครพนม</option><option value="นครราชสีมา">นครราชสีมา</option><option value="นครศรีธรรมราช">นครศรีธรรมราช</option><option value="นครสวรรค์">นครสวรรค์</option><option value="นนทบุรี">นนทบุรี</option><option value="นราธิวาส">นราธิวาส</option><option value="น่าน">น่าน</option><option value="บึงกาฬ">บึงกาฬ</option><option value="บุรีรัมย์">บุรีรัมย์</option><option value="ปทุมธานี">ปทุมธานี</option><option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option><option value="ปราจีนบุรี">ปราจีนบุรี</option><option value="ปัตตานี">ปัตตานี</option><option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา</option><option value="พะเยา">พะเยา</option><option value="พังงา">พังงา</option><option value="พัทลุง">พัทลุง</option><option value="พิจิตร">พิจิตร</option><option value="พิษณุโลก">พิษณุโลก</option><option value="เพชรบุรี">เพชรบุรี</option><option value="เพชรบูรณ์">เพชรบูรณ์</option><option value="แพร่">แพร่</option><option value="ภูเก็ต">ภูเก็ต</option><option value="มหาสารคาม">มหาสารคาม</option><option value="มุกดาหาร">มุกดาหาร</option><option value="แม่ฮ่องสอน">แม่ฮ่องสอน</option><option value="ยโสธร">ยโสธร</option><option value="ยะลา">ยะลา</option><option value="ร้อยเอ็ด">ร้อยเอ็ด</option><option value="ระนอง">ระนอง</option><option value="ระยอง">ระยอง</option><option value="ราชบุรี">ราชบุรี</option><option value="ลพบุรี">ลพบุรี</option><option value="ลำปาง">ลำปาง</option><option value="ลำพูน">ลำพูน</option><option value="เลย">เลย</option><option value="ศรีสะเกษ">ศรีสะเกษ</option><option value="สกลนคร">สกลนคร</option><option value="สงขลา">สงขลา</option><option value="สตูล">สตูล</option><option value="สมุทรปราการ">สมุทรปราการ</option><option value="สมุทรสงคราม">สมุทรสงคราม</option><option value="สมุทรสาคร">สมุทรสาคร</option><option value="สระแก้ว">สระแก้ว</option><option value="สระบุรี">สระบุรี</option><option value="สิงห์บุรี">สิงห์บุรี</option><option value="สุโขทัย">สุโขทัย</option><option value="สุพรรณบุรี">สุพรรณบุรี</option><option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option><option value="สุรินทร์">สุรินทร์</option><option value="หนองคาย">หนองคาย</option><option value="หนองบัวลำภู">หนองบัวลำภู</option><option value="อ่างทอง">อ่างทอง</option><option value="อำนาจเจริญ">อำนาจเจริญ</option><option value="อุดรธานี">อุดรธานี</option><option value="อุตรดิตถ์">อุตรดิตถ์</option><option value="อุทัยธานี">อุทัยธานี</option><option value="อุบลราชธานี">อุบลราชธานี</option>
			</SELECT> <FONT COLOR="red">*</FONT>
			<?php
			  if (isset($query_object['object_number_province'])){
			  	?>
			  	  <script>
			  	  	document.getElementById('object_number_province').value = '<?php echo $query_object['object_number_province'];?><?=$_POST["object_number_province"]?>';
			  	  </script>
			  	<?php
			  }
			?>
		</TD>
	</TR>

	<TR>
		<TD align="right">ยี่ห้อรถ &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" required="required" pattern="^[A-Z]*$" oninvalid="setCustomValidity('กรุณากรอก ภาษาอังกฤษตัวพิมพ์ใหญ่เท่านั้น')" onchange="try{setCustomValidity('')}catch(e){}" required="required" quired class="validate['required'] text-input"  name="object_car_model" id="object_car_model" value="<?=$query_object["object_car_model"]?><?=$_POST["object_car_model"]?>"> <FONT COLOR="red">*</FONT> ภาษาอังกฤษ ตัวพิมพ์ใหญ่เท่านั้น
		</TD>
	</TR>
	<TR>
		<TD align="right">หมายเลขคัสซี &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" required="required" pattern="[A-Z0-9]{5,}$" oninvalid="setCustomValidity('กรุณารอก หมายเลขคัสซีตามความจริง')" onchange="try{setCustomValidity('')}catch(e){}"  class="validate['required'] text-input"  name="object_car_chassis" id="object_car_chassis" value="<?=$query_object["object_car_chassis"]?><?=$_POST["object_car_chassis"]?>"> <FONT COLOR="red">*</FONT>
		</TD>
	</TR>
	<TR>
		<TD align="right">ลักษณะรถบรรทุก &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<!--<input type="text" class="validate['required'] text-input"  name="object_car_type" id="object_car_type" value="<?=$query_object["object_car_type"]?><?=$_POST["object_car_type"]?>">-->
			<select name="object_car_type" id="object_car_type">
				<option value="">กรุณาเลือก</option>
				<option value="1">ลักษณะ 1 รถกระบะบรรทุก</option>
				<option value="2">ลักษณะ 2 รถตู้บรรทุก</option>
				<option value="3">ลักษณะ 3 รถบรรทุกของเหลว</option>
				<option value="4">ลักษณะ 4 รถบรรทุกวัตถุอันตราย</option>
				<option value="5">ลักษณะ 5 รถเฉพาะกิจ</option>
				<option value="6">ลักษณะ 6 รถพ่วง</option>
				<option value="7">ลักษณะ 7 รถกึ่งพ่วง</option>
				<option value="8">ลักษณะ 8 รถกึ่งพ่วงบรรทุกวัสดุยาว</option>
				<option value="9">ลักษณะ 9 รถลากจูง</option>
			</select>
			<script>
			document.getElementById('object_car_type').value = '<?=$query_object["object_car_type"]?><?=$_POST["object_car_type"]?>';
			</script>
		</TD>
	</TR>
	</TR>
	<TR>
		<TD align="right">ชนิดการจดทะเบียน &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<select required="required" name="object_register_type" id="object_register_type">
				<option selected="selected" disabled value="">กรุณาเลือก</option>
				<option value="0">ไม่มีข้อมูลประเภทและชนิดรถ</option>
				<option value="1000">รถโดยสาร ไม่ได้ระบุมาตรฐานและประเภทรถ</option>
				<option value="1101">รถโดยสาร มาตรฐาน 1 ก ไม่ได้ระบุประเภทรถ</option>
				<option value="1111">รถโดยสาร มาตรฐาน 1 ก ส่วนบุคคล</option>
				<option value="1121">รถโดยสาร มาตรฐาน 1 ก ไม่ประจำทาง</option>
				<option value="1131">รถโดยสาร มาตรฐาน 1 ก ประจำทาง</option>
				<option value="1102">รถโดยสาร มาตรฐาน 1 ข ไม่ได้ระบุประเภทรถ</option>
				<option value="1112">รถโดยสาร มาตรฐาน 1 ข ส่วนบุคคล</option>
				<option value="1122">รถโดยสาร มาตรฐาน 1 ข ไม่ประจำทาง</option>
				<option value="1132">รถโดยสาร มาตรฐาน 1 ข ประจำทาง</option>
				<option value="1201">รถโดยสาร มาตรฐาน 2 ก ไม่ได้ระบุประเภทรถ</option>
				<option value="1211">รถโดยสาร มาตรฐาน 2 ก ส่วนบุคคล</option>
				<option value="1221">รถโดยสาร มาตรฐาน 2 ก ไม่ประจำทาง</option>
				<option value="1231">รถโดยสาร มาตรฐาน 2 ก ประจำทาง</option>
				<option value="1202">รถโดยสาร มาตรฐาน 2 ข ไม่ได้ระบุประเภทรถ</option>
				<option value="1212">รถโดยสาร มาตรฐาน 2 ข ส่วนบุคคล</option>
				<option value="1222">รถโดยสาร มาตรฐาน 2 ข ไม่ประจำทาง</option>
				<option value="1232">รถโดยสาร มาตรฐาน 2 ข ประจำทาง</option>
				<option value="1203">รถโดยสาร มาตรฐาน 2 ค ไม่ได้ระบุประเภทรถ</option>
				<option value="1213">รถโดยสาร มาตรฐาน 2 ค ส่วนบุคคล</option>
				<option value="1223">รถโดยสาร มาตรฐาน 2 ค ไม่ประจำทาง</option>
				<option value="1233">รถโดยสาร มาตรฐาน 2 ค ประจำทาง</option>
				<option value="1204">รถโดยสาร มาตรฐาน 2 ง ไม่ได้ระบุประเภทรถ</option>
				<option value="1214">รถโดยสาร มาตรฐาน 2 ง ส่วนบุคคล</option>
				<option value="1224">รถโดยสาร มาตรฐาน 2 ง ไม่ประจำทาง</option>
				<option value="1234">รถโดยสาร มาตรฐาน 2 ง ประจำทาง</option>
				<option value="1205">รถโดยสาร มาตรฐาน 2 จ ไม่ได้ระบุประเภทรถ</option>
				<option value="1215">รถโดยสาร มาตรฐาน 2 จ ส่วนบุคคล</option>
				<option value="1225">รถโดยสาร มาตรฐาน 2 จ ไม่ประจำทาง</option>
				<option value="1235">รถโดยสาร มาตรฐาน 2 จ ประจำทาง</option>
				<option value="1301">รถโดยสาร มาตรฐาน 3 ก ไม่ได้ระบุประเภทรถ</option>
				<option value="1311">รถโดยสาร มาตรฐาน 3 ก ส่วนบุคคล</option>
				<option value="1321">รถโดยสาร มาตรฐาน 3 ก ไม่ประจำทาง</option>
				<option value="1331">รถโดยสาร มาตรฐาน 3 ก ประจำทาง</option>
				<option value="1302">รถโดยสาร มาตรฐาน 3 ข ไม่ได้ระบุประเภทรถ</option>
				<option value="1312">รถโดยสาร มาตรฐาน 3 ข ส่วนบุคคล</option>
				<option value="1322">รถโดยสาร มาตรฐาน 3 ข ไม่ประจำทาง</option>
				<option value="1332">รถโดยสาร มาตรฐาน 3 ข ประจำทาง</option>
				<option value="1303">รถโดยสาร มาตรฐาน 3 ค ไม่ได้ระบุประเภทรถ</option>
				<option value="1313">รถโดยสาร มาตรฐาน 3 ค ส่วนบุคคล</option>
				<option value="1323">รถโดยสาร มาตรฐาน 3 ค ไม่ประจำทาง</option>
				<option value="1333">รถโดยสาร มาตรฐาน 3 ค ประจำทาง</option>
				<option value="1304">รถโดยสาร มาตรฐาน 3 ง ไม่ได้บุประเภทรถ</option>
				<option value="1314">รถโดยสาร มาตรฐาน 3 ง ส่วนบุคคล </option>
				<option value="1324">รถโดยสาร มาตรฐาน 3 ง ไม่ประจำทาง </option>
				<option value="1334">รถโดยสาร มาตรฐาน 3 ง ประจำทาง</option>
				<option value="1304">รถโดยสาร มาตรฐาน 3 จ ไม่ได้ระบุประเภทรถ </option>
				<option value="1315">รถโดยสาร มาตรฐาน 3 จ ส่วนบุคคล</option>
				<option value="1325">รถโดยสาร มาตรฐาน 3 จ ไม่ประจำทาง</option>
				<option value="1335">รถโดยสาร มาตรฐาน 3 จ ประจำทาง</option>
				<option value="1306">รถโดยสาร มาตรฐาน 3 ฉ ไม่ได้ระบุประเภทรถ </option>
				<option value="1316">รถโดยสาร มาตรฐาน 3 ฉ ส่วนบุคคล  </option>
				<option value="1326">รถโดยสาร มาตรฐาน 3 ฉ ไม่ประจ าทาง</option>
				<option value="1336">รถโดยสาร มาตรฐาน 3 ฉ ประจำทาง</option>
				<option value="1401">รถโดยสาร มาตรฐาน 4 ก ไม่ได้ระบุประเภทรถ </option>
				<option value="1411">รถโดยสาร มาตรฐาน 4 ก ส่วนบุคคล  </option>
				<option value="1421">รถโดยสาร มาตรฐาน 4 ก ไม่ประจำทาง</option>
				<option value="1431">รถโดยสาร มาตรฐาน 4 ก ประจำทาง</option>
				<option value="1402">รถโดยสาร มาตรฐาน 4 ข ไม่ได้ระบุประเภทรถ </option>
				<option value="1412">รถโดยสาร มาตรฐาน 4 ข ส่วนบุคคล  </option>
				<option value="1422">รถโดยสาร มาตรฐาน 4 ข ไม่ประจำทาง</option>
				<option value="1432">รถโดยสาร มาตรฐาน 4 ข ประจำทาง</option>
				<option value="1403">รถโดยสาร มาตรฐาน 4 ค ไม่ได้ระบุประเภทรถ</option>
				<option value="1413">รถโดยสาร มาตรฐาน 4 ค ส่วนบุคคล  </option>
				<option value="1423">รถโดยสาร มาตรฐาน 4 ค ไม่ประจำทาง</option>
				<option value="1433">รถโดยสาร มาตรฐาน 4 ค ประจำทาง</option>
				<option value="1404">รถโดยสาร มาตรฐาน 4 ง ไม่ได้ระบุประเภทรถ </option>
				<option value="1414">รถโดยสาร มาตรฐาน 4 ง ส่วนบุคคล  </option>
				<option value="1424">รถโดยสาร มาตรฐาน 4 ง ไม่ประจำทาง </option>
				<option value="1434">รถโดยสาร มาตรฐาน 4 ง ประจำทาง</option>
				<option value="1405">รถโดยสาร มาตรฐาน 4 จ ไม่ได้ระบุประเภทรถ </option>
				<option value="1415">รถโดยสาร มาตรฐาน 4 จ ส่วนบุคคล  </option>
				<option value="1425">รถโดยสาร มาตรฐาน 4 จ ไม่ประจำทาง</option>
				<option value="1435">รถโดยสาร มาตรฐาน 4 จ ประจำทาง</option>
				<option value="1406">รถโดยสาร มาตรฐาน 4 ฉ ไม่ได้ระบุประเภทรถ </option>
				<option value="1416">รถโดยสาร มาตรฐาน 4 ฉ ส่วนบุคคล  </option>
				<option value="1426">รถโดยสาร มาตรฐาน 4 ฉ ไม่ประจำทาง</option>
				<option value="1436">รถโดยสาร มาตรฐาน 4 ฉ ประจำทาง</option>
				<option value="1501">รถโดยสาร มาตรฐาน 5 ก ไม่ได้ระบุประเภทรถ </option>
				<option value="1511">รถโดยสาร มาตรฐาน 5 ก ส่วนบุคคล  </option>
				<option value="1521">รถโดยสาร มาตรฐาน 5 ก ไม่ประจำทาง</option>
				<option value="1531">รถโดยสาร มาตรฐาน 5 ก ประจำทาง</option>
				<option value="1502">รถโดยสาร มาตรฐาน 5 ข ไม่ได้ระบุประเภทรถ </option>
				<option value="1512">รถโดยสาร มาตรฐาน 5 ข ส่วนบุคคล  </option>
				<option value="1522">รถโดยสาร มาตรฐาน 5 ข ไม่ประจำทาง</option>
				<option value="1532">รถโดยสาร มาตรฐาน 5 ข ประจำทาง</option>
				<option value="1601">รถโดยสาร มาตรฐาน 6 ก ไม่ได้ระบุประเภทรถ </option>
				<option value="1611">รถโดยสาร มาตรฐาน 6 ก ส่วนบุคคล </option>
				<option value="1621">รถโดยสาร มาตรฐาน 6 ก ไม่ประจำทาง</option>
				<option value="1631">รถโดยสาร มาตรฐาน 6 ก ประจำทาง</option>
				<option value="1602">รถโดยสาร มาตรฐาน 6 ข ไม่ได้ระบุประเภทรถ </option>
				<option value="1612">รถโดยสาร มาตรฐาน 6 ข ส่วนบุคคล  </option>
				<option value="1622">รถโดยสาร มาตรฐาน 6 ข ไม่ประจําทาง </option>
				<option value="1632">รถโดยสาร มาตรฐาน 6 ข ประจําทาง </option>
				<option value="1700">รถโดยสาร มาตรฐาน 7 ไม่ได้ระบุประเภทรถ </option>
				<option value="1710">รถโดยสาร มาตรฐาน 7 ส่วนบุคคล  </option>
				<option value="1720">รถโดยสาร มาตรฐาน 7 ไม่ประจําทาง </option>
				<option value="2000">รถบรรทุก ไม่ได้ระบุลักษณะและประเภทรถ </option>
				<option value="2100">รถบรรทุก ลักษณะ 1 ไม่ได้ระบุประเภทรถ </option>
				<option value="2110">รถบรรทุก ลักษณะ 1 ส่วนบุคคล </option>
				<option value="2120">รถบรรทุก ลักษณะ 1 ไม่ประจําทาง </option>
				<option value="2200">รถบรรทุก ลักษณะ 2 ไม่ได้ระบุประเภทรถ </option>
				<option value="2210">รถบรรทุก ลักษณะ 2 ส่วนบุคคล </option>
				<option value="2220">รถบรรทุก ลักษณะ 2 ไม่ประจําทาง </option>
				<option value="2300">รถบรรทุก ลักษณะ 3 ไม่ได้ระบุประเภทรถ </option>
				<option value="2310">รถบรรทุก ลักษณะ 3 ส่วนบุคคล </option>
				<option value="2320">รถบรรทุก ลักษณะ 3 ไม่ประจําทาง </option>
				<option value="2400">รถบรรทุก ลักษณะ 4 ไม่ได้ระบุประเภทรถ </option>
				<option value="2410">รถบรรทุก ลักษณะ 4 ส่วนบุคคล </option>
				<option value="2420">รถบรรทุก ลักษณะ 4 ไม่ประจําทาง </option>
				<option value="2500">รถบรรทุก ลักษณะ 5 ไม่ได้ระบุประเภทรถ </option>
				<option value="2510">รถบรรทุก ลักษณะ 5 ส่วนบุคคล </option>
				<option value="2520">รถบรรทุก ลักษณะ 5 ไม่ประจําทาง </option>
				<option value="2600">รถบรรทุก ลักษณะ 6 ไม่ได้ระบุประเภทรถ </option>
				<option value="2610">รถบรรทุก ลักษณะ 6 ส่วนบุคคล </option>
				<option value="2620">รถบรรทุก ลักษณะ 6 ไม่ประจําทาง </option>
				<option value="2700">รถบรรทุก ลักษณะ 7 ไม่ได้ระบุประเภทรถ </option>
				<option value="2710">รถบรรทุก ลักษณะ 7 ส่วนบุคคล </option>
				<option value="2720">รถบรรทุก ลักษณะ 7 ไม่ประจำทาง</option>
				<option value="2800">รถบรรทุก ลักษณะ 8 ไมไ่ด้ระบุประเภทรถ </option>
				<option value="2810">รถบรรทุก ลักษณะ 8 ส่วนบุคคล </option>
				<option value="2820">รถบรรทุก ลักษณะ 8 ไม่ประจำทาง</option>
				<option value="2900">รถบรรทุก ลักษณะ 9 ไมไ่ด้ระบุประเภทรถ </option>
				<option value="2910">รถบรรทุก ลักษณะ 9 ส่วนบุคคล </option>
				<option value="2920">รถบรรทุก ลักษณะ 9 ไม่ประจำทาง</option>
			</select> <FONT COLOR="red">*</FONT>
			<script>
			document.getElementById('object_register_type').value = '<?=$query_object["object_register_type"]?><?=$_POST["object_register_type"]?>';
			</script>
		</TD>
	</TR>
	<TR>
		<TD align="right">หมายเลขการรับรอง &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_car_approve_id" id="object_car_approve_id" value="<?=$query_object["object_car_approve_id"]?><?=$_POST["object_car_approve_id"]?>">
		</TD>
	</TR>
	<? if($_SESSION["user_usergroup_id"]==1 || $_SESSION["user_usergroup_id"]==8){ ?>
	<TR>
		<TD align="right">เครื่องอ่านบัตร &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
				<select name="object_magnetic_reader" id="object_magnetic_reader">
				<option value="">กรุณาเลือก</option>
				<option value="0">ไม่มี</option>
				<option value="1">มี</option>
			</select>
			<script>
			document.getElementById('object_magnetic_reader').value = '<?=$query_object["object_magnetic_reader"]?><?=$_POST["object_magnetic_reader"]?>';
			</script>
		</TD>
	</TR>
	<? if($_SESSION["user_usergroup_id"]!=8){ ?>
	<TR>
		<TD align="right">ส่งข้อมูลให้กรมขนส่งทางบก &raquo; </TD>
			<TD>&nbsp;</TD>
		<TD align="left">
				<select name="object_dlt" id="object_dlt">
				<option value="">กรุณาเลือก</option>
				<option value="0">ไม่ส่ง</option>
				<option value="1">ส่ง</option>
			</select>
			<script>
			document.getElementById('object_dlt').value = '<?=$query_object["object_dlt"]?><?=$_POST["object_dlt"]?>';
			</script>
		</TD>
	</TR>
<? } ?>
	<? } ?>
	<tr>
		<td colspan="3">
			<hr>
			<strong>Fuel Section</strong>
		</td>
	</tr>
	<TR>
		<TD align="right">ประเภทเชื้อเพลิง &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_fueltype" id="object_fueltype" value="<?=$query_object["object_fueltype"]?><?=$_POST["object_fueltype"]?>">
		</TD>
	</TR>
	<TR>
		<TD align="right">น้ำมันเต็มถัง &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input" name="object_oil_tank" id="object_oil_tank" value="<?=$query_object["object_oil_tank"]?><?=$_POST["object_oil_tank"]?>" size="10"> ลิตร
		</TD>
	</TR>
	<TR>
		<TD align="right">NGV/LPG เต็มถัง &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input" name="object_ngv_tank" id="object_ngv_tank" value="<?=$query_object["object_ngv_tank"]?><?=$_POST["object_ngv_tank"]?>" size="10"> ลิตร
		</TD>
	</TR>
	<TR>
		<TD align="right">ระดับเชื้อเพลิงน้ำมัน &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<?php $oil = explode("|",$query_object["object_oil"]);?>
			ต่ำสุด. : <input type="text" class="validate['required'] text-input" name="full_oil" id="full_oil" value="<?=$oil[1]?>" size="8"> สูงสุด. : <input type="text" class="validate['required'] text-input" name="emty_oil" id="emty_oil" value="<?=$oil[0]?>"  size="8">
		</TD>
	</TR>
	<TR>
		<TD align="right">ระดับเชื้อเพลิง LPG/NGV &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<?php $ngv = explode("|",$query_object["object_AD2"]);?>
			สูงสุด. : <input type="text" class="validate['required'] text-input" name="full_ngv" id="full_ngv" value="<?=$ngv[1]?>" size="8"> ต่ำสุด. : <input type="text" class="validate['required'] text-input" name="emty_ngv" id="emty_ngv" value="<?=$ngv[0]?>"  size="8">
		</TD>
	</TR>
	<TR>
		<TD align="right">อัตราการสิ้นเปลืองเชื้อเพลิง &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			น้ำมัน : <input type="text" class="validate['required'] text-input" name="object_oilconsume" id="object_oilconsume" value="<?=$query_object["object_oilconsume"]?><?=$_POST["object_oilconsume"]?>"  size="3"> กม./ลิตร
			&nbsp;&nbsp;LPG/NGV : <input type="text" class="validate['required'] text-input" name="object_ngvconsume" id="object_ngvconsume" value="<?=$query_object["object_ngvconsume"]?><?=$_POST["object_ngvconsume"]?>"  size="3">กม.กก.
		</TD>
	</TR>
	<TR>
		<TD align="right">อัตราการสิ้นเปลืองเชื้อเพลิงแบบผสม &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			น้ำมัน : <input type="text" class="validate['required'] text-input" name="object_oilconsume2" id="object_oilconsume2" value="<?=$query_object["object_oilconsume2"]?><?=$_POST["object_oilconsume2"]?>"  size="3"> กม./ลิตร&nbsp;&nbsp;LPG/NGV : <input type="text" class="validate['required'] text-input" name="object_ngvconsume2" id="object_ngvconsume2" value="<?=$query_object["object_ngvconsume2"]?><?=$_POST["object_ngvconsume2"]?>"  size="3"> กม./กก.
		</TD>
	</TR>
	<TR>
		<TD align="right">ระยะการบำรุงรักษา &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			น้ำมันเครื่อง : <input type="text" class="validate['required'] text-input" name="object_car_maintenance_oil" id="object_car_maintenance_oil" value="<?=$query_object["object_car_maintenance_oil"]?>" size="6"> กม.
			&nbsp;&nbsp;ระยะการบำรุงรักษาครั้งสุดท้ายที่ <?=$query_object["object_car_maintenance_oil_mile"]?> กม.
			<br/>ยางรถยนต์ : <input type="text" class="validate['required'] text-input" name="object_car_maintenance_tyre" id="object_car_maintenance_tyre" value="<?=$query_object["object_car_maintenance_tyre"]?>" size="6"> กม.
			&nbsp;&nbsp;ระยะการบำรุงรักษาครั้งสุดท้ายที่ <?=$query_object["object_car_maintenance_tyre_mile"]?> กม.
		</TD>
	</TR>
	<tr>
		<td colspan="3">
			<hr>
			<strong>Notify Section</strong>
		</td>
	</tr>
	<TR>
		<TD align="right">สถานะอุปกรณ์ &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<SELECT class="validate['required'] text-input" name="object_active" id="object_active">
				<OPTION value="">---กรุณาเลือกสถานะ---</OPTION>
				<OPTION value="1" <?php if($query_object["object_active"]=="1"||$_POST["object_active"]=="1"){echo "selected";}?>>ปกติ</OPTION>
				<OPTION value="0" <?php if($query_object["object_active"]=="0"||$_POST["object_active"]=="0"){echo "selected";}?>>ระงับการใช้งาน</OPTION>
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD align="right">การแจ้งเตือนเมื่อเข้า-ออกจุดจอด &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<select name="object_check_poi" id="object_check_poi">
				<option value="0">ปิดการแจ้งเตือนทางอีเมล</option>
				<option value="1">เปิดการแจ้งเตือนทางอีเมล</option>
			</select>
			<script>
			document.getElementById('object_check_poi').value = '<?=$query_object["object_check_poi"]?><?=$_POST["object_check_poi"]?>';
			</script>
		</TD>
	</TR>
		<TR>
		<TD align="right">การแจ้งเตือนเมื่อเข้า-ออกโซน &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<select name="object_check_zone" id="object_check_zone">
				<option value="0">ปิดการแจ้งเตือน</option>
				<option value="1">เปิดการแจ้งเตือน</option>
			</select>
			<script>
			document.getElementById('object_check_zone').value = '<?=$query_object["object_check_zone"]?><?=$_POST["object_check_zone"]?>';
			</script>
		</TD>
	</TR>
	</TR>
	<TR>
	<TR>
		<TD align="right">เตือนเมื่อน้ำมันเปลี่ยนแปลง &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input name="object_oil_mail" id="object_oil_mail" value="<?=$query_object["object_oil_mail"]?><?=$_POST["object_oil_mail"]?>">
			% [ทางอีเมล]
		</TD>
	</TR>
	<TR>
		<TD align="right"> [0 คือไม่แจ้งเตือน] </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input name="object_oil_sms" id="object_oil_sms" value="<?=$query_object["object_oil_sms"]?><?=$_POST["object_oil_sms"]?>">
			% [ทาง SMS]
		</TD>
	</TR>
	<TR>
		<TD align="right">สีเส้นทาง &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input" name="object_color" id="object_color" value="<?=$query_object["object_color"]?><?=$_POST["object_color"]?>" size="10" style="background-color:<?=$query_object["object_color"]?><?=$_POST["object_color"]?>">
			<span style="cursor:hand;"  onclick="showColorPicker(this,document.addObjectForm.object_color)"><img src="/gpsv3/images/colorPicker.jpg" border=0></span>
		</TD>
	</TR>
	<TR>
		<TD align="right">จำกัดความเร็ว &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input" name="object_overspeed" id="object_overspeed" value="<?php if($query_object["object_overspeed"]==null){echo "70";}else{ echo $query_object["object_overspeed"]?><?=$_POST["object_overspeed"];}?>" size="10"> กม./ชม.
		</TD>
	</TR>
	<TR>
		<TD align="right">จำกัดอุณหภูมิ &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input" name="object_overtemp" id="object_overtemp" value="<?=$query_object["object_overtemp"]?><?=$_POST["object_overtemp"]?>" size="5"> &deg;C
		</TD>
	</TR>
	<TR>
	<TD align="right">การแจ้งเตือนจอดรถติดเครื่องนานกว่ากำหนด &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<select name="object_over_park_alert" id="object_over_park_alert">
				<option value="0">ปิดการแจ้งเตือน</option>
				<option value="1">เปิดการแจ้งเตือน</option>
			</select>
			<script>
			document.getElementById('object_over_park_alert').value = '<?=$query_object["object_over_park_alert"]?>';
			</script>
		</TD>
	</TR>
	<TR>
		<TD align="right">จำกัดระยะเวลาติดเครื่องจอดรถ &raquo;</TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input" name="object_park_limit" id="object_park_limit" value="<?=$query_object["object_park_limit"]?><?=$_POST["object_park_limit"]?>" size="10"> นาที
		</TD>
	</TR>
	<? if($_SESSION["user_usergroup_id"]==1 || $_SESSION["user_usergroup_id"]==8){ ?>
	<tr id="Input">
		<td colspan="3">
			<hr>
			<strong>Input Section</strong>
		</td>
	</tr>
	<TR>
		<TD align="right">AD1 &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_inputAD1" id="object_inputAD1" value="<?=$query_object["object_inputAD1"]?><?=$_POST["object_inputAD1"]?>" size="4">&nbsp;
			<?php $AD1LH = explode("|",$query_object["object_AD1LH"]);?>
			High : <input type="text" class="validate['required'] text-input" name="max_AD1" id="max_AD1" value="<?=$AD1LH[1]?>" size="4"> Low : <input type="text" class="validate['required'] text-input" name="min_AD1" id="min_AD1" value="<?=$AD1LH[0]?>"  size="4">
		</TD>
	</TR>
	<TR>
		<TD align="right">AD2 &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_inputAD2" id="object_inputAD2" value="<?=$query_object["object_inputAD2"]?><?=$_POST["object_inputAD2"]?>" size="4">&nbsp;
		</TD>
	</TR>
	<TR>
		<TD align="right">Temperature Type &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<select name="object_temp_sensor" id="object_temp_sensor">
				<option value="AD2">AD2</option>
				<option value="SENSOR">SENSOR</option>
			</select>
			<script>
				$('#object_temp_sensor').val('<?=$query_object["object_temp_sensor"]?><?=$_POST["object_temp_sensor"]?>');
			</script>
			<!-- <input type="text" class="validate['required'] text-input"  name="object_temp_sensor" id="object_temp_sensor" value="<?=$query_object["object_temp_sensor"]?><?=$_POST["object_temp_sensor"]?>" size="4">&nbsp;(AD2/SENSOR) -->
		</TD>
	</TR>
	<TR>
		<TD align="right">Input &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			1: <input type="text" class="validate['required'] text-input"  name="object_input1" id="object_input1" value="<?=$query_object["object_input1"]?><?=$_POST["object_input1"]?>" size="4" maxlength="10">
			2: <input type="text" class="validate['required'] text-input"  name="object_input2" id="object_input2" value="<?=$query_object["object_input2"]?><?=$_POST["object_input2"]?>" size="4" maxlength="10">
			3: <input type="text" class="validate['required'] text-input"  name="object_input3" id="object_input3" value="<?=$query_object["object_input3"]?><?=$_POST["object_input3"]?>" size="4" maxlength="10">
			4: <input type="text" class="validate['required'] text-input"  name="object_input4" id="object_input4" value="<?=$query_object["object_input4"]?><?=$_POST["object_input4"]?>" size="4" maxlength="10">
		</TD>
	</TR>
		<TR>
		<TD align="right">Camera &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<select name="object_camera" id="object_camera">
				<option value="1">เปิดใช้งาน</option>
				<option value="0">ปิดใช้งาน</option>
			</select>
			<script>
				$('#object_camera').val('<?=$query_object["object_camera"]?><?=$_POST["object_camera"]?>');
			</script>
			<!-- <input type="text" class="validate['required'] text-input"  name="object_temp_sensor" id="object_temp_sensor" value="<?=$query_object["object_camera"]?><?=$_POST["object_camera"]?>" size="4">&nbsp;(AD2/SENSOR) -->
		</TD>
	</TR>

	<!-- <TR>
		<TD align="right">Input4 &raquo; </TD>
		<TD>&nbsp;</TD>
		<TD align="left">
			<input type="text" class="validate['required'] text-input"  name="object_input4" id="object_input4" value="<?=$query_object["object_input4"]?><?=$_POST["object_input4"]?>" size="4">
		</TD>
	</TR> -->
	<? } ?>
	<TR>
		<TD colspan="3">&nbsp;</TD>
	</TR>
	<TR id="submit">
		<TD>&nbsp;</TD>
		<TD align="left">&nbsp;</TD>
		<TD align="left">
					<?php if($_REQUEST["Action_type"]=="editobject"){?>
					<input type="submit" name="editButton" value="บันทึก" class="loginsubmit">
					<?php }else{?>
					<input type="submit" name="addButton" value="บันทึกอุปกรณ์" class="loginsubmitlong">
					<?php }?>
					&nbsp;
					<input type="button" name="cancelButton" value="ยกเลิก" onclick="document.location='?'"  class="loginsubmit">
		</TD>
	</TR>
	<TR>
		<TD colspan="3">&nbsp;</TD>
	</TR>
	
	</TABLE>
	</form>
	</DIV>
<?php }else{?>
	<script type="text/javascript" language="javascript" src="/gpsv3/media/js/jquery.js"></script>
	<style type="text/css" title="currentStyle">
		@import "/gpsv3/media/css/demo_table_jui.css";
		@import "/gpsv3/media/themes/smoothness/jquery-ui-1.7.2.custom.css";
	</style>
	<script type="text/javascript" language="javascript" src="/gpsv3/media/js/jquery.dataTables_th5.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			oTable=$('#allstudentTable').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers"
			});
		} );
	</script>
	<table cellspacing="0" cellpadding="0" border="0" class="display"  id="allstudentTable">
	<thead>
	<tr>
		<TH>IMEI </TH>
		<TH>ป้ายทะเบียน </TH>
		<TH>ชื่อทรัพย์สิน </TH>
		<TH>กลุ่ม </TH>
		<TH>ประเภท </TH>
		<TH>แก้ไข</TH>
	</TR>
	</thead>
	<tbody>
	<?php
	if($_SESSION["user_usergroup_id"]==4){
			$permission = " and ".$table_prefix."_object.object_user_username='".$_SESSION["user_username"]."'";
	} else if($_SESSION["user_usergroup_id"]==6){
			$permission = " and object_id in (".$_SESSION['user_object_id'].") ";
	} else if($_SESSION["user_usergroup_id"]==8){
			$permission = " and object_add_by ='".$_SESSION['user_username']."' ";
	}
	$sql_search = "SELECT * FROM ".$table_prefix."_object,".$table_prefix."_user,".$table_prefix."_categories,".$table_prefix."_asset WHERE ".$table_prefix."_object.object_user_username=".$table_prefix."_user.user_username and  ".$table_prefix."_object.object_categories_id=".$table_prefix."_categories.categories_id and ".$table_prefix."_object.object_asset_id=".$table_prefix."_asset.asset_id ".$permission." ".$orderby;

	$result_object = mysql_query($sql_search);
	if(mysql_num_rows($result_object)<=0){
	?>
	<tr class="gradeA">
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
	</tr>
	<?php
	}
	for($i_object=1;$i_object<=mysql_num_rows($result_object);$i_object++){
		$query_object = mysql_fetch_array($result_object, MYSQL_ASSOC);
	?>
	<tr class="gradeC">
		<TD><?=$query_object["object_IMEI"]?>&nbsp;</TD>
		<TD><?=$query_object["object_number"]?>&nbsp;</TD>
		<TD><?=$query_object["object_name"]?>&nbsp;</TD>
		<TD><?=$query_object["asset_name"]?>&nbsp;</TD>
		<TD><?=$query_object["categories_name"]?>&nbsp;</TD>
		<TD>
			 <?php
			// if($_SESSION["user_usergroup_id"]==1 || $_SESSION["user_usergroup_id"]==8 ){
			?>
			<a href="?Action_type=editobject&object_id=<?=$query_object["object_id"]?>"><img src="/gpsv3/images/icons/set.gif" border="0" alt="Edit"></a>
			<!--<a href="?deleteobject=1&object_id=<?=$query_object["object_id"]?>" onclick="return confirm('Do you want to delete the device?')"><img src="/gpsv3/images/icons/minus.gif" border="0" alt="Delete"></a>-->
			<?php
			// }
			?>
		</TD>
	</TR>
	<?php }?>
</TBODY>
</TABLE>
<TABLE border="0" cellpadding="0" cellspacing="0" width="100%"  style="margin-top:5px;font-size:12px;font-weight:bold;color:#969696;">
<form name="searchForm" method="post" action="?">
<TBODY>
<TR>
	<TD align="left">&nbsp;</TD>
	<TD align="right">
		<? if($_SESSION["user_usergroup_id"]==1 || $_SESSION["user_usergroup_id"]==8){?>
		<input type="button" class="loginsubmitlong" name="addobjectButton" value="Add Device" onclick="window.location='?Action_type=addNewobject'">
		<? }?>
	</TD>
</TR>
</TBODY>
</form>
</TABLE>
<?php }?>
<br>
<?php }else{?>
<h2>Sorry : You not have permission to access this section.</h2>
<h2>ขออภัย : คุณไม่ได้รับอนุญาตให้เข้าถึงเนื้อหาส่วนนี้</h2>
<?php }?>
