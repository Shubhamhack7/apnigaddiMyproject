<?php
    
    require_once 'user.php';
  
    $password = "";
    
    $email = "";
    
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        
    }
    
    if(isset($_POST['email'])){
        
        $email = $_POST['email'];
        
    }

    
    $userObject = new User();
    
    // Registration
    
   /* if(!empty($name) && !empty($username) && !empty($password) && !empty($email) && !empty($phoneno) && !empty($adharno) ){
        
        $hashed_password = md5($password);
        
        $json_registration = $userObject->createNewRegisterUser($name,$username,$hashed_password,$email,$phoneno,$adharno);
        
        echo json_encode($json_registration);
        
    }*/
    
    // Login
    
   if(!empty($password) && !empty($email)){
        
        $hashed_password = md5($password);
        
        $json_array = $userObject->loginUsers($email, $hashed_password);
        //var_dump($json_array);
        echo json_encode($json_array);
    }
    ?>