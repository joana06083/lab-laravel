@extends('blade.navbar')

@section('title', '登入')

@section('loginnav')
@stop

@if(session('logout'))
<script type="text/javascript">
    alert("{{ session('logout') }}");
</script>
@endif

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">登入</div>

            <div class="card-body">
                <form method="POST" action="{{route('user.check')}}">
                    @csrf
                    <div class="results">
                        @if(session('Fail'))
                        <div class="alert alert-danger">
                            {{ session('Fail') }}
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <label for="account" class="col-md-4 col-form-label text-md-end">帳號 ：</label>

                        <div class="col-md-6">
                            <input id="account" type="text" class="form-control @error('account') is-invalid @enderror" name="account" value="{{ old('account') }}" required autocomplete="account" autofocus>
                            <span class="text-danger">@error('account'){{$message}} @enderror </span>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">密碼 ：</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <span class="text-danger">@error('password'){{$message}} @enderror </span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">登入</button>
                            <a id ="character" href="register">新增一個帳號！</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
