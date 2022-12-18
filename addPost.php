<?php
include 'includes/header.php';
include 'db.php';

// display Errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $details = $_POST['details'];
    $categories = $_POST['categories'];

    $errorArray = [];
    $query = "";

    if (empty($title)) {
        $errorArray[] = "Title is required!";
    } else {
        $query .= "'$title'";
    }

    if (empty($details)) {
        $errorArray[] = "Details is required";
    } else {
        $query .= ",'$details'";
    }

    if (count($errorArray) == 0) {
        $sql = "INSERT INTO posts (title, details) VALUES ($query)";
        $result = mysqli_query($conn, $sql);
        $post_id = mysqli_insert_id($conn);

        if (isset($_POST['categories'])) {
            foreach ($categories as $category) {
                $sql = "INSERT INTO post_categories (post_id, category_id) VALUES ($post_id, $category)";
                $result = mysqli_query($conn, $sql);
            }
        }
        if ($result) {
            $msg = "Post Added Successfully";
        } else {
            $msg = "Error!!";
        }
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php
                    if (isset($errorArray) and count($errorArray)) {
                        foreach ($errorArray as $error) {

                    ?>
                            <div class="alert alert-danger">
                                <?= $error ?>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <?php
                    if (isset($msg)) {
                    ?>
                        <div class="alert alert-success">
                            <?= $msg ?>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Posts</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="title form-control">
                            </div>
                            <div class="form-group">
                                <label for="details">Details</label>
                                <input type="text" name="details" id="details" class="details form-control" />
                            </div>
                            <div class="form-group">
                                <label for="">Category</label>
                                <select name="categories[]" id="categories" class="category_id form-control" multiple>
                                    <option value="1">News</option>
                                    <option value="2">Technology</option>
                                    <option value="3">Educational</option>
                                    <option value="4">Sport</option>
                                </select>
                            </div>

                            <div class="card-footer">
                                <input type="submit" name="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>