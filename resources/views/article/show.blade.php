@include('blade.indexNav')

<!-- 文章內文 -->
<div class="container">
    <br>
    <h4>{{$artvalue->articleTitle}}</h4>
    <form role="form" action="" enctype="multipart/form-data" method="post">

        <div class="mb-3">
            <label class="form-label">作者：{{$artvalue->userNo}}</label>
            <label class="form-label">建立時間：{{$artvalue->createTime}}</label>
            <label class="form-label">更新時間：{{$artvalue->updateTime}}</label>
        </div>
        @if(!empty($artvalue->imgUrl))
        <div class="mb-3 col-3">
            <img src="{{ URL::asset("$artvalue->imgUrl")}}"
             class="img-fluid" alt="{{$artvalue->imgUrl}}">
        </div>
        @endif
        <div class="mb-3">
            <label class="form-label">內容</label>
            <br>
            <a>{{$artvalue->articleContent}}</a>
        </div>


    </form>
</div>
