<?php
include_once 'db-conect.php';

    class User{
        
        private $db;
        
        private $db_table = "user_data";
        
        public function __construct(){
            $this->db = new DbConnect();
        }

        public function isConferm($uid,$email,$token){
            
            $i=1;
            $p="";
            $query = "SELECT * FROM ".$this->db_table." WHERE UID = '$uid' AND EMAIL = '$email' AND TOKEN = '$token' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                $query1 = "UPDATE ".$this->db_table." SET EMAIL_VERIFY ='$i' ,TOKEN = '$p' WHERE UID='$uid' AND EMAIL='$email' AND TOKEN='$token'";
    			mysqli_query($this->db->getDb(), $query1);
                mysqli_close($this->db->getDb());	
                return true;
            }
            else
            {
            	return false;
            }
        }
         public function isverifyotp($otp){
            
            $i=1;
            $p="";
            $query = "SELECT * FROM ".$this->db_table." WHERE OTP = '$otp' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                $query1 = "UPDATE ".$this->db_table." SET PHONE_VERIFY ='$i' ,OTP = '$p' WHERE OTP='$otp'";
    			mysqli_query($this->db->getDb(), $query1);
                mysqli_close($this->db->getDb());
                $json['sucess'] = "1";
                $json['message'] = "Phone number verified sucessfully";
                return $json;
            }
            else
            {
            	$json['sucess'] = "0";
                $json['message'] = "Please recheck th OTP or OTP is expired";
            	return $json;
            }
        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
    	$u = $_GET['uid'];
    	$e = $_GET['email'];
    	$t = $_GET['token'];
    	$i = 1;
    	$p = "";


    $user_confirm = new User();
    $check=$user_confirm->isConferm($u,$e,$t);


    if($check)
   {

    	echo "Your email is sucessfully verified Back to Login..Thank you";
    	
    }
    else
    {
    	echo "Your email is not verified please recheck the link or link exipred Thank you";
    }
}
   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
   		$o = $_POST['otp'];
   		$user_confirm = new User();
    	$check=$user_confirm->isverifyotp($o);
    	echo json_encode($check);
   }
?>