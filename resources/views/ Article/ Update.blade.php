@extends('blade.navbar')

@section('title', '修改文章')

@if(session('Fail'))
<div class="alert alert-danger">
    {{ session('Fail') }}
</div>
@endif

@section('content')
<div class="container">
    <h4>修改文章</h4>
    <form role="form" action="{{ route('art.update', $artvalue->articleNo ) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <a>建立時間：{{$artvalue->createTime}}</a>
            <a>最後修改時間：{{$artvalue->updateTime}}</a>
            <a>作者：{{$LoggedUserInfo->userName}}</a>
        </div>
        <div class="mb-3">
            <label class="form-label">標題</label>
            <textarea class="form-control" rows="3" id="articleTitle" name="articleTitle">{{$artvalue->articleTitle}}</textarea>
            <span class="text-danger">@error('articleTitle'){{$message}} @enderror </span>
        </div>

        <div class="mb-3">
            <label class="form-label">內容</label>
            <textarea class="form-control" rows="3" id="articleContent" name="articleContent">{{$artvalue->articleContent}}</textarea>
            <span class="text-danger">@error('articleContent'){{$message}} @enderror </span>
        </div>

        <button type="submit" class="btn btn-primary">修改</button>
    </form>
</div>
@endsection
