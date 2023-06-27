<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Tutor</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Search teachers section -->

    <section class="teachers">
        <h1 class="heading">Expert Tutors</h1>

        <form action="search_tutor.php" method="post" class="tutor-search">
            <input type="text" name="search_tutor_box" placeholder="Search Tutors" maxlength="100" required>
            <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
        </form>

        <div class="box-container">

            <?php
                if(isset($_POST['search_tutor_box']) or isset($_POST['search_tutor_btn'])){
                    $search_tutor = $_POST['search_tutor_box'];
                    

                $selector_tutors = $conn->prepare("SELECT * FROM `tutors` WHERE name LIKE '%{$search_tutor}%'");
                $selector_tutors->execute();
                if($selector_tutors->rowCount() > 0){
                    while($fetch_tutor = $selector_tutors->fetch(PDO::FETCH_ASSOC)){
                        $tutor_id = $fetch_tutor['id'];
                        
                        $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
                        $count_likes->execute([$tutor_id]);
                        $total_likes = $count_likes->rowCount();

                        $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
                        $count_comments->execute([$tutor_id]);
                        $total_comments = $count_comments->rowCount();

                        $count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
                        $count_content->execute([$tutor_id]);
                        $total_content = $count_content->rowCount();
                        
                        $count_playlists = $conn->prepare("SELECT * FROM `playlists` WHERE tutor_id = ?");
                        $count_playlists->execute([$tutor_id]);
                        $total_playlists = $count_playlists->rowCount();
            ?>

            <div class="box">
                <div class="tutor">
                    <img src="./uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                    <div>
                        <h3><?= $fetch_tutor['name']; ?></h3>
                        <span><?= $fetch_tutor['profession']; ?></span>
                    </div>
                </div>

                <p>Total Videos: <span><?= $total_content; ?></span></p>
                <p>Total Courses: <span><?= $total_playlists; ?></span></p>
                <p>Total Likes: <span><?= $total_likes; ?></span></p>
                <p>Total Comments: <span><?= $total_comments; ?></span></p>

                <a href="tutor_profile.php?get_id=<?= $fetch_tutor['email']; ?>" class="inline-btn">View profile</a>
            </div>

            <?php       
                    }
                }else{
                    echo '<p class="empty">Result Not Found</p>';
                }
            }else{
                echo '<p class="empty">Search Tutors...</p>';
            }
            ?>
        </div>
    </section>

    <!-- Search teachers section End -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>