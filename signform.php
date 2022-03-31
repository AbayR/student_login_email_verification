<!--student registration-->
<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: photo.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $parent = mysqli_real_escape_string($conn, $_POST['parent']);
        $tel = mysqli_real_escape_string($conn, $_POST['tel']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
        $code = mysqli_real_escape_string($conn, md5(rand()));
        
       if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE email = '{$email}'")) > 0){
        $msg = "<div class = 'alert alert-danger'>{$email} - This email address has been already exists.</div>";
    }
    else{
        if($password === $cpassword){
             $sql = "INSERT INTO students (name, email, parent, tel, password, code) VALUES ('{$name}', '{$email}', '{$parent}', '{$tel}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'EMAIL';                     //SMTP username
                        $mail->Password   = 'PASSWORD';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('EMAIL');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'no reply';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost/sign/?verification='.$code.'">http://localhost/sign/?verification='.$code.'</a></b>';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
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
    <title>SignForm</title>
    <link rel="stylesheet" href="signform.css">
    <script src="jquery.js" type="text/javascript"></script>
    <script src="jquery.maskedinput.js" type="text/javascript"></script>
</head>

<body>
    <div class="all">
        <img class="imgtop" src="img/Element 01.svg" alt="">
        <div class="form-box">
            <h3 id="bilim">AK</h3>
            <p style="text-align: center; font-size: 13px; color: #5C5C5C; margin: auto;">Выберите тип регистрации</p>
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="teach()">Ученик</button>
                <button type="button" class="toggle-btn" onclick="student()">Учитель</button>
            </div>
            <div class="social-icons">
                <img src="fb.png" alt="">
                <img src="gp.png" alt="">
                <img src="tw.png" alt="">
            </div>
            <!--student-->
            <?php echo $msg;?>
            <form id="teach" class="input-group" method="post">
                <input type="text" name="name" class="input-field" placeholder="ФИО" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                <input type="email" name="email" class="input-field" placeholder="Электронная почта" value="<?php if(isset($_POST['submit'])){echo $email;}?>" required>
                <input type="text" name="parent" class="input-field" placeholder="ФИО родителя" value="<?php if(isset($_POST['submit'])){echo $parent;}?>" required>
                <input type="tel" name="tel" pattern="+7[0-9]{3}-[0-9]{3}-[0-9]{4}" class="input-field"
                    placeholder="Номер телефона родителя" value="<?php if(isset($_POST['submit'])){echo $tel;}?>" required>
                <input type="password" name="password" class="input-field" id="student_pass" onkeyup="compareStudent();"
                    placeholder="Пароль" value="<?php if(isset($_POST['submit'])){echo $password;}?>" required>
                <input type="password" name="cpassword" class="input-field" id="student_confirm" onkeyup="compareStudent();"
                    placeholder="Подтверждение пароля" value="<?php if(isset($_POST['submit'])){echo $cpassword;}?>" required>
                <p id='message'></p>
                <input type="checkbox" class="check-box" required><span>Я принимаю все соглашения</span>
                <button name="submit" type="submit" class="submit-btn" id="student_reg">Регистрация</button>
            </form>
            <!--teacher-->
            <form action="regsearch.html" method="get" id="student" class="input-group">
                <input type="text" class="input-field" placeholder="ФИО" required>
                <input type="email" class="input-field" placeholder="Электронная почта" required>
                <input type="tel" name="tel" pattern="+7[0-9]{3}-[0-9]{3}-[0-9]{4}" class="input-field"
                    placeholder="Номер телефона" required>
                <input type="password" class="input-field" id="teahcer_pass" onkeyup="compareTeacher();"
                    placeholder="Пароль" required>
                <input type="password" class="input-field" id="teahcer_confirm" onkeyup="compareTeacher();"
                    placeholder="Подтверждение пароля" required>
                <p id='message2'></p>
                <input type="checkbox" class="check-box" required><span>Я принимаю все соглашения</span>
                <button type="submit" class="submit-btn" id="teacher_reg">Регистрация</button>
            </form>
        </div>
        <div class="footerimg">
            <img class="imgf" src="img/backgroungimg.png" alt="">
        </div>
    </div>

    <script>
        var x = document.getElementById("teach");
        var y = document.getElementById("student");
        var z = document.getElementById("btn");

        function student() {
            x.style.left = "-400px"
            y.style.left = "50px"
            z.style.left = "110px"
        }
        function teach() {
            x.style.left = "50px"
            y.style.left = "450px"
            z.style.left = "0"
        }

        var compareStudent = function () {
            if (document.getElementById('student_pass').value ==
                document.getElementById('student_confirm').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Пароли совпадают';
                document.getElementById('student_pass').style.borderBlockColor = 'green';
                document.getElementById('student_confirm').style.borderBlockColor = 'green';
                document.getElementById('student_reg').disabled = false;
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Пароли не совпадают';
                document.getElementById('student_pass').style.borderBlockColor = 'red';
                document.getElementById('student_confirm').style.borderBlockColor = 'red';
                document.getElementById('student_reg').disabled = true;
            }
            if (document.getElementById('student_pass').value == "" || document.getElementById('student_confirm').value == "") {
                document.getElementById('message').innerHTML = null;
            }
        }
        var compareTeacher = function () {
            if (document.getElementById('teahcer_pass').value ==
                document.getElementById('teahcer_confirm').value) {
                document.getElementById('message2').style.color = 'green';
                document.getElementById('message2').innerHTML = 'Пароли совпадают';
                document.getElementById('teahcer_pass').style.borderBlockColor = 'green';
                document.getElementById('teahcer_confirm').style.borderBlockColor = 'green';
                document.getElementById('teacher_reg').disabled = false;
                
            } else {
                document.getElementById('message2').style.color = 'red';
                document.getElementById('message2').innerHTML = 'Пароли не совпадают';
                document.getElementById('teahcer_pass').style.borderBlockColor = 'red';
                document.getElementById('teahcer_confirm').style.borderBlockColor = 'red';
                document.getElementById('teacher_reg').disabled = true;
            }
            if (document.getElementById('teahcer_pass').value == "" || document.getElementById('teahcer_confirm').value == "") {
                document.getElementById('message2').innerHTML = null;
            }
        }
    </script>
</body>

</html>