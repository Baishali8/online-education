<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
    header('location:home.php');
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

if(isset($_POST['edit_comment'])){
    $edit_id = $_POST['edit_id'];
    $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);

    $comment_box = $_POST['comment_box'];
    $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);

    $verify_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ?");
    $verify_edit_comment->execute([$edit_id, $comment_box]);

    if($verify_edit_comment->rowCount() > 0){
        $message[] = 'Comment Already Added!';
    }else{
        $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
        $update_comment->execute([$comment_box, $edit_id]);
        $message[] = 'Comment Update Successfully!';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Comments</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Update Comment -->

    <?php 
        if(isset($_POST['update_comment'])){
            $update_id = $_POST['comment_id'];
            $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
            $select_update_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? LIMIT 1");
            $select_update_comment->execute([$update_id]);
            $fetch_update_comment = $select_update_comment->fetch(PDO::FETCH_ASSOC);
    ?>

    <section class="comment-form">
        <h1 class="heading">Update Comment</h1>

        <form action="" method="POST">
            <input type="hidden" name="edit_id" value="<?= $fetch_update_comment['id']; ?>">
            <textarea name="comment_box" class="box" placeholder="Add a Comment" cols="30" rows="10" maxlength="1000"><?= $fetch_update_comment['comment']; ?></textarea>
            <div class="flex-btn">
                <a href="comments.php" class="inline-option-btn">Cancel Edit</a>
                <input type="submit" value="Edit Comment" name="edit_comment" class="inline-btn">
            </div>
        </form>
    </section>

    <?php
        }else{

        }
    ?>

    <!-- Update Comment End -->

    <!-- Comment Section -->

    <section class="comments">
        <h1 class="heading">Your Comments</h1>

        <div class="box-container">
            <?php 
                $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
                $select_comments->execute([$user_id]);
                if($select_comments->rowCount() > 0){
                    while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){
                        $comment_id = $fetch_comment['id'];

                        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
                        $select_content->execute([$fetch_comment['content_id']]);
                        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box">
                        <div class="comment-content">
                            <p><?= $fetch_content['title']; ?></p>
                            <a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>">View Content</a>
                        </div>
                
                <p class="comment-box"><?= $fetch_comment['comment']; ?></p>
                <form action="" method="post">
                    <input type="hidden" name="comment_id" value="<?= $comment_id; ?>">
                    <input type="submit" value="Update Comment" name="update_comment" class="inline-option-btn">
                    <input type="submit" value="Delete Comment" name="delete_comment" class="inline-delete-btn" onclick="return confirm('Delete This Comment?');">
                </form>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty" style="padding: 0;">No Comments Added Yet!</p>';
                }
            ?>
        </div>
    </section>


    <!-- Comment Section Ends -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>