<?php

function getStatusCode($status){
    if($status==1)
    {
        return "Duplicate email entered";
    }
    else if($status==2){
        return "Created successfully";
    }
    else if($status==3){
        return "Email or password empty";
    }
    else if($status==4){
        return "Email and password not matched";
    }
    else if($status==5){
        return "No user registered with this email";
    }
    else if($status==6){
        return "Email or pass empty";
    }
}