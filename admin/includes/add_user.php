<?php
if(isset($_POST['add_user'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_role = $_POST['user_role'];
    $user_first_name = $_POST['user_first_name'];
    $user_last_name = $_POST['user_last_name'];
    $user_email = $_POST['user_email'];
    // How To Upload Image to your Database
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    // Insert Image to Folder in your project
    move_uploaded_file($user_image_temp, "./images/$user_image");

    // Insert Data Function 
    $query = "INSERT INTO users (username, password, user_role, user_first_name, user_last_name, user_email, user_image) ";
    $query .= "VALUES ('{$username}','{$password}','{$user_role}','{$user_first_name}','{$user_last_name}','{$user_email}','{$user_image}') ";
    
    $add_user_query = mysqli_query($connection, $query);
    if(!$add_user_query){
        die("Add User Insert Query Failed!!  " . mysqli_error($connection));
    }
    header("Location: users.php");
}

?>

<form action="" method="post" enctype="multipart/form-data">
   
   <div class="form-group">
       <label for="username">User Name</label>
       <input type="text" class="form-control" name="username">
   </div>
   
   <div class="form-group">
       <label for="password">Password</label>
       <input type="password" class="form-control" name="password">
   </div>
   <div class="form-group">
       <label for="user_role">User Role</label>
       <select name="user_role" id="" class="form-control">
           <option value="admin">admin</option>
           <option value="writer">writer</option>
       </select>
    </div>
   <div class="form-group">
       <label for="user_first_name">First Name</label>
       <input type="text" class="form-control" name="user_first_name">
   </div>
   
   <div class="form-group">
       <label for="user_last_name">Last Name</label>
       <input type="text" class="form-control" name="user_last_name">
   </div>
 
   <div class="form-group">
       <label for="user_email">Email</label>
       <input type="email" class="form-control" name="user_email">
   </div>
   
   <div class="form-group">
       <label for="user_image">Image</label>
       <input type="file" name="user_image">      
   </div>
   
   <div class="form-group">
       <input type="submit" name="add_user" value="Add User" class="btn btn-primary">
    </div>
    
</form>