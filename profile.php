<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
    header('location:home.php');
}

$count_bookmark = $conn->prepare("SELECT * FROM `bookmarks` WHERE user_id= ?");
$count_bookmark->execute([$user_id]);
$total_bookmarks = $count_bookmark->rowCount();

$count_like = $conn->prepare("SELECT * FROM `likes` WHERE user_id= ?");
$count_like->execute([$user_id]);
$total_likes = $count_like->rowCount();

$count_comment = $conn->prepare("SELECT * FROM `comments` WHERE user_id= ?");
$count_comment->execute([$user_id]);
$total_comments = $count_comment->rowCount();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Profile Section Starts -->

    <section class="profile">

        <h1 class="heading">Profile Details</h1>

        <div class="details">
            <div class="tutor">
                <img src="./uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
                <h3><?= $fetch_profile['name']; ?></h3>
                <p><?= $fetch_profile['email']; ?></p>
                <span>Student</span>
                <a href="update.php" class="inline-btn">Update Profile</a>
            </div>

            <div class="box-container">
                <div class="box">
                    <h3><?= $total_bookmarks ?></h3>
                    <p>Playlist Bookmarked</p>
                    <a href="playlists.php" class="btn">View Playlists</a>
                </div>

                <div class="box">
                    <h3><?= $total_likes ?></h3>
                    <p>Total Liked</p>
                    <a href="contents.php" class="btn">View likes</a>
                </div>

                <div class="box">
                    <h3><?= $total_comments ?></h3>
                    <p>Total Commented</p>
                    <a href="comments.php" class="btn">View Comments</a>
                </div>
            </div>
        </div>

    </section>

    <!-- Profile Section Ends -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>