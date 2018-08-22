<?php
    
    require_once 'user.php';

    $uid ="";
    
   if(isset($_POST['uid'])){
        
        $uid = $_POST['uid'];
        
    }
    

    
    $userObject = new User();
    
    // Userprofile
    
    if(!empty($uid)){
        
        $json_registration = $userObject->getuserinformation($uid);
        echo json_encode($json_registration);
        
    }
    
    // Login
    
   /* if(!empty($username) && !empty($password) && empty($email)){
        
        $hashed_password = md5($password);
        
        $json_array = $userObject->loginUsers($username, $hashed_password);
        
        echo json_encode($json_array);
    }*/
    ?>