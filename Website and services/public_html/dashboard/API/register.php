<?php
include '../connection.php';
 function random_num($size) {
	$alpha_key = '';
	$keys = range('A', 'Z');

	for ($i = 0; $i < 2; $i++) {
		$alpha_key .= $keys[array_rand($keys)];
	}

	$length = $size - 2;

	$key = '';
	$keys = range(0, 9);

	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}

	return $alpha_key . $key;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
	
 $uid = random_num(9);
 $name = $_POST['fullname'];
 $username = $_POST['username'];
 $password = $_POST['password'];
 $email = $_POST['email'];
 $phone =$_POST['phone'];
 $ip = get_client_ip();
 $adhar = $_POST['adharno'];
 $very = 0;
 //photo = $_POST['photo'];
 
 $sql = "INSERT INTO user_data (UID,FULLNAME,USERNAME,PASSWORD,EMAIL,PHONENO,IPADDRESS,ADHAR_NO,USER_VERIFY) VALUES ('$uid','$name','$username','$password','$email','$phone','$ip','$adhar','$very')";
 
 if ($conn->query($sql) === TRUE){
 
 echo 'Data Inserted Successfully';
 
 }
 else{
 
 echo 'Try Again';
 
 }
 mysqli_close($conn);
?>