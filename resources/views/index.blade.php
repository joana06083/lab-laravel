
@include('blade.indexNav')

<div class="container">
    <ul class="nav justify-content">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="art/create">新增文章</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="art/edit">更新文章</a>
        </li>
    </ul>
</div>
@foreach ($ArtInfo as $art)
<div class="container">
    <ol>
        <li><a href="">文章標題：{{$art->articleTitle}}</a></li>
        <li><a>作者：{{$art->userNo}}</a></li>
        <li><a>最後修改時間：{{$art->updateTime}}</a></li>
        <li><a href="">編輯</a></li>
        <li><a href="">刪除</a></li>
    </ol>
    <hr/>
</div>
@endforeach
