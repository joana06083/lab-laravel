
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
<form  method="post" action="/WagersRecord">
    @csrf
    <input id="gamekind" name="gamekind" type="text" value="{{$gamekind}}" style="display: none;">
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
            <option value="{{$gtl['GameType']}}">{{$gtl['GameTypeName']}}{{$gtl['GameType']}}</option>
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
        <button type="submit" class="btn btn-info"> 查詢 </button>
    </div>
</form>

<!-- 明細 -->
@if(!empty($RecordInfo))
<div class="container">
<table class="table table-hover table align-middle" style="table-layout:fixed;word-break:break-all;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">#</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    @foreach($RecordInfo as $rec)
    <tbody>
        <tr>
            <th>{{$rec['WagersID']}}</th>
            <td>{{$rec['WagersDate']}}</td>
            <td>{{$rec['SerialID']}}</td>
            <td>{{$rec['Result']}}</td>
            <td>{{$rec['BetAmount']}}</td>
            <td>{{$rec['Commissionable']}}</td>
            <td>{{$rec['Payoff']}}</td>
            <td>{{$rec['Currencyc']}}</td>
            <td>{{$rec['ExchangeRate']}}</td>
            <td>{{$rec['ModifiedDate']}}</td>
            <td>{{$rec['Origin']}}</td>
            <td>{{$rec['Star']}}</td>
            <td>{{$rec['userNo']}}</td>
        </tr>
    </tbody>
    @endforeach
    </table>
</div>
@endif
@endsection
