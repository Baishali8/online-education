<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
    header('location:login.php');
}

if(isset($_POST['delete_comment'])){
    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
    $verify_comment->execute([$delete_id]);

    if($verify_comment->rowCount() > 0){
        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
        $delete_comment->execute([$delete_id]);
        $message[] = 'Comment Deleted Successfully!';
    }else{
        $message[] = 'Comment Already Deleted!';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

    <!-- Header section link -->
    <?php include '../components/admin_header.php'; ?>

        <!-- Comment Starts -->

        <section class="comments">
        <h1 class="heading">User Comments</h1>

        <div class="box-container">
            <?php 
                $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
                $select_comments->execute([$tutor_id]);
                if($select_comments->rowCount() > 0){
                    while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){
                        $comment_id = $fetch_comment['id'];

                        $select_commentor = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                        $select_commentor->execute([$fetch_comment['user_id']]);
                        $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);

                        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
                        $select_content->execute([$fetch_comment['content_id']]);
                        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box">
                <div class="comment-content"><p><?= $fetch_content['title']; ?></p><a href="view_content.php?get_id=<?= $fetch_content['id']; ?>">View Content</a></div>
                <div class="user">
                    <img src="../uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
                    <div>
                        <h3><?= $fetch_commentor['name']; ?></h3>
                        <span><?= $fetch_comment['date']; ?></span>
                    </div>
                </div>
                <p class="comment-box"><?= $fetch_comment['comment']; ?></p>
                <form action="" method="post">
                    <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                    <input type="submit" value="Delete Comment" name="delete_comment" class="inline-delete-btn" onclick="return confirm('Delete This Comment?');">
                </form>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">No Comments Added Yet!</p>';
                }
            ?>
        </div>
    </section>

    <!-- Comment Ends -->

    <!-- Footer section link -->
    <?php include '../components/footer.php'; ?>

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>