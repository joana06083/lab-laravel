@extends('blade.navbar')

@section('title', '首頁')

@if(session('Success'))
<script type="text/javascript">
    alert("{{ session('Success') }}");
</script>
@elseif(session('Fail'))
<script type="text/javascript">
    alert("{{ session('Fail') }}");
</script>
@elseif(session('login'))
<script type="text/javascript">
    alert("{{ session('login') }}");
</script>
@endif

@section('content')
<div class="container">
    <form class="d-flex" action="/search" method="post">
    @csrf
        <input class="form-control me-2" type="search" id="search" placeholder="search" name="search"/>
        <button type="submit" class="btn btn-secondary">search</button>
    </form>
</div>
<br>
@foreach ($ArtInfo as $art)
<div class="container">
    <form role="form" action="{{ route('art.destroy', $art->articleNo)}}" method="post">
        <li>
            <label>文章標題：</label>
            <a href="{{ route('art.show', $art->articleNo)}}">{{$art->articleTitle}}</a>
            <a>作者：{{ $art->userName}}
            </a>
            <a>最後修改時間：{{$art->updateTime}}</a>
            @if(!empty($LoggedUserInfo))
                @if($art->userNo==$LoggedUserInfo->userNo)
                <a class="btn btn-primary" href="{{ route('art.edit', $art->articleNo)}}" >編輯</a>
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">刪除</button>
                @endif
            @endif
        </li>
    </form>
    <hr/>

</div>
@endforeach


<div class="col-md-12">
{{ $ArtInfo->links() }}
</div>

@endsection
