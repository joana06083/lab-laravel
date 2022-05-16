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
<!-- 選擇遊戲類型/語言 -->
<h5>選擇遊戲類型/語言</h5>
<form  method="post" action="search">
    @csrf
<div class="d-flex bd-highlight">
    <div class="flex-fill bd-highlight">
        <select class="form-select" id="gamekind" name="gamekind">
            <option value="3" selected>BB視訊</option>
            <option value="5">BB電子</option>
            <option value="12">BB彩票</option>
            <option value="30">BB捕魚達人</option>
            <option value="31">New BB體育</option>
            <option value="38">BB捕魚大師</option>
            <option value="66">BB棋牌</option>
            <option value="73">XBB彩票</option>
            <option value="75">XBB視訊</option>
            <option value="76">XBB電子</option>
            <option value="93">NBB區塊鏈</option>
            <option value="107">BBP電子</option>
            <option value="109">BB體育</option>
        </select>
    </div>
    <div class="flex-fill bd-highlight">
        <select class="form-select" id="lang" name="lang" >
            <option value="zh-cn">简体中文</option>
            <option value="zh-tw" selected>繁體中文</option>
            <option value="en-us">English</option>
            <option value="euc-jp">日語</option>
            <option value="ko">한국인</option>
            <option value="th">ไทย</option>
            <option value="vi">Tiếng Việt</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">查詢</button>
</div>
</form>

<!-- 取得明細 -->
<form  method="post" action="WagersRecordIndex">
    @csrf
<div class="d-flex bd-highlight">
    <div class="flex-fill bd-highlight">
        <select class="form-select" id="gamekind" name="gamekind">
            <option value="3" selected>BB視訊</option>
            <option value="5">BB電子</option>
            <option value="12">BB彩票</option>
            <option value="30">BB捕魚達人</option>
            <option value="31">New BB體育</option>
            <option value="38">BB捕魚大師</option>
            <option value="66">BB棋牌</option>
            <option value="73">XBB彩票</option>
            <option value="75">XBB視訊</option>
            <option value="76">XBB電子</option>
            <option value="93">NBB區塊鏈</option>
            <option value="107">BBP電子</option>
            <option value="109">BB體育</option>
        </select>
    </div>
    <div class="flex-fill bd-highlight">
        <select class="form-select" id="lang" name="lang" >
            <option value="zh-cn">简体中文</option>
            <option value="zh-tw" selected>繁體中文</option>
            <option value="en-us">English</option>
            <option value="euc-jp">日語</option>
            <option value="ko">한국인</option>
            <option value="th">ไทย</option>
            <option value="vi">Tiếng Việt</option>
        </select>
    </div>
    <button type="submit" class="btn btn-danger">下注紀錄查詢</button>
</div>
</form>
@if(!empty($GameTypeList))
<br>
<div class="row">
@foreach($GameTypeList as $gtl )
  <div class="col-sm-3 mb-3">
    <div class="card">
        <div class="card-body">
            <form role="form" action="/GameIndex" method="post">
            @csrf
                <h6 class="card-title">遊戲名稱： {{$gtl['GameTypeName']}}</h6>
                <input id="gamekind" name="gamekind" type="text" value="{{$gamekind}}" style="display: none;">
                <input id="SessionID" name="SessionID" type="text" value="{{$ApiData}}" style="display: none;">
                <input id="GameType" name="GameType" type="text" value="{{$gtl['GameType']}}" style="display: none;">
                <select class="form-select" id="lang" name="lang" >
                    <option value="zh-cn">简体中文</option>
                    <option selected value="zh-tw">繁體中文</option>
                    <option value="en-us">English</option>
                    <option value="euc-jp">日語</option>
                    <option value="ko">한국인</option>
                    <option value="th">ไทย</option>
                    <option value="vi">Tiếng Việt</option>
                </select>
                <div class="card text-center">
                    <button type="submit" class="btn btn-primary">進入遊戲</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  @endforeach
</div>
@endif

@endsection
