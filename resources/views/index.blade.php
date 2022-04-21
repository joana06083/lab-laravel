<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>首頁</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index" style="color:blue;">Home</a>
                    </li>
                </ul>

                <form class="d-flex" action="/" method="POST">
                    <input class="form-control me-2" type="search" id="search" placeholder="search" name="search"/>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>


                @if(!empty($LoggedUserInfo))
                    <div>Hi!{{$LoggedUserInfo->userName}}</div>
                    <a class="nav-link" href="logout">登出</a>
                @else
                    <a class="nav-link" href="register">註冊</a>
                    <a class="nav-link" href="login">登入</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- 新增文章區塊 -->
    <div class="container">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="add_art.php">新增文章</a>
            </li>
        </ul>
        <a href="">文章標題：</a>
        <a>作者：</a>
        <a>最後修改時間：</a>
        <a href="">編輯</a>
        <a href="">刪除</a>
        <hr/>
    </div>
</body>
</html>
