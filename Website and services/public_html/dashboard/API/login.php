<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){

 include '../connection.php';

 $email = $_POST['email'];
 $password = $_POST['password'];
 
 $Sql_Query = "SELECT * FROM user_data WHERE EMAIL = '$email' AND PASSWORD = '$password' ";
 
 $check = mysqli_fetch_array(mysqli_query($conn,$Sql_Query));
 
 if(isset($check)){
 	
 	
 	$json['SUCCESS'] = "1";
 	$json['ID'] = $check['ID'];
 	$json['UID'] = $check['UID'];
 	$json['FULLNAME'] = $check['FULLNAME'];
 	$json['USERNAME'] = $check['USERNAME'];
 	$json['EMAIL'] = $check['EMAIL'];
 	$json['EMAIL_VERIFY'] = $check['EMAIL_VERIFY'];
 	$json['PHONENO'] = $check['PHONENO'];
 	$json['PHONE_VERIFY'] = $check['PHONE_VERIFY'];
 	$json['IPADDRESS'] = $check['IPADDRESS'];
 	$json['ADHAR_NO'] = $check['ADHAR_NO'];
 	$json['HELMET'] = $check['HELMET'];
 	echo json_encode($json);
 
 }
 else{
 	$json['UNSUCCESS'] = "0";
	echo json_encode($json);
 }
 
 }else{
 echo "Check Again";
 }
mysqli_close($conn);
?>