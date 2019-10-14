<?php

include('functions.php');

// Initialize field value variables
$blog_title = '';
$blog_text = '';
$blog_category = array();
$status = 'Choose';


$title_error = $text_error = $category_error = $status_error = '';

$error_count = 0;
$success = false;

if (isset($_POST['submit'])) {
    $blog_title = $_POST['blog_title'];
    $blog_text = $_POST['blog_text'];
    $blog_category = $_POST['blog_category'];
    $status = $_POST['status'];
    if (isset($_POST['blog_category'])) {
        $blog_category = $_POST['blog_category'];
    } else {
        $blog_category = array();
    }

    // validation
    $title_max_length = 35;
    if (empty($_POST['blog_title'])) {
        $title_error = 'The blog post cannot be empty';
        $error_count++;
    } else if (strlen($_POST['blog_title']) < 3) {
        $title_error = 'The title is too short';
        $error_count++;
    } else if (strlen($_POST['blog_title']) > $title_max_length) {
        $characters_over_limit = strlen($_POST['']) - $title_max_length;
        $title_error = "The title is $characters_over_limit characters too long.";
        $error_count++;
    }

    if (empty($_POST['blog_text'])) {
        $text_error = 'The textbox cannot be empty';
        $error_count++;
    }

    if (!isset($_POST['blog_category'])) {
        $category_error = 'Pick at least one category';
        $error_count++;
    }

    if ($error_count === 0) {
        $blog_title = $blog_text = '';
        $blog_category = array();


        $blogs_str_in = @file_get_contents('blogs.json');
        if (!$blogs_str_in) {
            $blogs = [];
        } else {
            $blogs = json_decode($blogs_str_in, true);
        }
        array_push($blogs, $_POST);

        $blogs_str_out = json_encode($blogs, true);

        file_put_contents('blogs.json', $blogs_str_out);
        $success = true;
    }
}

$page_title = 'Create a blog post';
$page_id = 'bloggy_blog/create_blog';
include('header.php');
?>

<div class=" col col-md-8 mx-auto">
    <h1 class="mb-5 text-center">Create a Blog Post</h1>

    <?php if ($success) : ?>
        <div class="alert alert-success mt-2">Nice! The Blog is now Published!</div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo uniqid(); ?>">

        <div class="form-group mb-4">
            <label>Title</label>
            <input type="text" name="blog_title" class="form-control" value="<?php echo $blog_title; ?>">
            <?php if (!empty($title_error)) : ?>
                <div class="alert alert-danger mt-2"><?php echo $title_error; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group mb-4">
            <label>Blog text</label>
            <textarea name="blog_text" class="form-control"><?php echo $blog_text; ?></textarea>
            <?php if (!empty($text_error)) : ?>
                <div class="alert alert-danger mt-2"><?php echo $text_error; ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group mb-4">
            <label>Blog status</label>
            <select name="status">
                <option value="Draft">Draft</option>
                <option value="Published">Published</option>
            </select>
        </div>
        <?php
        if(isset($_POST['submit'])){
        $selected_val = $_POST['status'];
        ?>

        <div class="form-group mb-4">
            <label>Category</label>
            <div class="form-check">
                <input type="checkbox" name="blog_category" value="Politics" class="form-check-input" <?php get_checked('Politics'); ?>> Politics <br>
                <input type="checkbox" name="blog_category" value="Culture" class="form-check-input" <?php get_checked('Culture'); ?>> Culture <br>
                <input type="checkbox" name="blog_category" value="Food" class="form-check-input" <?php get_checked('Food'); ?>> Food <br>
                <input type="checkbox" name="blog_category" value="News" class="form-check-input" <?php get_checked('News'); ?>> News <br>
                <input type="checkbox" name="blog_category" value="Family" class="form-check-input" <?php get_checked('Family'); ?>> Family <br>
                <input type="checkbox" name="blog_category" value="Science" class="form-check-input" <?php get_checked('Science'); ?>> Science <br>
                <input type="checkbox" name="blog_category" value="Lifestyle" class="form-check-input" <?php get_checked('Lifestyle'); ?>> Lifestyle <br>
                <input type="checkbox" name="blog_category" value="Spirituality" class="form-check-input" <?php get_checked('Spirituality'); ?>> Spirituality <br>

            </div>
            <?php if (!empty($category_error)) : ?>
                <div class="alert alert-danger mt-2"><?php echo $category_error; ?></div>
            <?php endif; ?>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Blog Post</button>
    </form>
</div>
<?php include ('footer.php'); ?>
<?php 
// I cannot see the error on the bottom of the page, therefore I can't view the page it in the browser :( 
?>