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
                            <small>Categories Administration</small>
                        </h1>
                        <div class="col-xs-6"> <!-- Add Category Form -->
                         <?php
                          insert_categories();
                              ?>
                           
                            <form action="#" method="post">
                             <div class="form-group">
                                <label for="cat-title">Category Title</label>
                                 <input class="form-control" type="text" name="cat_title" required>
                             </div>
                             <div class="form-group">
                                 <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                             </div>
                            </form>
<?php // Call Update Form
    if(isset($_GET['edit'])){
        $cat_id = $_GET['edit'];
        include "includes/update_category.php";
    }
                            
?>

    </div>

    <div class="col-xs-6">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Category Title</th>
            </tr>
        </thead>
        <tbody>
    <?php
    // Select All Categories
    selectAll_categories();
    ?>

    <?php
    //Delete Category
    delete_category();
    ?>
                            </tbody>
                        </table>

                        </div>
                        
                    </div>
                </div>
                <!-- /.row -->

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
