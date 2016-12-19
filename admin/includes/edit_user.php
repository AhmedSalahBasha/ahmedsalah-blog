<?php   
////////////////////   Fill The Update Form ///////////////////
if(isset($_GET['p_id'])){
    $get_user_id = $_GET['p_id'];
}
    $query = "SELECT * FROM users WHERE user_id = {$get_user_id}";
    $select_user_by_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_user_by_id)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
        $user_first_name = $row['user_first_name'];
        $user_last_name = $row['user_last_name'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }

//////////////// Update Function ////////////////////////
if(isset($_POST['edit_user'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role']=='admin'){
            $user_id = $_POST['user_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user_first_name = $_POST['user_first_name'];
            $user_last_name = $_POST['user_last_name'];
            $user_email = $_POST['user_email'];
            $user_image = $_FILES['user_image']['name'];
            $user_image_temp = $_FILES['user_image']['tmp_name'];
            move_uploaded_file($user_image_temp, "./images/$user_image");
            // Check if upload image button is empty!
            if(empty($user_image)){
                $query = "SELECT * FROM users WHERE user_id = {$get_user_id} ";
                $select_image = mysqli_query($connection, $query);
                while($row = mysqli_fetch_array($select_image)){
                    $user_image = $row['user_image'];
                }
            }    

            /////////////////////// Update Data Function  //////////////////////////
            $query = "UPDATE users SET ";
            $query .= "username = '{$username}', ";
            $query .= "password = '{$password}', ";
            $query .= "user_first_name = '{$user_first_name}', ";
            $query .= "user_last_name = '{$user_last_name}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_image = '{$user_image}' ";
            $query .= "WHERE user_id = {$get_user_id} ";

            $update_user_query = mysqli_query($connection, $query);
            if(!$update_user_query){
                die("Update User Query Failed!  " . mysqli_error($connection));
            }   
            header("Location: users.php");
        }
    }
    
}
?>
 <form action="" method="post" enctype="multipart/form-data">
   
   <div class="form-group">
       <label for="username">User Name</label>
       <input value="<?php echo $username ?>" type="text" class="form-control" name="username" required>
   </div>
   
   <div class="form-group">
       <label for="password">Password</label>
       <input value="<?php echo $password ?>" type="password" class="form-control" name="password" required>
   </div>
   <!--<div class="form-group">
       <label for="user_role">User Role</label>
       <select name="user_role" id="" class="form-control">
           <option value="<?php //echo $user_role; ?>"><?php //echo $user_role; ?></option>
           <?php
            //if($user_role == 'admin'){
                //echo "<option value='writer'>writer</option>";
            //}else{
                //echo "<option value='admin'>admin</option>";
            //}
            ?>
       </select>
    </div>-->
   <div class="form-group">
       <label for="user_first_name">First Name</label>
       <input value="<?php echo $user_first_name ?>" type="text" class="form-control" name="user_first_name">
   </div>
   
   <div class="form-group">
       <label for="user_last_name">Last Name</label>
       <input value="<?php echo $user_last_name ?>" type="text" class="form-control" name="user_last_name">
   </div>
 
   <div class="form-group">
       <label for="user_email">Email</label>
       <input value="<?php echo $user_email ?>" type="email" class="form-control" name="user_email">
   </div>
   <div class="form-group">
       <label for="user_image">Image</label>
       <img src="./images/<?php echo $user_image ?>" width="300" alt="">
       <input type="file" name="user_image">    
   </div>
   
   <div class="form-group">
       <input type="submit" name="edit_user" value="Edit User" class="btn btn-primary">
    </div>
    
</form>