<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
}

if(isset($_POST['submit'])){
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $profession = $_POST['profession'];
    $profession = filter_var($profession, FILTER_SANITIZE_STRING);
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
    $image_folder = '../uploaded_files/'.$rename;

    $select_tutor_email = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
    $select_tutor_email->execute([$email]);

    if($select_tutor_email->rowCount() > 0){
        $message[] = 'email already taken!'; 
    }else{
        if($pass != $c_pass){
            $message[] = 'Password Not Matched!';
        }
        else{
            if($image_size > 2000000){
                $message[] = 'image size is too large!';
            }else{
                $insert_tutor = $conn->prepare("INSERT INTO `tutors` (id, name, profession, email, password, image) VALUES(?, ?, ?, ?, ?, ?)");
                $insert_tutor->execute([$id, $name, $profession, $email, $c_pass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);

                $verify_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ? LIMIT 1");
                $verify_tutor->execute([$email, $c_pass]);
                $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);

                if($insert_tutor){
                    if($verify_tutor->rowCount() > 0){
                        setcookie('tutor_id', $row['id'], time() + 60*60*24*30, '/');
                        header('location:dashboard.php');
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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

    <!-- Register Section -->

    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">
            <h3>Register Now</h3>
            <div class="flex">
                <div class="col">
                    <p>Your Name <span>*</span></p>
                    <input type="text" name="name" class="box" maxlength="50" required placeholder="Enter Your Name">
                    <p>Your Profession <span>*</span></p>
                    <select name="profession" id="" class="box">
                        <option value="" disabled selected>Select Your Profession</option>
                        <option value="Developer">Developer</option>
                        <option value="Designer">Designer</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Musician">Musician</option>
                        <option value="Engineer">Engineer</option>
                    </select>
                    <p>Your Email <span>*</span></p>
                    <input type="email" name="email" class="box" maxlength="50" required placeholder="Enter Your Email">
                </div>
                <div class="col">
                    <p>Your Password <span>*</span></p>
                    <input type="password" name="pass" class="box" maxlength="20" required placeholder="Create Password">
                    <p>Confirm Password <span>*</span></p>
                    <input type="password" name="c_pass" class="box" maxlength="20" required placeholder="Retype Password">
                    <p>Upload Photo <span>*</span></p>
                    <input type="file" name="image" class="box" required accept="image/*">
                </div>
            </div>
            <input type="submit" value="Register Now" name="submit" class="btn">
            <p class="link">Already have an Account? <a href="login.php">Login Now</a></p>
        </form>

    </section>

    <!-- Register Section End -->

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>