<?php
    include_once "db.php";
    session_start();
    if(!isset($_SESSION["user_id"])){
    	header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>新增文章</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" href="index.php" style="color:blue;">Home</a>
                </li>
            </ul>
            <label>Hi!
                <?php 
                    global $db;
                    $sql = $db->prepare("SELECT user_name FROM `user` WHERE user_no = '{$_SESSION['user_id']}'");
                    $sql->execute();
                    $row = $sql->fetchColumn();
                    echo $row;
                ?>
            </label>
            <a href="config.php?method=logout">登出</a>
        </div>
    </div>
    </nav>
    <div class="container">
        <form role="form" action="art.php?method=add" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">標題</label>
                <textarea class="form-control" rows="3" id="title"  name="title"></textarea>
            </div>
            <div class="mb-3">
            <label for="content" class="form-label">內容</label>
                <textarea class="form-control" rows="3" id="content" name="content"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">上傳圖片</label>
                <input type="file" id="profile_pic" name="profile_pic" accept=".jpg, .jpeg, .png">
            </div>
            <button type="submit" class="btn btn-primary">新增</button>
        </form>
    </div>
</body>
</html>