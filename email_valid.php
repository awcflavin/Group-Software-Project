<?php
    $valid_email=false;
    $regex="/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
    $email="117101156@umail.ucc.ie";
    if(preg_match($regex, $email)) { 
        $valid_email=true;
    } 
    $uni_email="";
    if ($valid_email){
    $uni_regex="/@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/m";
    preg_match($uni_regex, $email, $matches);

    $uni_email=$matches[0];
    }
    echo $uni_email;
?>