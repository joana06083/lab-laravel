
@extends('blade.navbar')

@section('title', '下注紀錄查詢')

@section('loginnav')

@if(session('logout'))
<script type="text/javascript">
    alert("{{ session('logout') }}");
</script>
@endif

@section('content')
<h5>會員下注紀錄</h5>
<form  method="post" action="WagersRecord">
    @csrf
    <input id="gamekind" name="gamekind" type="text" value="{{$gamekind}}" style="display: none;">
    <input id="lang" name="lang" type="text" value="{{$lang}}"  style="display: none;">

    <div class="d-flex bd-highlight">
        <div class="flex-fill bd-highlight">
            <select class="form-select" id="action" name="action" >
                <option value="BetTime" selected>下注時間</option>
                <option value="ModifiedTime">異動時間</option>
            </select>
        </div>
        @if(!empty($GameTypeList))
        <div class="flex-fill bd-highlight">
            <select id="gametype" name="gametype" class="form-control">
            @foreach($GameTypeList as $gtl )
            <option value="{{$gtl->GameType}}">{{$gtl->GameTypeName}}{{$gtl->GameType}}</option>
            @endforeach
            </select>
        </div>
        @endif
        <div class="flex-fill bd-highlight">
            <select id="date" name="date" class="form-control">
                @foreach($DateList as $key =>$value)
                <option>{{$DateList[$key]}}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-fill bd-highlight">
            <input id="starttime" name="starttime" type="text" class="form-control" value="00:00:00" placeholder="00:00:00"/>
        </div>
        <div class="flex-fill bd-highlight">
            <input id="endtime" name="endtime" type="text" class="form-control" value="23:59:59" placeholder="23:59:59"/>
        </div>
        <button type="submit" class="btn btn-secondary"> 查詢 </button>
    </div>
</form>

<!-- 明細 -->
@if(!empty($RecordInfo))
<table class="table table-hover table align-middle" style="table-layout:fixed;word-break:break-all;">
    <thead>
        <tr>
            <th scope="col">注單號碼</th>
            <th scope="col">下注時間</th>
            <th scope="col">遊戲種類</th>
            <th scope="col">注單結果</th>
            <th scope="col">下注金額</th>
            <th scope="col">派彩金額</th>
            <th scope="col">幣別</th>
            <th scope="col">與人民幣的匯率</th>
            <th scope="col">會員有效投注額</th>
            <th scope="col">注單變更時間</th>
            <th scope="col">下單裝置</th>
            <th scope="col">連消次數</th>
            <th scope="col">帳號</th>
            <th scope="col">明細</th>
        </tr>
    </thead>
    @foreach($RecordInfo as $rec)
    <tbody>
        <tr>

        <form method="post" action="WagersRecordDetail">
            @csrf
            <input id="gamekind" name="gamekind" type="text" value="{{$gamekind}}" style="display: none;">
            <input id="lang" name="lang" type="text" value="{{$lang}}"  style="display: none;">
            <input id="username" name="username" type="text" value="{{$LoggedUserInfo->userNo}}"  style="display: none;">
            <input id="wagersid" name="wagersid" type="text" value="{{$rec['WagersID']}}"  style="display: none;">
            <input id="gametype" name="gametype" type="text" value="{{$rec['GameType']}}"  style="display: none;">

            <th>{{$rec['WagersID']}}</a></th>
            <td>{{$rec['WagersDate']}}</td>
            <td>{{$rec['GameType']}}</td>
            <td>{{$rec['Result']}}</td>
            <td>{{$rec['BetAmount']}}</td>
            <td>{{$rec['Payoff']}}</td>
            <td>{{$rec['Currency']}}</td>
            <td>{{$rec['ExchangeRate']}}</td>
            <td>{{$rec['Commissionable']}}</td>
            <td>{{$rec['ModifiedDate']}}</td>
            <td>{{$rec['Origin']}}</td>
            <td>{{$rec['Star']}}</td>
            <td>{{$rec['userNo']}}</td>
            <td><button type="submit" class="btn btn-secondary">明細</button></td>
        </form>
        </tr>
    </tbody>
    @endforeach
</table>

@endif
@endsection
