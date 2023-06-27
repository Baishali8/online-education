<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

$count_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$count_likes->execute([$user_id]);
$total_likes = $count_likes->rowCount();

$count_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$count_comments->execute([$user_id]);
$total_comments = $count_comments->rowCount();

$count_bookmark = $conn->prepare("SELECT * FROM `bookmarks` WHERE user_id = ?");
$count_bookmark->execute([$user_id]);
$total_bookmark = $count_bookmark->rowCount();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Quick Selection -->

    <section class="quick-select">
        <h1 class="heading">Quick Options</h1>

        <div class="box-container">
            <?php if($user_id != ''){ ?>

                <div class="box">
                    <h3 class="title">Likes and Comments</h3>
                    <p>total likes: <span><?= $total_likes; ?></span></p>
                    <a href="likes.php" class="inline-btn">View Likes</a>
                    <p>total comments: <span><?= $total_comments; ?></span></p>
                    <a href="comments.php" class="inline-btn">View Comments</a>
                    <p>Saved Playlists: <span><?= $total_bookmark; ?></span></p>
                    <a href="bookmark.php" class="inline-btn">View Bookmarks</a>
                </div>

            <?php }else{ ?>

                <div class="box" style="text-align: center;">
                    <h3 class="title">Login Or Register</h3>
                    <div class="flex-btn">
                        <a href="login.php" class="option-btn">Login</a>
                        <a href="register.php" class="option-btn">Register</a>
                    </div>
                </div>

            <?php } ?>

            <div class="box">
                <h3 class="title">Top Categories</h3>
                <div class="flex">
                    <a href="#" ><i class="fas fa-code"></i><span>development</span></a>
                    <a href="#" ><i class="fas fa-chart-bar"></i><span>buisness</span></a>
                    <a href="#" ><i class="fas fa-pen"></i><span>design</span></a>
                    <a href="#" ><i class="fas fa-chart-line"></i><span>marketing</span></a>
                    <a href="#" ><i class="fas fa-music"></i><span>music</span></a>
                    <a href="#" ><i class="fas fa-camera"></i><span>photography</span></a>
                    <a href="#" ><i class="fas fa-cog"></i><span>software</span></a>
                    <a href="#" ><i class="fas fa-vial"></i><span>science</span></a>
                </div>
            </div>

            <div class="box">
                <h3 class="title">Popular Topics</h3>
                <div class="flex">
                    <a href="#" ><i class="fab fa-html5"></i><span>HTML</span></a>
                    <a href="#" ><i class="fab fa-css3"></i><span>CSS</span></a>
                    <a href="#" ><i class="fab fa-bootstrap"></i><span>Bootstrap</span></a>
                    <a href="#" ><i class="fab fa-js"></i><span>Javascript</span></a>
                    <a href="#" ><i class="fab fa-react"></i><span>React</span></a>
                    <a href="#" ><i class="fab fa-php"></i><span>PHP</span></a>
                    <a href="#" ><i class="fab fa-laravel"></i><span>Laravel</span></a>
                </div>
            </div>

            <div class="box tutor">
                <h3 class="title">Become a Tutor</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat, atque.</p>
                <a href="admin/register.php" class="inline-btn">Get Started</a>
            </div>
        </div>
    </section>

    <!-- Quick Selection End -->

    <!-- Courses Section -->

    <section class="course">
        <h1 class="heading">Latest Courses</h1>

        <div class="box-container">
            <?php 
                $select_courses = $conn->prepare("SELECT * FROM `playlists` WHERE status = ? ORDER BY date DESC LIMIT 6");
                $select_courses->execute(['active']);
                if($select_courses->rowCount() > 0){
                    while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                        $course_id = $fetch_course['id'];

                        $count_course = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ?");
                        $count_course->execute([$course_id, 'Active']);
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
                    echo '<p class="empty">No Courses Added Yet!</p>';
                }
            ?>

        </div>
        <div style="margin-top: 2rem; text-align: center;">
            <a href="courses.php" class="inline-option-btn">View All</a>
        </div>
    </section>

    <!-- Courses Section End -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>

    <script>
        document.querySelectorAll('.title').forEach(content =>{
            if(content.innerHTML.length > 25) content.innerHTML = content.innerHTML.slice(0, 25);
        });
    </script>
</body>
</html>