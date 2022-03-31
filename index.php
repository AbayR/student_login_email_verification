<?php
    session_start();
    if(isset($_SESSION['SESSION_EMAIL'])){
        header("Location:photo.php");
        die();
    }

    include 'config.php';
    $msg = "";


    if(isset($_GET['verification'])){
        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE code='{$_GET['verification']}'")) > 0){
            $query = mysqli_query($conn, "UPDATE students SET code='' WHERE code='{$_GET['verification']}'");
            
        if($query){
            $msg = "<div class='alert alert-success'>Account verification has been successfully completed</div>";
        }
        } else{
            header("Location:index.php");
        }
    }
    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    
        $sql = "SELECT * FROM students WHERE email = '{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);

            if(empty($row['code'])){
                $_SESSION['SESSION_EMAIL'] = $email;
                header("Location: photo.php");
            }
            else{
                $msg = "<div class = 'alert alert-info'>First verify your account and try again</div>";
            }
        } else{
            $msg = "<div class = 'alert alert-danger'>Email or password are not correct!</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;1,100;1,300;1,400&display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="signUp.css">
    <title>SignUp</title>
</head>

<body>
    <div class="all">
        <img class="imgtop" src="img/Element 01.svg" alt="">
        
            <div class="formBx">
                <h3>BILIM</h3>
                <?php echo $msg; ?>
                <form class="form" method="post">
                    <div class="inputdiv">
                        <p class="text">Логин</p>
                        <input name="email" class="input" type="email" placeholder="E-mail">
                    </div>
                    <div class="inputdiv">
                        <p class="text">Пароль</p>
                        <input name="password" class="input" type="password" placeholder="Password">
                    </div>
                    <div class="remember">
                        <label><input id="check" type="checkbox" name=""><p>Запомнить меня</p></label>
                    </div>
                    <button name="submit" type="submit" class="signbtn">Войти</button>
                    <div class="no-account">
                        <p>Нет аккаунта?</p>
                        <a href="signform.php">Регистрация</a>
                    </div>
                </form>
            </div>
        
        <div class="footerimg">
            <img class="imgf" src="img/backgroungimg.png" alt="">
        </div>
    </div>
</body>

</html>