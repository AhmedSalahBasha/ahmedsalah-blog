<?php include "includes/admin_header.php"  ?>
   
    <div id="wrapper">

        <!-- Navigation -->
<?php include "includes/admin_navigation.php"  ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome To Admin Panel
                            <small>Mr/ <?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?></small>
                        </h1>
                    </div>
                </div>
                
                <!-- /.row -->
                
                <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <?php  //  SELECT THE NUMBERS OF POSTS FROM DATABASE
                                    $query = "SELECT * FROM posts";
                                    $select_allposts = mysqli_query($connection, $query);
                                    $posts_counter = mysqli_num_rows($select_allposts);
                                    echo "<div class='huge'>{$posts_counter}</div>";
                                    ?>
                                    
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php  //  SELECT THE NUMBERS OF COMMENTS FROM DATABASE
                                    $query = "SELECT * FROM comments";
                                    $select_allcomments = mysqli_query($connection, $query);
                                    $comments_counter = mysqli_num_rows($select_allcomments);
                                    echo "<div class='huge'>{$comments_counter}</div>";
                                    ?>
                                    
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>  
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php  //  SELECT THE NUMBERS OF USERS FROM DATABASE
                                    $query = "SELECT * FROM users";
                                    $select_allusers= mysqli_query($connection, $query);
                                    $users_counter = mysqli_num_rows($select_allusers);
                                    echo "<div class='huge'>{$users_counter}</div>";
                                    ?>
                                    
                                    <div>Users</div>
                                </div>
                            </div>
                        </div>
                        <a <?php if($_SESSION['user_role']=="admin"){ echo "href='users.php'"; } ?> >
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-th-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php  //  SELECT THE NUMBERS OF CATEGORIES FROM DATABASE
                                    $query = "SELECT * FROM categories";
                                    $select_allcategories = mysqli_query($connection, $query);
                                    $categories_counter = mysqli_num_rows($select_allcategories);
                                    echo "<div class='huge'>{$categories_counter}</div>";
                                    ?>
                                    
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a <?php if($_SESSION['user_role']=="admin"){ echo "href='categories.php'"; } ?>  >
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
        <!-- /.row -->
<?php  
//  SELECT THE PUBLISHED POSTS FROM DATABASE
$query = "SELECT * FROM posts WHERE post_status = 'published'";
$select_all_publishedposts = mysqli_query($connection, $query);
$published_posts_counter = mysqli_num_rows($select_all_publishedposts);
//  SELECT THE DRAFT POSTS FROM DATABASE
$query = "SELECT * FROM posts WHERE post_status = 'draft'";
$select_all_draftposts = mysqli_query($connection, $query);
$draft_posts_counter = mysqli_num_rows($select_all_draftposts);

//  SELECT THE UNAPPROVED COMMENTS FROM DATABASE
$query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
$unapproved_comments_query = mysqli_query($connection, $query);
$unapproved_counter = mysqli_num_rows($unapproved_comments_query);

//  SELECT THE WRITERS USERS FROM DATABASE
$query = "SELECT * FROM users WHERE user_role = 'writer'";
$select_all_writer = mysqli_query($connection, $query);
$writer_counter = mysqli_num_rows($select_all_writer);
// TWO ARRAYS FOR PRESENT COUNTS
$element_text = ['Active Posts','Draft Posts','Comments','Pending Comments','Users','Writers','Categories'];
$element_count = [$posts_counter,$draft_posts_counter,$comments_counter,$unapproved_counter,$users_counter,$writer_counter,$categories_counter];
?>
<div class="row">

<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawStuff);

  function drawStuff() {
    var data = new google.visualization.arrayToDataTable([

      ['Data', 'Count'],
      <?php echo "['All Posts', {$posts_counter}],"; ?>
      <?php echo "['Published Posts', {$published_posts_counter}],"; ?>
      <?php echo "['Draft Posts', {$draft_posts_counter}],"; ?>
      <?php echo "['Comments', {$comments_counter}],"; ?>
      <?php echo "['Pending Comments', {$unapproved_counter}],"; ?>
      <?php echo "['Users', {$users_counter}],"; ?>
      <?php echo "['Writers', {$writer_counter}],"; ?>
      <?php echo "['Categories', {$categories_counter}],"; ?>
    ]);

    var options = {
      title: 'Front-end Performance',
      width: 900,
      legend: { position: 'none' },
      chart: { subtitle: 'all tables are presented' },
      axes: {
        x: {
          0: { side: 'top', label: ''} // Top x-axis.
        }
      },
      bar: { groupWidth: "90%" }
    };

    var chart = new google.charts.Bar(document.getElementById('top_x_div'));
    // Convert the Classic options to Material options.
    chart.draw(data, google.charts.Bar.convertOptions(options));
  };
</script>
   <div id="top_x_div" style="width: 900px; height: 500px;"></div>

</div>
                </div>
                

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
