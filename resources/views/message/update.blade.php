@include('blade.indexNav')

<div class="container">
    <form role="form" action="{{ route('mes.update', $mesInfo->messageNo ) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">

            <a>建立時間：{{$mesInfo->createTime}}</a>
            <a>最後修改時間：{{$mesInfo->updateTime}}</a>
            <a>留言人員：{{$LoggedUserInfo->userName}}</a>
        </div>
        <div style="display: none;" >
            <label for="articleNo" class="form-label">文章編號</label>
            <input class="form-control" rows="3" id="articleNo" name="articleNo" value="{{$mesInfo->articleNo}}">
            </input>
        </div>
        <div class="mb-3">
            <label class="form-label">內容</label>
            <textarea class="form-control" rows="3" id="messageContent" name="messageContent">{{$mesInfo->messageContent}}</textarea>
            <span class="text-danger">@error('messageContent'){{$message}} @enderror </span>
        </div>

        <button type="submit" class="btn btn-primary">修改</button>
    </form>
</div>
