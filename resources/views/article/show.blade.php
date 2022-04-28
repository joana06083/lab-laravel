@include('blade.indexNav')

@if(session('Success'))
<script type="text/javascript">
    alert("{{ session('Success') }}");
</script>
@elseif(session('Fail'))
<script type="text/javascript">
    alert("{{ session('Fail') }}");
</script>
@endif

<!-- 文章內文 -->
<div class="container">
    <br>
    <h4>{{$ArtLists->articleTitle}}</h4>
        <div class="mb-3">
            <label class="form-label">作者：{{$ArtLists->userName}}</label>
            <label class="form-label">建立時間：{{$ArtLists->createTime}}</label>
            <label class="form-label">更新時間：{{$ArtLists->updateTime}}</label>
        </div>
        @if(!empty($ArtLists->imgUrl))
        <div class="mb-3 col-3">
            <img src="{{ URL::asset("$ArtLists->imgUrl")}}"
             class="img-fluid" alt="{{$ArtLists->imgUrl}}">
        </div>
        @endif
        <div class="mb-3">
            <label class="form-label">內容</label>
            <br>
            <a>{{$ArtLists->articleContent}}</a>
        </div>

    <hr>
</div>

<!-- 留言內容 -->
<div class="container">
    <h5>留言區</h5>
    @foreach ($MesLists as $mes)
    <div class="mb-3">
        <a>留言者：{{$mes->userName}}</a>
        <a>建立時間：{{$mes->createTime}}</a>
        <a>最後修改時間：{{$mes->updateTime}}</a>
    </div>

    @if(!empty($mes->imgUrl))
    <div class="mb-2 col-2">
        <img src="{{ URL::asset("$mes->imgUrl")}}"
            class="img-fluid" alt="{{$mes->imgUrl}}">
    </div>
    @endif

    <div class="mb-3">
        <label>留言內容 ：{{$mes->messageContent}}</label>
    </div>

    @if(!empty($LoggedUserInfo))
        @if($mes->userNo==$LoggedUserInfo->userNo)
        <form role="form" action="{{ route('mes.destroy', $mes->messageNo)}}" method="post">
            <a class="btn btn-primary" href="{{ route('mes.edit', $mes->messageNo)}}">編輯</a>
            @csrf
            @method('DELETE')

            <input id="articleNo" name="articleNo" value="{{$mes->articleNo}}" style="display: none;"></input>
            <button class="btn btn-danger" type="submit">刪除</button>
        </form>
        @endif
    @endif
    <hr>
    @endforeach
</div>
@if(!empty($LoggedUserInfo))
<!-- 新增留言 -->
<div class="container">
    <form role="form" action="{{route('mes.store')}}" enctype="multipart/form-data" method="post">
    @csrf
        <div class="results">
            @if(Session::get('Fail'))
                <div class="alert alert-danger">
                    {{Session::get('Fail')}}
                </div>
            @endif
        </div>
        <div style="display: none;">
            @if(!empty($LoggedUserInfo))
            <label for="userNo" class="form-label">登入人員</label>
            <input class="form-control" rows="3" id="userNo" name="userNo" value="{{$LoggedUserInfo->userNo}}">
            @endif
            <label for="articleNo" class="form-label">文章代號</label>
            <input class="form-control" rows="3" id="articleNo" name="articleNo" value="{{$ArtLists->articleNo}}">
        </div>
        <div class="mb-3">
        <label for="content" class="form-label">內容</label>
            <textarea class="form-control" rows="3" id="content" name="content" value="{{old('content')}}"></textarea>
            <span class="text-danger">@error('content'){{$message}} @enderror </span>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">上傳圖片</label>
            <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png">
            <span class="text-danger">@error('image'){{$message}} @enderror </span>
        </div>
        <button type="submit" class="btn btn-primary">新增</button>
    </form>
</div>
@endif
