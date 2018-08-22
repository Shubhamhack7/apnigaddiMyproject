<?php
    
    require_once 'user.php';

    $uid ="";
    
    $current_lati = "";
    
    $current_long = "";
    
    $destination_lati = "";

    $destination_long ="";

    $date ="";
    $time ="";
    
    if(isset($_POST['uid'])){
        
        $uid = $_POST['uid'];
        
    }
    
    if(isset($_POST['current_lati'])){
        
        $current_lati = $_POST['current_lati'];
        
    }

    if(isset($_POST['current_long'])){
        
        $current_long = $_POST['current_long'];
        
    }
    if(isset($_POST['destination_lati'])){
        
        $destination_lati = $_POST['destination_lati'];
        
    }
    
    if(isset($_POST['destination_long'])){
        
        $destination_long = $_POST['destination_long'];
        
    }

    if(isset($_POST['date'])){
        
        $date = $_POST['date'];
        
    }

    if(isset($_POST['time'])){
        
        $time = $_POST['time'];
        
    }
    
    $userObject = new User();
    
    // Registration
    
    if(!empty($uid) && !empty($current_long) && !empty($current_long)&& !empty($destination_lati) && !empty($destination_long) && !empty($date) && !empty($time) ){
        
        $rider_info = $userObject->RiderInformation($uid,$current_lati,$current_long,$destination_lati,$destination_long,$date,$time);
        
        echo json_encode($rider_info);
        
    }
    ?>