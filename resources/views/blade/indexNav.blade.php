
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="/resources/css/app.css"> -->
    <title>首頁</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/" style="color:black;">Home</a>
                    </li>
                </ul>

                <form class="d-flex" action="/" method="POST">
                    <input class="form-control me-2" type="search" id="search" placeholder="search" name="search"/>
                    <button type="submit" class="btn btn-secondary">Search</button>
                </form>
                &nbsp;
                @if(!empty($LoggedUserInfo))
                    <a class="btn btn-primary" aria-current="page"
                    href="{{ route('art.create')}}">新增文章</a>
                    &nbsp;
                    <label>Hi! {{$LoggedUserInfo->userName}}</label>
                    &nbsp;
                    <a href="/logout" class="btn btn-secondary" >登出</a>
                @else
                    <a href="register" class="btn btn-primary">註冊</a>
                    &nbsp;
                    <a href="login" class="btn btn-secondary">登入</a>
                @endif
            </div>
        </div>
    </nav>
    <br>

    <!-- 新增留言 -->
    @section('mesCreate')
    <form role="form" action="" method="post">
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
        <a href="">編輯</a>
        <a href="">刪除</a>
    </div>
    <div>
        <a>留言內容 ：</a>
    </div>
    <hr/>
    @endsection
</body>
</html>
