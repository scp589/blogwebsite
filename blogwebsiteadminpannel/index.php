<?php
require "partials/db.php";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST['username'];
    $p = $_POST['password'];
    $sql = "SELECT * FROM `admin` WHERE `admin`.`adminname` = '$username'";
    $result = mysqli_query($connect, $sql);
    $num =  mysqli_num_rows($result);
    if($num ==1){
        $row = mysqli_fetch_assoc($result);
        if($row['password'] == $p){
            session_start();
            $_SESSION['logedin'] = true;
            $_SESSION['username'] = $username;
            header("location: main.php");
        }
        else{
            echo "wrong password";
        }
    }
    else{
        echo "wrong user name";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Blogwebsite admin</title>
</head>

<body>
    <div class="container">
        <h2 class="pt-5 pb-3">login to admin pannel of Blogwebsite</h2>
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Enter your name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="username" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Login</button>
        </form>
    </div>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
</html>