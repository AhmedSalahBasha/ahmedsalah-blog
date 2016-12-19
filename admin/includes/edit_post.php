<?php   
////////////////////   Fill The Update Form ///////////////////
if(isset($_GET['p_id'])){
    $get_post_id = $_GET['p_id'];
}
    $query = "SELECT * FROM posts WHERE post_id = {$get_post_id}";
    $select_posts_by_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_posts_by_id)){
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_status = $row['post_status'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
        $post_comments = $row['post_comment_count'];
        $post_cat_id = $row['post_cat_id'];
    }

//////////////// Update Function ////////////////////////
if(isset($_POST['update_post'])){
    if($_SESSION['user_role']=="admin" || $_SESSION['firstname'].' '.$_SESSION['lastname']==$post_author){
        $post_title = $_POST['title'];
        $post_author = $_POST['author'];
        $post_cat_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        move_uploaded_file($post_image_temp, "../images/$post_image");
        // Check if upload image button is empty!
        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id = {$get_post_id} ";
            $select_image = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($select_image)){
                $post_image = $row['post_image'];
            }
        }    
        $post_tags = $_POST['post_tags'];
        $unsecure_post_content = $_POST['post_content'];
        $post_content = mysqli_real_escape_string($connection, $unsecure_post_content);
        $post_date = date('d-m-y');
        $post_comment_count = 0;

        /////////////////////// Update Data Function  //////////////////////////
        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_cat_id = '{$post_cat_id}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_image = '{$post_image}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_date = now(), ";
        $query .= "post_comment_count = {$post_comment_count} ";
        $query .= "WHERE post_id = {$get_post_id} ";

        $update_post_query = mysqli_query($connection, $query);
        if(!$update_post_query){
            die("Query Failed!  " . mysqli_error($connection));
        }   
        header("Location: posts.php");
    }
}
?>
  <form action="" method="post" enctype="multipart/form-data">
   
   <div class="form-group">
       <label for="title">Post Title</label>
       <input value="<?php echo $post_title ?>" type="text" class="form-control" name="title" required>
   </div>
   
   <div class="form-group">
       <label for="post_category">Post Category</label>
           <select name="post_category" id="">
            <?php
                $cat_query = "SELECT * FROM categories WHERE cat_id = {$post_cat_id}";
                $select_cat_query = mysqli_query($connection, $cat_query);
                while($row = mysqli_fetch_assoc($select_cat_query)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_categories)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
                if(!$select_categories){
                  die("Query Failed !!  " . mysqli_error($connection));
                }
            ?>
            </select>                
   </div>
   
   <div class="form-group">
       <label for="post_author">Post Author</label>
       <input value="<?php echo $post_author ?>" type="text" class="form-control" name="author" required>
   </div>
   
   <div class="form-group">
     <label for="post_status">Post Status</label>
      <select name="post_status" id="">
          <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
          <?php
          if($post_status == 'published'){
              echo "<option value='draft'>draft</option>";
          }else{
              echo "<option value='published'>published</option>";
          }
          ?>
      </select>
   </div>
   
   <div class="form-group">
       <label for="post_image">Post Image</label> <br/>
       <img src="../images/<?php echo $post_image ?>" width="300" alt="">
       <input type="file" name="post_image">
   </div>
   
   <div class="form-group">
       <label for="post_tags">Post Tags</label>
       <input value="<?php echo $post_tags ?>" type="text" class="form-control" name="post_tags" required>
   </div>
   
   <div class="form-group">
       <label for="post_content">Post Content</label>
       <textarea required name="post_content" id="" cols="30" rows="10" class="form-control"><?php echo $post_content ?>"
       </textarea>
   </div>
   
   <div class="form-group">
       <input type="submit" name="update_post" value="Update Post" class="btn btn-primary">
    </div>
    

    
</form>