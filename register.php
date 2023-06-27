<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['submit'])){
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = './uploaded_files/'.$rename;

    $select_user_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user_email->execute([$email]);

    if($select_user_email->rowCount() > 0){
        $message[] = 'email already taken!'; 
    }else{
        if($pass != $c_pass){
            $message[] = 'Password Not Matched!';
        }
        else{
            if($image_size > 2000000){
                $message[] = 'image size is too large!';
            }else{
                $insert_user = $conn->prepare("INSERT INTO `users` (id, name, email, password, image) VALUES(?, ?, ?, ?, ?)");
                $insert_user->execute([$id, $name, $email, $c_pass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);

                $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
                $verify_user->execute([$email, $c_pass]);
                $row = $verify_user->fetch(PDO::FETCH_ASSOC);

                if($insert_user){
                    if($verify_user->rowCount() > 0){
                        setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
                        header('location:home.php');
                    }else{
                        $message[] = 'Something Went Wrong!';
                    }
                }
            }
        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Register Section -->

    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">
            <h3>Register Now</h3>
            <div class="flex">
                <div class="col">
                    <p>Your Name <span>*</span></p>
                    <input type="text" name="name" class="box" maxlength="50" required placeholder="Enter Your Name">
                    <p>Your Email <span>*</span></p>
                    <input type="email" name="email" class="box" maxlength="50" required placeholder="Enter Your Email">
                </div>
                <div class="col">
                    <p>Your Password <span>*</span></p>
                    <input type="password" name="pass" class="box" maxlength="20" required placeholder="Create Password">
                    <p>Confirm Password <span>*</span></p>
                    <input type="password" name="c_pass" class="box" maxlength="20" required placeholder="Retype Password">
                </div>
            </div>
            <p>Upload Photo <span>*</span></p>
            <input type="file" name="image" class="box" required accept="image/*">
            <input type="submit" value="Register Now" name="submit" class="btn">
        </form>

    </section>

    <!-- Register Section End -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>