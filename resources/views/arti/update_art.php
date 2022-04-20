<?php
include_once "db.php";
session_start();
['uid' => $uid, 'artno' => $artno] = $_GET;

global $db;
$sql = $db->prepare("SELECT * FROM `article` WHERE user_no = :uid and article_no = :artno");
$sql->execute(['uid' => $uid, 'artno' => $artno]);
$row = $sql->fetch();

if ($_SESSION["user_id"] != $row['user_no']) {
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
    <title>修改文章</title>
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
$usql = $db->prepare("SELECT user_name FROM `user` WHERE user_no = :uid");
$usql->execute(['uid' => $uid]);
$urow = $usql->fetchColumn();
echo $urow;
?>
                </label>
                <a href="config.php?method=logout">登出</a>
            </div>
        </div>
    </nav>
    <div class="container">
		<form role="form" action="art.php?method=update&uid=<?php echo $row["user_no"] ?>&artno=<?php echo $row["article_no"] ?>" method="post">
        	<div class="mb-3">
				<a>建立時間：<?php echo $row['create_time']; ?></a>
				<a>最後修改時間：<?php echo $row['update_time']; ?></a>
				<a>作者：
<?php
$artuid = $row['user_no'];
global $db;
$authorsql = $db->prepare("SELECT user_name FROM `user` WHERE user_no = :artuid");
$authorsql->execute(['artuid' => $artuid]);
$authorrow = $authorsql->fetchColumn();
echo $authorrow;
?>
				</a>
			</div>
			<div class="mb-3">
                <label class="form-label">標題</label>
                <textarea class="form-control" rows="3" id="title" placeholder="title" name="title"><?php echo $row["article_title"] ?></textarea>
            </div>

            <div class="mb-3">
            <label class="form-label">內容</label>
                <textarea class="form-control" rows="3" id="content" name="content"><?php echo $row["article_content"] ?></textarea>
            </div>

			<button type="submit" class="btn btn-primary">修改</button>
        </form>
    </div>

</body>
</html>