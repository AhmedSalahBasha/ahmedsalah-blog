<?php
if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){
        $bulk_options = $_POST['bulkOptions'];
        switch($bulk_options){
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' ";
                $query .= "WHERE post_id = {$postValueId} ";
                $update_published_status = mysqli_query($connection, $query);
                if(!$update_published_status){
                    die("Update Query Failed!  " . mysqli_error($connection));
                }
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' ";
                $query .= "WHERE post_id = {$postValueId} ";
                $update_draft_status = mysqli_query($connection, $query);
                if(!$update_draft_status){
                    die("Update Query Failed!  " . mysqli_error($connection));
                }
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                $delete_post = mysqli_query($connection, $query);
                if(!$delete_post){
                    die("Update Query Failed!  " . mysqli_error($connection));
                }
                break;
        }
    }
}
?>
  <form action="" method="post">
   <table class="table table-bordered table-hover">
   <div id="bulkOptionContainer" class="col-xs-4" style="padding:0px;">
       <select class="form-control" name="bulkOptions" id="">
           <option value="">Select Options</option>
           <option value="published">Publish</option>
           <option value="draft">Draft</option>
           <?php if($_SESSION['user_role']=="admin"){ ?> <option value="delete">Delete</option> <?php } ?>
       </select>
   </div>
   <div class="col-xs-4">
       <input type="submit" name="submit" value="Apply" class="btn btn-success">
       <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
   </div>
    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date</th>
            <th>Image</th>
            <th>Status</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
                                
    <?php   //////////////// Select All Posts ////////////////
    $query = "SELECT * FROM posts";
    $select_posts = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_status = $row['post_status'];
        $post_tags = $row['post_tags'];
        $post_comments = $row['post_comment_count'];
        $post_category = $row['post_cat_id'];
        
        echo "<tr>";
        ?>
        <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
        <?php
        echo "<td>{$post_id}</td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
        echo "<td>{$post_author}</td>";
        echo "<td>{$post_date}</td>";
        echo "<td><img class='img-responsive' width='100' src='../images/{$post_image}'></td>";
        echo "<td>{$post_status}</td>";
        echo "<td>{$post_tags}</td>";
        // Increasing Comments Counter for each post
        $count_query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
        $send_comment_query = mysqli_query($connection, $count_query);
        $comments_counter = mysqli_num_rows($send_comment_query);
        echo "<td>{$comments_counter}</td>";
        
        // Print the Category Name in the Table // 
        $query = "SELECT * FROM categories WHERE cat_id = {$post_category} ";
        $select_cat_id = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_cat_id)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            echo "<td>{$cat_title}</td>";
        }
        if(!$select_cat_id){
            die("Query Failed !  " . mysqli_error($connection));
        }
        if($_SESSION['user_role']=="admin" || $_SESSION['firstname'].' '.$_SESSION['lastname']==$post_author){
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";}
        
        if($_SESSION['user_role']=="admin"){
            echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
        }
        echo "</tr>";      
    }

    ?>
                                
        </tbody>
    </table>
</form>
                        
<?php
if(isset($_GET['delete'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role']=='admin'){
            $the_post_id = $_GET['delete'];
            $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
            $delete_query = mysqli_query($connection, $query);    
            if(!$delete_query){
                die("Query Failed !!  " . mysqli_error($connection));
            }
            header("Location: posts.php");
        }
    }
}

?>