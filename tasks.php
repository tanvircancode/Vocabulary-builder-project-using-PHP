<?
include_once ('config.php');
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
    throw new Exception("Not connected<br>");
}
else{

$action = $_POST['action'];

if($action == "register"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($email && $password){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "insert into users(email,password) values ('$email','$password')" ;
        $res = mysqli_query($connection, $query);
        if(mysqli_error($connection)){
            // duplicate email entered
        }
        else{
            // created successfully
        }

    }
    else
    {
        // email or pass empty
    }
}
else if($action == "login"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($email && $password){
        // $password = password_hash($password,PASSWORD_BCRYPT);
        $query = "select id,password from words where email = '$email' " ;
        $res = mysqli_query($connection,$query);
        if(mysqli_num_rows($res) > 0){
            $data = mysqli_fetch_assoc($res);
            $pass = $data['password'];
            $id = $data['id'];
            if(password_verify($password,$pass)){
                $_SESSION['id'] = $data['id'];
                header('location:');
                return;
                // successfully login
            }
            else{
                // email and password not matched
            }
        }
        else{
            // no user registered with this email
        }
    }
    else{
        // email or pass empty
    }
}
}

?>