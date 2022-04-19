@include('blade.navbar')
@section('navbar')
<div class="container">
<form role="form" action="config.php?method=signup" method="post" class="row g-3 needs-validation" novalidate>
    <div  class="row mb-3">
    <!--
        @{{ '123' }}：blade 不執行 echo，直接顯示 @ 符號後的內容。
        {{ '<h1>333</h1>' }}：HTML有效的輸出。
     -->
    <label for="account" class="col-sm-2 col-form-label">帳號 :</label>
    <input type="text" class="form-control" id="account" placeholder="account" name="account" />
    </div>
    <div class="row mb-3">
    <label for="password" class="col-sm-2 col-form-label">密碼 :</label>
    <input  type="password" class="form-control" id="password" placeholder="Password" name="password">
    </div>
    <div  class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">暱稱 :</label>
            <input type="text" class="form-control" id="name" placeholder="name" name="name" />
        </div>
        <div  class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">性別 :</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="sex" name="sex" value="male">
            <label class="form-check-label" for="sex">男性</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="sex" name="sex" value="female">
            <label class="form-check-label" for="sex">女性</label>
        </div>
        <div>
            <button type="submit" name="submit" value="signup" class="btn btn-outline-primary">註冊</button>
            <button type="reset"  name="reset" value="reset" class="btn btn-outline-secondary">重置</button>
        </div>
    </form>
</div>
