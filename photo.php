<?php
    session_start();
    if(!isset($_SESSION['SESSION_EMAIL'])){
        header("Location:index.php");
        die();
    }

    include 'config.php';
    $query = mysqli_query($conn, "SELECT * FROM students WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if(mysqli_num_rows($query)>0){
        $row = mysqli_fetch_assoc($query);

        echo "Welcome " . $row['name'] . "<a href='logout.php'>Logout</a>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo</title>
    <link rel="stylesheet" href="photo.css">
</head>
<body>
<div class="all">
    <img class="imgtop" src="img/Element 01.svg">
    <h1 class="main-heading">AK</h1>
    <div class="content">
        <div class="upload-photo">
        <h3 class="download-heading">Загрузите фото</h3>
            <div class="photo-frame">
                <label class="upload-button">
                    <div class="input-cover">
                        <input class="docpicker" type="file" id="docpicker"
                        accept=".jpg" value = "Ho" required>
                        <img class="pin-img" src="img/pin.svg" alt="">
                      </div>
                    </label>
            </div>
        </div>
        <div class="req">
            <ul class="requirements">
                <li class="requirement-item">-Минимальный размер фото 100x100</li>
                <li class="requirement-item">-На фото должно быть четко видно лицо</li>
                <li class="requirement-item">-Без редакторов</li>
                <li class="requirement-item">-Без лишних людей на фото</li>
                <li class="requirement-item">-Не допускаются затемненные очки</li>
            </ul>
        </div> 
    </div>
    <form class="finish" action="main.html" method="get"> 
        <button class="finish-btn">Завершить</button> 
    </form>
    <div class="footerimg">
        <img class="imgf" src="img/backgroungimg.png" alt="">
    </div>
</div>
</body>
</html>