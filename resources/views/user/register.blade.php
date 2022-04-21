@include('blade.navbar')
@section('navbar')
<div class="container">
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="register">註冊</a>
        </li>
    </ul>

    <form role="form" action="{{route('user.create')}}" method="post" class="row g-3 needs-validation" novalidate>
    @csrf
        <div class="results">
            @if(Session::get('Success'))
                <div class="alert alert-success">
                    {{Session::get('Success')}}
                </div>
            @endif
            @if(Session::get('Fail'))
                <div class="alert alert-danger">
                    {{Session::get('Fail')}}
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="name" class="col-sm-2 col-form-label">用戶名稱 :</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="name" />
            <span class="text-danger">@error('name'){{$message}} @enderror </span>
        </div>
        <div class="mb-3">
            <label for="account" class="col-sm-2 col-form-label">帳號 :</label>
            <input type="text" class="form-control" id="account" name="account" value="{{old('account')}}" placeholder="account"/>
            <span class="text-danger">@error('account'){{$message}} @enderror </span>
        </div>
        <div class="mb-3">
            <label for="password" class="col-sm-2 col-form-label">密碼 :</label>
            <input  type="password" class="form-control" id="password" name="password" placeholder="Password"/>
            <span class="text-danger">@error('password'){{$message}} @enderror </span>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email :</label>
            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="name@example.com">
            <span class="text-danger">@error('email'){{$message}} @enderror </span>
        </div>
        <div class="mb-3">
            <label for="sex" class="col-sm-2 col-form-label">性別 :</label>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="sex" name="sex" value="male">
                <label class="form-check-label" for="sex">男性</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="sex" name="sex" value="female">
                <label class="form-check-label" for="sex">女性</label>
            </div>
            <span class="text-danger">@error('sex'){{$message}} @enderror </span>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-outline-primary">註冊</button>
            <button type="reset"  value="reset" class="btn btn-outline-secondary">重置</button>
            <a href="login">我已經有帳號！</a>
        </div>
    </form>
</div>
