<?php
    
    include_once 'db-conect.php';
    include 'way2sms-api.php';

    class User{
        
        private $db;
        
        private $db_table = "user_data";
        private $db_rider = "rider";
        private $API = "87561a7b-92e7-11e8-a895-0200cd936042";
        
        public function __construct(){
            $this->db = new DbConnect();
        }
        
        public function isLoginExist($email, $password){
            
            $query = "SELECT * FROM ".$this->db_table." WHERE EMAIL = '$email' AND PASSWORD = '$password' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                $row = $result->fetch_assoc();
                return $row;
                
            }
            
            mysqli_close($this->db->getDb());
            
            return false;
            
        }

        public function imageuploading($uid,$file_path,$file_url,$filetempname)
        {
            move_uploaded_file($filetempname,$file_path);
            $sql = "UPDATE". $this->db_table."SET PHOTO ='$file_url' WHERE UID='$uid'";
            $inserted = mysqli_query($this->db->getDb(), $sql);
            if($inserted)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getuserprofiledata($uid){
            
            $query = "SELECT * FROM ".$this->db_table." WHERE UID = '$uid'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                $row = $result->fetch_assoc();
                return $row;
                
            }
            
            mysqli_close($this->db->getDb());
            
            return false;
            
        }
        
        public function isEmailExist($email){
            
            $query = "SELECT * FROM ".$this->db_table." WHERE EMAIL = '$email'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                return true;
                
            }
               
            return false;
            
        }

        public function isUIDExist($uid){
            
            $query = "SELECT * FROM ".$this->db_table." WHERE UID = '$uid'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                return true;
                
            }
               
            return false;
            
        }
        
        public function isValidEmail($email){
             return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
        
        public function random_num($size) 
        {
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
            $id = $alpha_key . $key;
            if($this->isUIDExist($id))
            {
                $this->random_num(9);
            }
            else
            {
            return $id;
            }
        }
        
        public function get_client_ip() 
        {
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

        public function confirmationmailsend($name,$email)
        {

            $query = "SELECT * FROM ".$this->db_table." WHERE EMAIL = '$email' AND FULLNAME ='$name' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                $row = $result->fetch_assoc();   
            }
            $to = $email;
            $email_subject = "Please Confirm your email id";
            $email_body = "Dear ".$name."\n\n"."Please confirm your email by click ing below link \n\nhttp://myideawork.000webhostapp.com/API/confirm.php?uid=".$row['UID']."&email=".$email."&token=".$row['TOKEN']."\n\n
            Thanking you\n\n
            With Regards\n\n
            My Idea work";
            $headers = "no reply";
            if(mail($to,$email_subject,$email_body,$headers))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    public function GEN_token()
    {
        $str = "QWERTYUIOPMNBVCXZASDFGHJKLqwertyuiopmnbvcxzasdfghjkl0123456789!@#$%-";
        $str = str_shuffle($str);
        $str = substr($str,25,-25);
        return $str;
    }

        public function sendOTPtonumber($phone,$otp)
        {
            $username ="9621019232";
            $password ="nikerisk";
            $message ="Your OTP is \n : ".$otp;
            $client = new WAY2SMSClient();
            $client->login($username, $password);
            $result=$client->send($phone,$message);
            if($result)
            {
                return true;
            }
            else{
                    return false;
            }          
            /*$message="HELLO";
            $json = json_decode(file_get_contents("https://smsapi.engineeringtgr.com/send/?Mobile=9621019232&Password=nikerisk&Message=".urlencode($message)."&To=".urlencode($phone)."&Key=shubhZCDQLlY7eK1z0PXw4NvxRtG") ,true);
            if ($json["status"]==="success") {
            echo $json["msg"];
            //your code when send success
            }else{
            echo $json["msg"];
            //your code when not send
            }*/
        }

        public function sendotpandthirdparty($number,$otp)
        {
            
            $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://2factor.in/API/V1/".$this->$API."/SMS/".$number."/AUTOGEN/".$otp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }

        public function createNewRegisterUser($name,$username,$hashed_password,$gender,$email,$phoneno,$adharno){

            $uid = $this->random_num(9);
            $ip = $this->get_client_ip();
            $token =$this->GEN_token();
            $otp = rand(100000,999999);  
            $isExisting = $this->isEmailExist($email);
            
            if($isExisting){
                
                $json['success'] = 0;
                $json['message'] = "Error in registering. Probably the username/email already exists";
            }
            
            else{
                
            $isValid = $this->isValidEmail($email);
                
                if($isValid)
                {

                $query = "INSERT INTO ".$this->db_table." (UID, FULLNAME, USERNAME, PASSWORD,GENDER, EMAIL,TOKEN,PHONENO,OTP,IPADDRESS,ADHAR_NO) values ('$uid', '$name', '$username', '$hashed_password', '$gender', '$email', '$token','$phoneno','$otp','$ip','$adharno')";
                
                $inserted = mysqli_query($this->db->getDb(), $query);
                
                if($inserted == 1){
                    
                    $json['success'] = 1;
                    $json['message'] = "Successfully registered the user";
                    $this->confirmationmailsend($name,$email);
                    //$this->sendOTPtonumber($phoneno,$otp);
                    $this->sendotpandthirdparty($phoneno,$otp)
                    
                }else{
                    
                    $json['success'] = 0;
                    $json['message'] = "Error in registering. Probably the username/email already exists";
                    
                }
                
                mysqli_close($this->db->getDb());
                }
                else{
                    $json['success'] = 0;
                    $json['message'] = "Error in registering. Email Address is not valid";
                }
                
            }
            
            return $json;
            
        }

        public function setImageUpload($uid,$file_path,$file_url,$filetempname)
        {
            $json = array();

            $imageupload= $this->imageuploading($uid,$file_path,$file_url,$filetempname);
            if($imageupload){
                
                $json['success'] = 1;
                $json['message'] = "Image Uploaded Successfully";
                
            }else{
                $json['success'] = 0;
                $json['message'] = "Image not Uploaded";
            }
            return $json;

        }
        
        public function getuserinformation($uid){
            
            $json = array();
            
            $canUserLogin = $this->getuserprofiledata($uid);
            if($canUserLogin){
                
                $json['success'] = 1;
                $json['UID'] = $canUserLogin['UID'];
                $json['FULLNAME'] = $canUserLogin['FULLNAME'];
                $json['EMAIL'] = $canUserLogin['EMAIL'];
                $json['GENDER'] = $canUserLogin['GENDER'];
                $json['PHOTO'] = $canUserLogin['PHOTO'];
                $json['USER_VERIFY'] = $canUserLogin['USER_VERIFY'];
                $json['message'] = "valid Uid";
                
            }else{
                $json['success'] = 0;
                $json['message'] = "Incorrect details";
            }
            return $json;
        }

        public function loginUsers($email, $password){
            
            $json = array();
            
            $canUserLogin = $this->isLoginExist($email, $password);
            if($canUserLogin){
                
                $json['success'] = 1;
                $json['UID'] = $canUserLogin['UID'];
                $json['EMAIL'] = $canUserLogin['EMAIL'];
                $json['EMAIL_VERIFY'] = $canUserLogin['EMAIL_VERIFY'];
                $json['message'] = "Successfully logged in";
                
            }else{
                $json['success'] = 0;
                $json['message'] = "Incorrect details";
            }
            return $json;
        }


        public function RiderInformation($uid,$current_lati,$current_long,$destination_lati,$destination_long,$date,$time){
                
                $query = "INSERT INTO ".$this->db_rider." (UID, CURRENT_LATI, CURRENT_LONG, DESTINATION_LATI,DESTINATION_LONG, DATE,TIME) values ('$uid', '$current_lati', '$current_long', '$destination_lati', '$destination_long', '$date','$time')";
                
                $inserted = mysqli_query($this->db->getDb(), $query);
                
                if($inserted == 1){
                    
                    $json['success'] = 1;
                    $json['message'] = "Successfully registered the user";
                    
                }else{
                    
                    $json['success'] = 0;
                    $json['message'] = "Error in submitting values";
                    
                }
                
                mysqli_close($this->db->getDb());
                
            
            return $json;
            
        }

        
    }


   /* $userdata =new User();
    $userdata->sendOTPtonumber("9621019232");
    if($check)
    {
        var_dump($check);
    }
    else
    {
        echo "failed";
    }*/

    ?>