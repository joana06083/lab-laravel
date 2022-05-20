
@extends('blade.navbar')

@section('title', '轉帳')

@section('loginnav')

@if(session('Success'))
<script type="text/javascript">
    alert("{{ session('Success') }}");
</script>
@elseif(session('Fail'))
<script type="text/javascript">
    alert("{{ session('Fail') }}");
</script>
@elseif(session('logout'))
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
                <form method="POST" action="/Transfer">
                    @csrf
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
                            <input id="remit" name="remit" type="text" class="form-control @error('remit') is-invalid @enderror" placeholder="請輸入正數，支援至小數點後四位" required autocomplete="remit" autofocus>
                            <span class="text-danger">@error('remit'){{$message}} @enderror </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-7 offset-md-5">
                            <button type="submit" class="btn btn-primary">存入/提出額度</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
