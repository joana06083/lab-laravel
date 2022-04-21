@include('blade.navbar')
@section('navbar')

<div class="container">
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link" href="login">登入</a>
        </li>
    </ul>
</div>
<div class="container">
    <form role="form" action="{{route('user.check')}}" method="post" class="row g-3 needs-validation" novalidate >
    @csrf
        <div class="results">
            @if(Session::get('Fail'))
                <div class="alert alert-danger">
                    {{Session::get('Fail')}}
                </div>
            @endif
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
        <button type="submit" class="btn btn-outline-primary">登入</button>
        <a href="register">新增一個帳號！</a>
    </form>
</div>
