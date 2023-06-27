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
    <title>Search Course</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Search Course Starts -->

    <section class="course">
        <h1 class="heading">Search Result</h1>

        <div class="box-container">
            <?php 
                if(isset($_POST['search_box']) or isset($_POST['search-btn'])){
                    $search_box = $_POST['search_box'];
                
                $select_courses = $conn->prepare("SELECT * FROM `playlists` WHERE title LIKE '%{$search_box}%' AND status = ? ORDER BY date DESC");
                $select_courses->execute(['active']);
                if($select_courses->rowCount() > 0){
                    while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                        $course_id = $fetch_course['id'];

                        $count_course = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                        $count_course->execute([$course_id]);
                        $total_courses = $count_course->rowCount();

                        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                        $select_tutor->execute([$fetch_course['tutor_id']]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
            ?>

                        <div class="box">
                            <div class="tutor">
                                <img src="./uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                                <div>
                                    <h3><?= $fetch_tutor['name']; ?></h3>
                                    <span><?= $fetch_course['date']; ?></span>
                                </div>
                            </div>
                            <div class="thumb">
                                <span><?= $total_courses; ?></span>
                                <img src="./uploaded_files/<?= $fetch_course['thumb']; ?>" alt="">
                            </div>
                            <h3 class="title"><?= $fetch_course['title']; ?></h3>
                            <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">View Course</a>
                        </div>

            <?php
                    }
                }else{
                    echo '<p class="empty">No Courses Found!</p>';
                }
            }else{
                echo '<p class="empty">Search Something..</p>';
            }
            ?>

        </div>
    </section>

    <!-- Search Course Ends -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>