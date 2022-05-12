
@extends('blade.navbar')

@section('title', '轉帳')

@section('loginnav')

@if(session('logout'))
<script type="text/javascript">
    alert("{{ session('logout') }}");
</script>
@endif

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">轉帳</div>

            <div class="card-body">
                <form method="POST" action="/transfer">
                    @csrf
                    <div class="results">
                        @if(session('Success'))
                        <div class="alert alert-success">{{ session('Success') }}</div>
                        @elseif(session('Fail'))
                        <div class="alert alert-danger">{{ session('Fail') }}</div>
                        @endif
                    </div>
                    <div style="display: none;">
                        <input id="website" name="website" type="text" value="bbinbgp" readonly="true">
                        <input id="uppername" name="uppername" type="text" value="dpidtest" readonly="true">
                    </div>
                    <div class="row mb-3">
                        <label for="account" class="col-md-4 col-form-label text-md-end">帳號 ：</label>
                        <div class="col-md-6">
                            <input id="account" name="account" type="text" class="form-control"  value="{{$LoggedUserInfo->userNo}}" readonly="true">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="account" class="col-md-4 col-form-label text-md-end">轉帳 ：</label>
                        <div class="col-md-6">
                            <select class="form-select" id="action" name="action" >
                                <option value="IN" selected>轉入</option>
                                <option value="OUT">轉出</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="remit" class="col-md-4 col-form-label text-md-end">額度 ：</label>
                        <div class="col-md-6">
                            <input id="remit" name="remit" type="text" class="form-control" placeholder="請輸入正數，支援至小數點後四位">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">存入/提出額度</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
