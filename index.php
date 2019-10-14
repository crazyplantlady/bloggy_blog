<?php
$file_str = @file_get_contents('blogs.json');
if (!$file_str) {
    $blogs = [];
} else {
    $blogs = json_decode($file_str, true);
}

$page_title = 'bloggy blog';
include('header.php');


// I tried to put in a delete button, but something's wrong, the page doesn't work if I have this text, can't see why, tho. 

// if ($result) {
//     $_SESSION['success_message'] = 'Blog deleted successfully';
//     header('Location: insert.php');
// } else {
//     $_SESSION['error_message'] = 'Blog could not be deleted';
//     header('Location: insert.php');
// }
// 
?>

<div class=" col col-md-8 mx-auto">
    <h1 class="mb-5 text-center">Daily blog</h1>

    <?php if (empty($blogs)) : ?>
        <div class="alert alert-warning" role="alert">
            Let's write a blog.
        </div>
    <?php endif; ?>

    <?php if (!empty($blogs)) : ?>
        <div class="blogs">
            <?php foreach ($blogs as $blog) : ?>
                <div class="item">
                    <h3><?php echo $blog['blog_title']; ?></h3>
                    <p><?php echo $blog['blog_text']; ?></p>
                    <div class="status"><?php echo $status['status']; ?></div>
                    <div class="extra-info">
                        <span><strong>Category:</strong> <?php echo join(', ', $blog['blog_category']); ?></span>
                    </div>
                    <a href="delete.php?id=<?= $data['id'] ?>"><i class="fa fa-trash"></i></a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
                $query = "DELETE FROM user_info WHERE id =" . $id;
            } else {
                echo 'No id set';
            } ?>
    <?php endif; ?>
</div>
<?php include('footer.php') ?> 