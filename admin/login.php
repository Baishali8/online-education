<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
}

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $verify_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ? LIMIT 1");
    $verify_tutor->execute([$email, $pass]);
    $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);

    if($verify_tutor->rowCount() > 0){
        setcookie('tutor_id', $row['id'], time() + 60*60*24*30, '/');
        header('location:dashboard.php');
    }else{
        $message[] = 'Incorrect Email or Password!';
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body style="padding-left: 0;">

<?php
    if(isset($message)){
        foreach($message as $message){
            echo '
                <div class="message form">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
            ';
        }
    }
?>

    <!-- Login Section -->

    <section class="form-container">

        <form action="" class="login" method="post" enctype="multipart/form-data">
            <h3>Welcome Back!</h3>
            <p>Your Email <span>*</span></p>
            <input type="email" name="email" class="box" maxlength="50" required placeholder="Enter Your Email">
            <p>Your Password <span>*</span></p>
            <input type="password" name="pass" class="box" maxlength="20" required placeholder="Create Password">
            <input type="submit" value="Login Now" name="submit" class="btn">
            <p class="link">Don't have an Account? <a href="register.php">Sign Up Now</a></p>
        </form>

    </section>

    <!-- Login Section End -->

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>