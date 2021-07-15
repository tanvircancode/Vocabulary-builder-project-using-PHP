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
}