<?php
include_once "db.php";
session_start();
$uid = $_GET["uid"];
$artno = $_GET["artno"];
$msgno = $_GET["msgno"];
$loginid = $_GET["loginid"];

global $db;
$sql = $db->prepare("SELECT * FROM `message`
WHERE user_no = :loginid and article_no = :artno and message_no = :msgno");
$sql->execute(array(
    'loginid' => $loginid,
    'artno' => $artno,
    'msgno' => $msgno,
));
$row = $sql->fetch();

if ($_SESSION["user_id"] != $loginid) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>修改留言</title>
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
    <div class="container">
		<form role="form" action="mes.php?method=update&uid=<?php echo $uid ?>&loginid=<?php echo $loginid ?>&artno=<?php echo $row["article_no"] ?>&msgno=<?php echo $row["message_no"] ?>" method="post">
        	<div class="mb-3">
				<a>建立時間：<?php echo $row['create_time']; ?></a>
				<a>最後修改時間：<?php echo $row['update_time']; ?></a>
				<a>作者：
<?php
$mesuid = $row['user_no'];
global $db;
$authorsql = $db->prepare("SELECT user_name FROM `user` WHERE user_no = :mesuid");
$authorsql->execute(
    array(
        'mesuid' => $mesuid,
    ));
$authorrow = $authorsql->fetchColumn();
echo $authorrow;
?>
				</a>
			</div>

            <div class="mb-3">
            <label class="form-label">內容</label>
                <textarea class="form-control" rows="3" id="content" name="content"><?php echo $row["message_content"] ?></textarea>
            </div>

			<button type="submit" class="btn btn-primary">修改</button>
        </form>
    </div>

</body>
</html>