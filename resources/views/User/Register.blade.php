@extends('Blade.Navbar')

@section('title', '註冊')

@section('loginnav')
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">註冊</div>

            <div class="card-body">
                <form method="POST" action="{{route('User.Create')}}">
                    @csrf
                    <div class="results">
                        @if(session('Success'))
                        <div class="alert alert-success">{{ session('Success') }}</div>
                        @elseif(session('Fail'))
                        <div class="alert alert-danger">{{ session('Fail') }}</div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">用戶名稱 ：</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <span class="text-danger">@error('name'){{$message}} @enderror </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email ：</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            <span class="text-danger">@error('email'){{$message}} @enderror </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="userNo" class="col-md-4 col-form-label text-md-end">帳號 ：</label>
                        <div class="col-md-6">
                            <input id="userNo" type="text" class="form-control @error('userNo') is-invalid @enderror" name="userNo" value="{{ old('userNo') }}" required autocomplete="userNo">
                            <span class="text-danger">@error('userNo'){{$message}} @enderror </span>
                        </div>
                    </div>

                    <div class="row mb-3" >
                        <label for="sex" class="col-md-4 col-form-label text-md-end">性別 ：</label>
                        <div class="form-check col-md-3" style="padding:5px 0px 0px 35px; ">
                            <input type="radio" class="form-check-input" id="sex" name="sex" value="male">
                            <label class="form-check-label" for="sex">男性</label>
                        </div>
                        <div class="form-check col-md-3" style="padding:5px 0px 0px 0px; ">
                            <input type="radio" class="form-check-input" id="sex" name="sex" value="female">
                            <label class="form-check-label" for="sex">女性</label>
                        </div>
                        <span class="text-danger">@error('sex'){{$message}} @enderror </span>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">密碼 ：</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <span class="text-danger">@error('password'){{$message}} @enderror </span>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">註冊</button>
                            <button type="reset"  value="reset" class="btn btn-outline-secondary">重置</button>
                            <a id ="character" href="Login">我已經有帳號！</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
