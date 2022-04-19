@include('blade.navbar')
@section('navbar')
<div class="container">
    <form role="form" action="config.php?method=login" method="post" class="row g-3 needs-validation" novalidate >
        <div  class="row mb-3">
            <label for="account" class="col-sm-2 col-form-label">帳號 :</label>
            <input type="text" class="form-control" id="account" placeholder="account" name="account" />
            <div class="invalid-feedback">
                Please input a account.
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">密碼 :</label>
            <input  type="password" class="form-control" id="password" placeholder="Password" name="password">
            <div class="invalid-feedback">
                Please input a password.
            </div>
        </div>
        <button type="submit" name="login" value="login" class="btn btn-outline-primary">登入</button>
    </form>
</div>
