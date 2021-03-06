                           <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                <?php if(!isset($_SESSION['username'])){ ?>
   
                <!-- Login Form -->
                <div class="well">
                    <h4>Login</h4>
                    <form action="includes/login.php" method="post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Enter Username" required>
                    </div>
                    <div class="input-group">
                      <input name="password" type="password" class="form-control" placeholder="Enter Password" required>
                       <span class="input-group-btn">     
                        <button class="btn btn-primary" type="submit" name="login">Login</button>
                        </span>
                    </div>
                    
                    <?php // Print Login Message
                        if(isset($_SESSION['login_failed_message'])){
                            $message = $_SESSION['login_failed_message'];
                            echo "<br><div class='form-group'><span style='color:red'><b>{$message}</b></span></div>";
                        }
                    ?>
                    
                    </form>
                    <!-- /.input-group -->
                </div>
                <?php  } ?>
               
                <!-- Blog Categories Well -->
                <div class="well">
                   
                   <?php 
$query = "SELECT * FROM categories";
$select_cat_sidebar = mysqli_query($connection, $query);
                    ?>
                    
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                               <?php
while($row = mysqli_fetch_assoc($select_cat_sidebar)){
    $cat_title = $row['cat_title'];
    $cat_id = $row['cat_id'];
    echo "<li> <a href='category.php?category=$cat_id'>{$cat_title}</a> </li>";
}
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php"  ?>

            </div>