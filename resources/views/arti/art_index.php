<?php
include_once "db.php";
session_start();
$uid = $_GET["uid"];
if (empty($_SESSION["user_id"]) == false) {
    $loginid = $_GET["loginid"];
} else {
    $loginid = $_GET["uid"];
}
$artno = $_GET["artno"];

$sql = $db->prepare("SELECT * FROM `article` WHERE user_no = :uid and article_no = :artno");
$sql->execute(array(
    'uid' => $uid,
    'artno' => $artno,
));
$row = $sql->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title><?php echo $row['article_title']; ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" href="index.php" style="color:blue;">Home</a>
                    </li>
                </ul>
                <label>Hi!
<?php
global $db;
$usql = $db->prepare("SELECT user_name FROM `user` WHERE user_no = :loginid");
$usql->execute(array(
    'loginid' => $loginid,
));
$urow = $usql->fetchColumn();
echo $urow;
?>
                </label>
                <a href="config.php?method=logout">登出</a>
            </div>
        </div>
    </nav>
    <!-- 文章內文 -->
    <div class="container">
        <img src="<?php echo $row["imgurl"] ?>" class="img-fluid" alt="<?php echo $row["imgurl"] ?>">
		<form role="form" action="art.php?method=update&uid=<?php echo $row["user_no"] ?>&artno=<?php echo $row["article_no"] ?>" method="post">
        <div class="mb-3">
            <label class="form-label">標題 :</label><?php echo $row["article_title"] ?>
        </div>
        <div class="mb-3">
				<a>建立時間：<?php echo $row['create_time']; ?></a>
				<a>最後修改時間：<?php echo $row['update_time']; ?></a>
				<a>作者：
<?php
global $db;
$authorsql = $db->prepare("SELECT user_name FROM `user` WHERE user_no = :uid");
$authorsql->execute(array(
    'uid' => $uid,
));
$authorrow = $authorsql->fetchColumn();
echo $authorrow;
?>
				</a>
			</div>
            <div class="mb-3">
            <label class="form-label">內容</label>
            <br>
                <?php echo $row["article_content"] ?>
            </div>
        </form>


    <!-- 新增留言 -->

    <form role="form" action="mes.php?method=add&uid=<?php echo $uid ?>&loginid=<?php echo $loginid ?>&artno=<?php echo $row["article_no"] ?>" method="post">
        <div class="mb-3">
        <label for="content" class="form-label">留言內容</label>
            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">新增</button>
    </form>



    <hr/>
    <!-- 留言內容 -->
    <?php
$messql = $db->prepare("SELECT * FROM `message` WHERE article_no = :artno");
$messql->execute(array(
    'artno' => $artno,
));
$mesrow = $messql->fetchAll();

foreach ($mesrow as $mesarr) {

    ?>
    <div>
        <a>留言者：
<?php
$mesuid = $mesarr["user_no"];
    global $db;
    $sql = $db->prepare("SELECT user_name FROM `user` WHERE user_no = :mesuid");
    $sql->execute(array(
        'mesuid' => $mesuid,
    ));
    $row = $sql->fetchColumn();
    echo $row;

    ?>
        </a>
        <a>最後修改時間：<?php echo $mesarr['update_time']; ?></a>
        <?php if (@$_SESSION["user_id"] === $mesarr['user_no']) {?>
            <a href="update_mes.php?uid=<?php echo $uid ?>&loginid=<?php echo $loginid ?>&artno=<?php echo $mesarr["article_no"] ?>&msgno=<?php echo $mesarr["message_no"] ?>">編輯</a>
            <a href="mes.php?method=del&uid=<?php echo $uid ?>&loginid=<?php echo $loginid ?>&artno=<?php echo $mesarr["article_no"] ?>&msgno=<?php echo $mesarr["message_no"] ?>">刪除</a>
        <?php }?>
    </div>
    <div>
        <a>留言內容 ：<?php echo $mesarr['message_content']; ?></a>
    </div>
    <hr/>

    <?php }?>
    <!-- end -->
    </div>
</body>
</html>