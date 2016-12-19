                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Role</th>
                                    <th>Change Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
    <?php   //////////////// Select All Posts ////////////////
    $query = "SELECT * FROM users";
    $select_users = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_users)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_first_name = $row['user_first_name'];
        $user_last_name = $row['user_last_name'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        
        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$username}</td>";
        echo "<td>{$user_first_name}</td>";
        echo "<td>{$user_last_name}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td><img class='img-responsive' width='70' src='./images/{$user_image}'></td>";
        echo "<td>{$user_role}</td>";
        echo "<td>
            <a href='users.php?admin={$user_id}'>Admin</a><br>
            <a href='users.php?writer={$user_id}'>Writer</a>
            </td>";
        echo "<td>
            <a href='users.php?source=edit_user&p_id={$user_id}'>Edit</a><br>
            <a href='users.php?delete={$user_id}'>Delete</a>
            </td>";
        echo "</tr>";      
    }

    ?>
                                
                            </tbody>
                        </table>
                        
<?php
//----------------- Change to Admin -----------------//
if(isset($_GET['admin'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role']=='admin'){
            $get_user_id = $_GET['admin'];
            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$get_user_id} ";
            $change_admin_query = mysqli_query($connection, $query);    
            if(!$change_admin_query){
                die("Query Failed !!  " . mysqli_error($connection));
            }
            header("Location: users.php");
        }
    }
}
//---------------- Change to Writer ---------------//
if(isset($_GET['writer'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role']=='admin'){
            $get_user_id = $_GET['writer'];
            $query = "UPDATE users SET user_role = 'writer' WHERE user_id = {$get_user_id} ";
            $change_sub_query = mysqli_query($connection, $query);    
            if(!$change_sub_query){
                die("Query Failed !!  " . mysqli_error($connection));
            }
            header("Location: users.php");
        }
    }
}
//----------------- DELETE Function -------------------//
if(isset($_GET['delete'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role']=='admin'){
            $the_user_id = $_GET['delete'];
            $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
            $delete_query = mysqli_query($connection, $query);    
            if(!$delete_query){
                die("Query Failed !!  " . mysqli_error($connection));
            }
            header("Location: users.php");
        }
        
    }
    
}

?>