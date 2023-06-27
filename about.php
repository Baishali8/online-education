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
    <title>About Us</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- About Section -->

    <section class="about">
        <div class="row">
            <div class="image">
                <img src="images/about-img.svg" alt="">
            </div>
            <div class="content">
                <h3>Why Choose Us?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore pariatur, modi vero debitis corporis, ex similique velit omnis placeat ab fugit illo voluptatem iusto, amet possimus eveniet maxime? Aliquam, quas..</p>
                <a href="courses.php" class="inline-btn">Our Courses</a>
            </div>
        </div>

        <div class="box-container">
            <div class="box">
                <i class="fas fa-graduation-cap"></i>
                <div>
                    <h3>+1k</h3>
                    <span>Online Courses</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3>+25k</h3>
                    <span>Brilliants Student</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-chalkboard-teacher"></i>
                <div>
                    <h3>+5k</h3>
                    <span>Experts Teacher</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-briefcase"></i>
                <div>
                    <h3>100%</h3>
                    <span>Job placement</span>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section End -->

    <!-- Review Section Starts -->

    <section class="reviews">
        <h1 class="heading">Student's Reviews</h1>
        
        <div class="box-container">
            <div class="box">
                <div class="user">
                    <img src="./images/pic-2.jpg" alt="">
                    <div>
                        <h3>john deo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id nam exercitationem quam in molestiae
                eligendi magnam est, dicta odio. At!</p>
            </div>            

            <div class="box">
                <div class="user">
                    <img src="./images/pic-3.jpg" alt="">
                    <div>
                        <h3>john deo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id nam exercitationem quam in molestiae
                eligendi magnam est, dicta odio. At!</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="./images/pic-4.jpg" alt="">
                    <div>
                        <h3>john deo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id nam exercitationem quam in molestiae
                eligendi magnam est, dicta odio. At!</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="./images/pic-5.jpg" alt="">
                    <div>
                        <h3>john deo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id nam exercitationem quam in molestiae
                eligendi magnam est, dicta odio. At!</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="./images/pic-6.jpg" alt="">
                    <div>
                        <h3>john deo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id nam exercitationem quam in molestiae
                eligendi magnam est, dicta odio. At!</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="./images/pic-7.jpg" alt="">
                    <div>
                        <h3>john deo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id nam exercitationem quam in molestiae
                eligendi magnam est, dicta odio. At!</p>
            </div>
        </div>
    </section>

    <!-- Review Section Ends -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>