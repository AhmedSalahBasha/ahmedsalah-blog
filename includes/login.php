<?php include "db.php"; ?>
<?php session_start(); ?>
<?php
if(isset($_POST['login'])){
    $_SESSION['login_failed_message'] = null;
    
    $unsecure_username = $_POST['username'];
    $unsecure_password = $_POST['password'];
    $username = mysqli_real_escape_string($connection, $unsecure_username);
    $password = mysqli_real_escape_string($connection, $unsecure_password);
    
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_query = mysqli_query($connection, $query);
    if(!$select_query){
        die("Login Query Failed!!  " . mysqli_error($connection));
    }
}

while($row = mysqli_fetch_array($select_query)){
    $db_username = $row['username'];
    $db_password = $row['password'];
    $db_first_name = $row['user_first_name'];
    $db_last_name = $row['user_last_name'];
    $db_user_role = $row['user_role'];
}
if($username !== $db_username && $password !== $db_password){
    
    $_SESSION['login_failed_message'] = "Login Failed! The Authorization is denied.";
    header("Location: ../index.php");
}else if($username == $db_username && $password == $db_password){
    
    $_SESSION['username'] = $db_username;
    $_SESSION['firstname'] = $db_first_name;
    $_SESSION['lastname'] = $db_last_name;
    $_SESSION['user_role'] = $db_user_role;
    header("Location: ../admin");
}else{
    $_SESSION['login_failed_message'] = "Login Failed! The Authorization is denied.";
    header("Location: ../index.php");
}





?>