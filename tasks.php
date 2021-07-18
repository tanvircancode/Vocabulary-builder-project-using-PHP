<?php

if(!isset($_SESSION['id'])){
        session_start();
}

include_once 'config.php';
$statusCode = 0;
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
    throw new Exception("Not connected<br>");
}


$action = $_POST['action'] ?? '';

if($action == 'register'){

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if($email && $password){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "insert into users(email,password) values ('$email','$password')" ;
        $res = mysqli_query($connection, $query);
        if(mysqli_error($connection)){
            $statusCode = 1;
            // Duplicate email entered
        }
        else{
            $statusCode = 2;
            // Created successfully
        }
    }
    else
    {
        $statusCode = 3;
        // Email or password empty
    }
    header("location:index.php?status={$statusCode}");
}
else if($action == 'login'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if($email && $password){
        // $password = password_hash($password,PASSWORD_BCRYPT);
        $query = "select id,password from users where email = '{$email}' " ;
        $res = mysqli_query($connection,$query);
        if(mysqli_num_rows($res) > 0){
            $data = mysqli_fetch_assoc($res);
            $pass = $data['password'];
            $id = $data['id'];
            if(password_verify($password,$pass)){
                $_SESSION['id'] = $id;
                header('location:words.php');
                return;
                // successfully login
            }
            else{
                $statusCode = 4;
                // email and password not matched
            }
        }
        else{
            $statusCode = 5;
            // no user registered with this email
        }
    }
    else{
        $statusCode = 6;
        // Email or pass empty
    }
    header("location:index.php?status={$statusCode}");
}


?>
