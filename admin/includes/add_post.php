<?php
if(isset($_POST['create_post'])){
    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_cat_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];

    // How To Upload Image to your Database
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    // Insert Image to Folder in your project
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    $post_tags = $_POST['post_tags'];
    $unsecure_post_content = $_POST['post_content'];
    $post_content = mysqli_real_escape_string($connection, $unsecure_post_content);
    $post_date = date('d-m-y');
    $post_comment_count = 0;

    // Insert Data Function 
    $query = "INSERT INTO posts (post_cat_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
    $query .= "VALUES ({$post_cat_id},'{$post_title}','{$post_author}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_comment_count}','{$post_status}') ";
    
    $create_post_query = mysqli_query($connection, $query);
    if(!$create_post_query){
        die("Insert Query Failed!  " . mysqli_error($connection));
    }
    header("Location: posts.php");
}

?>

<form action="" method="post" enctype="multipart/form-data">
   
   <div class="form-group">
       <label for="title">Post Title</label>
       <input type="text" class="form-control" name="title" required>
   </div>
   
   <div class="form-group">
       <label for="post_category">Post Category</label>
           <select name="post_category" id="">
            <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_categories)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='$cat_id'>{$cat_title}</option>";
                }
                if(!$select_categories){
                  die("Query Failed !!  " . mysqli_error($connection));
                }
            ?>
            </select>                
   </div>
   
   <div class="form-group">
       <label for="post_author">Post Author</label>
       <input value="<?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?>" type="text" class="form-control" name="author" readonly>
   </div>
   
   <div class="form-group">
     <label for="post_status">Post Status</label>
      <select name="post_status" id="">
          <option value="published">published</option>
          <option value="draft">draft</option>
      </select>
   </div>
   
   <div class="form-group">
       <label for="post_image">Post Image</label>
       <input type="file" name="post_image">
   </div>
   
   <div class="form-group">
       <label for="post_tags">Post Tags</label>
       <input type="text" class="form-control" name="post_tags" required>
   </div>
   
   <div class="form-group">
       <label for="post_content">Post Content</label>
       <textarea name="post_content" id="" cols="30" rows="10" class="form-control" required>
       </textarea>
   </div>
   
   <div class="form-group">
       <input type="submit" name="create_post" value="Publish Post" class="btn btn-primary">
    </div>
    

    
</form>