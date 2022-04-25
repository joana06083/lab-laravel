@include('blade.indexNav')
<div class="container">
    <br>
    <h4>新增文章</h4>
    <form role="form" action="{{route('art.store')}}" enctype="multipart/form-data" method="post">
    @csrf
        <div class="results">
            @if(Session::get('Fail'))
                <div class="alert alert-danger">
                    {{Session::get('Fail')}}
                </div>
            @endif
        </div>
        <div style="display: none;"　>
            <label for="title" class="form-label">登入人員</label>
            <input class="form-control" rows="3" id="userNo" name="userNo" value="{{$LoggedUserInfo->userNo}}">
            </input>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">標題</label>
            <textarea class="form-control" rows="3" id="title" name="title" value="{{old('title')}}"></textarea>
            <span class="text-danger">@error('title'){{$message}} @enderror </span>
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
