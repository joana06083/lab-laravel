@include('blade.indexNav')
<br>

@if(Session::get('addSuccess'))
<script type="text/javascript">
alert("文章新增成功！");
</script>
@elseif(Session::get('modifySuccess'))
<script type="text/javascript">
alert("文章修改成功！");
</script>
@elseif(Session::get('delSuccess'))
<script type="text/javascript">
alert("文章刪除成功！");
</script>
@endif
@foreach ($ArtInfo as $art)

<div class="container">

    <form role="form" action="{{ route('art.destroy', $art->articleNo)}}" method="post">
        <li>
            <label>文章標題：</label>
            <a href="{{ route('art.show', $art->articleNo)}}" style="text-decoration: none;">{{$art->articleTitle}}</a>
            <a>作者：{{$art->userNo}}</a>
            <a>最後修改時間：{{$art->updateTime}}</a>
            @if($art->userNo==$LoggedUserInfo->userNo)
            <a class="btn btn-primary" href="{{ route('art.edit', $art->articleNo)}}" style="text-decoration: none;">編輯</a>
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">刪除</button>
            @endif
        </li>
    </form>

    <hr/>
</div>
@endforeach
