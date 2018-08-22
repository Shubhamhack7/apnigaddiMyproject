<?php
    
    require_once 'user.php';

    $name ="";
    
    $username = "";
    
    $password = "";
    
    $email = "";

    $phoneno ="";

    $adharno ="";
    
    if(isset($_POST['name'])){
        
        $name = $_POST['name'];
        
    }
    
    if(isset($_POST['username'])){
        
        $username = $_POST['username'];
        
    }

    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        
    }
    if(isset($_POST['gender'])){
        
        $gender = $_POST['gender'];
        
    }
    
    if(isset($_POST['email'])){
        
        $email = $_POST['email'];
        
    }

    if(isset($_POST['phoneno'])){
        
        $phoneno = $_POST['phoneno'];
        
    }

    if(isset($_POST['adharno'])){
        
        $adharno = $_POST['adharno'];
        
    }
    
    $userObject = new User();
    
    // Registration
    
    if(!empty($name) && !empty($username) && !empty($password)&& !empty($gender) && !empty($email) && !empty($phoneno) && !empty($adharno) ){
        
        $hashed_password = md5($password);
        
        $json_registration = $userObject->createNewRegisterUser($name,$username,$hashed_password,$gender,$email,$phoneno,$adharno);
        
        echo json_encode($json_registration);
        
    }
    
    // Login
    
   /* if(!empty($username) && !empty($password) && empty($email)){
        
        $hashed_password = md5($password);
        
        $json_array = $userObject->loginUsers($username, $hashed_password);
        
        echo json_encode($json_array);
    }*/
    ?>