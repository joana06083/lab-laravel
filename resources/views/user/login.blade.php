@include('blade.navbar')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">登入</div>

                <div class="card-body">
                    <form method="POST" action="{{route('user.check')}}">
                        @csrf
                        <div class="results">
                            @if(Session::get('Fail'))
                                <div class="alert alert-danger">
                                    {{Session::get('Fail')}}
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3">
                            <label for="account" class="col-md-4 col-form-label text-md-end">帳號 ：</label>

                            <div class="col-md-6">
                                <input id="account" type="text" class="form-control @error('email') is-invalid @enderror" name="account" value="{{ old('account') }}" required autocomplete="account" autofocus>
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

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    登入
                                </button>

                                <a href="register" class="btn btn-link" style="text-decoration: none;">
                                    新增一個帳號！
                                </a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
