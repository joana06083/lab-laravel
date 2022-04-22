
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
                        <a class="nav-link active" href="/" style="color:blue;">Home</a>
                    </li>
                </ul>
                @section('search')
                <form class="d-flex" action="/" method="POST">
                    <input class="form-control me-2" type="search" id="search" placeholder="search" name="search"/>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                @endsection

                @if(!empty($LoggedUserInfo))
                    <div>Hi!{{$LoggedUserInfo->userName}}</div>
                    <a class="nav-link" href="/logout">登出</a>
                @else
                    <a class="nav-link" href="register">註冊</a>
                    <a class="nav-link" href="login">登入</a>

                @endif
            </div>
        </div>
    </nav>
    @section('artCreate')
    <div class="container">
        <ul class="nav justify-content">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="art/create/">新增文章</a>
            </li>
        </ul>
    </div>
    @endsection


    <!-- 新增留言 -->
    @section('mesCreate')
    <form role="form" action="mes.php?method=add&uid=&loginid=&artno=" method="post">
        <div class="mb-3">
        <label for="content" class="form-label">留言內容</label>
        <textarea class="form-control" rows="3" id="content" name="content"></textarea>
    </div>
        <button type="submit" class="btn btn-primary">新增</button>
    </form>
    <hr/>
    @endsection

    @section('mesInfo')
    <!-- 留言內容 -->
    <div>
        <a>留言者：</a>
        <a>最後修改時間：</a>
        <a href="update_mes.php?uid=&loginid=&artno=&msgno=">編輯</a>
        <a href="mes.php?method=del&uid=&loginid=&artno=&msgno=">刪除</a>
    </div>
    <div>
        <a>留言內容 ：</a>
    </div>
    <hr/>
    @endsection
</body>
</html>
