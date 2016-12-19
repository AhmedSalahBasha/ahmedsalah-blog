<?php

function insert_categories(){
    global $connection;
    if(isset($_POST['submit'])){
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role']=='admin'){
                $cat_title = $_POST['cat_title'];
                $query = "INSERT INTO categories (cat_title) VALUES ('{$cat_title}') ";
                $create_category_query = mysqli_query($connection, $query);
                if(!$create_category_query){
                    die("Query Failed!  " . mysqli_error($connection));
                }
            }
        }
    }                            
}

function selectAll_categories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_cat = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_cat)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function delete_category(){
    global $connection;
    if(isset($_GET['delete'])){
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role']=='admin'){
                $delete_cat_id = $_GET['delete'];
                $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id} ";
                $delete_query = mysqli_query($connection, $query);
                if(!$delete_query){
                    die("Query Failed!  " . mysqli_error($connection));
                }
                header("Location: categories.php");
            }
        }
    }
}







?>