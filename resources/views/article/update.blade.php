@include('blade.indexNav')

<div class="container">
    <form role="form" action="{{ route('art.update', $artvalue->articleNo ) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <a>建立時間：{{$artvalue->createTime}}</a>
            <a>最後修改時間：{{$artvalue->updateTime}}</a>
            <a>作者：{{$artvalue->userNo}}</a>
        </div>
        <div class="mb-3">
            <label class="form-label">標題</label>
            <textarea class="form-control" rows="3" id="articleTitle" name="articleTitle">{{$artvalue->articleTitle}}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">內容</label>
            <textarea class="form-control" rows="3" id="articleContent" name="articleContent">{{$artvalue->articleContent}}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">修改</button>
    </form>
</div>
