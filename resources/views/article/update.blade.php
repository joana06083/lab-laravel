@include('blade.indexNav')

<div class="container">
    <form role="form" action="art.php?method=update&uid=&artno=" method="post">
        <div class="mb-3">
            <a>建立時間：</a>
            <a>最後修改時間：</a>
            <a>作者：</a>
        </div>
        <div class="mb-3">
            <label class="form-label">標題</label>
            <textarea class="form-control" rows="3" id="title" placeholder="title" name="title"></textarea>
        </div>

        <div class="mb-3">
        <label class="form-label">內容</label>
            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">修改</button>
    </form>
</div>
