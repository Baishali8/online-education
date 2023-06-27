<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $verify_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $verify_contact->execute([$name, $email, $number, $msg]);

    if($verify_contact->rowCount() > 0){
        $message[] = 'Message Sent Already!';
    }else{
        $send_message = $conn->prepare("INSERT INTO `contact` (name, email, number, message) VALUES(?,?,?,?)");
        $send_message->execute([$name, $email, $number, $msg]);
        $message[] = 'Message Sent Successfully';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Contact Starts -->

    <section class="contact">
        <div class="row">
            <div class="image">
                <img src="./images/contact-img.svg" alt="">
            </div>

            <form action="" method="post">
                <h3>Get in Touch</h3>
                <input type="text" class="box" required maxlength="50" name="name" placeholder="Please Enter Your Name">
                <input type="email" class="box" required maxlength="50" name="email" placeholder="Please Enter Your Email">
                <input type="number" class="box" required maxlength="50" name="number" placeholder="Please Enter Your Number" min="0" max="9999999999">
                <textarea name="msg" class="box" cols="30" rows="10" placeholder="Enter Your Message"></textarea>
                <input type="submit" value="Send Message" class="inline-btn" name="submit">
            </form>
        </div>

        <div class="box-container">
            <div class="box">
                <i class="fas fa-phone"></i>
                <h3>Phone Number</h3>
                <a href="tel:1234560789">123-456-0789</a>
                <a href="tel:1223334444">122-333-4444</a>
            </div>

            <div class="box">
                <i class="fas fa-envelope"></i>
                <h3>Email Address</h3>
                <a href="mailto:baishali@gmail.com">baishali@gmail.com</a>
                <a href="mailto:duttabaishali@gmail.com">duttabaishali@gmail.com</a>
            </div>

            <div class="box">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Office Address</h3>
                <a href="#">Santinagar, Belur, Howrah- 711227</a>
            </div>
        </div>
    </section>

    <!-- Contact Ends -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>