<?php include "includes/header.php" ?>
<?php include "includes/db.php" ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
<!-- Facebook Sharing button Script START -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '500717326766776',
            xfbml      : true,
            version    : 'v2.5'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
        <!-- Facebook Sharing button Code END -->
    <!-- Page Content -->
    <div class="container">

        
        
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
if(isset($_GET['p_id'])){
    $get_post_id = $_GET['p_id'];
}
    
    
$query = "SELECT * FROM posts WHERE post_id = {$get_post_id}";
$select_all_posts =       mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_all_posts)){
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
                        ?>
                
               
                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <!--  Facebook Like Button START  -->
                <div
                  class="fb-like"
                  data-share="true"
                  data-width="450"
                  data-show-faces="true">
                </div>
                <!--  Facebook Like Button END  -->
<?php
if(isset($_SESSION['user_role'])){
    echo " <a class='btn btn-primary' href='admin/posts.php?source=edit_post&p_id={$post_id}'> Edit Post <span class='glyphicon glyphicon-edit'></span></a> ";
    
}
?>
                <hr>
                                        
                  <?php  }  ?>
                  
                  
                <!-- Blog Comments -->

<?php
if(isset($_POST['create_comment'])){
    
    $get_post_id = $_GET['p_id'];
    $comment_user = $_POST['comment_user'];
    $comment_email = $_POST['comment_email'];
    $comment_content = $_POST['comment_content'];
    
    $query = "INSERT INTO comments (comment_post_id, comment_user, comment_email, comment_content, comment_status, comment_date) ";
    $query .= "VALUES ($get_post_id, '{$comment_user}', '{$comment_email}', '{$comment_content}', 'unapproved', now()) ";
    $create_comment_query = mysqli_query($connection, $query);
    if(!$create_comment_query){
        die("Query Failed !!  " . mysqli_error($connection));
    }
    //------------ Increasing [post_comment_count] field in the Posts table ------------//
    /*
    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
    $query .= "WHERE post_id = $get_post_id ";
    $update_comment_count = mysqli_query($connection, $query);
    if(!$create_comment_query){
        die("Query Failed !!  " . mysqli_error($connection));
    }
    */
}

?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                      
                       <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name" name="comment_user" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Your Email" name="comment_email" required>
                        </div>
                        <div class="form-group">
                            <textarea name="comment_content" required class="form-control" placeholder="type your comment here ..." rows="3"></textarea>
                        </div>
                        <button id="create_comment" type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                        
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
<?php
$query = "SELECT * FROM comments WHERE comment_post_id = {$get_post_id} ";
$query .= "AND comment_status = 'approved' ";
$query .= "ORDER BY comment_id DESC";
$select_comment_query = mysqli_query($connection, $query);
    if(!$select_comment_query){
        die("Query Failed !!  " . mysqli_error($connection));
    }
while($row = mysqli_fetch_array($select_comment_query)){
    $comment_date = $row['comment_date'];
    $comment_user = $row['comment_user'];
    $comment_content = $row['comment_content'];
?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_user; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
<?php } ?>
                  
                  </div>
                
        <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
<?php include "includes/footer.php" ?>