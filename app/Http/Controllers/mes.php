<?php
include_once "db.php";
session_start();
echo $_GET["method"];

switch ($_GET["method"]) {
    case "add":
        add();
        break;
    case "update":
        update();
        break;
    case "del":
        del();
        break;
    default:
        break;
}

//add
function add()
{
    ['uid' => $uid, 'loginid' => $loginid, 'artno' => $artno] = $_GET;
    ['content' => $content] = $_POST;
    $msgno = date('YmdHis', time());

    global $db;
    if ($uid != $loginid) {
        $sql = $db->prepare("INSERT INTO `message` (message_no, message_content,user_no,article_no)
            VALUES (:msgno , :content,:loginid,:artno)");
        $sql->execute(['msgno' => $msgno, 'content' => $content, 'loginid' => $loginid, 'artno' => $artno]);
    } else {
        $sql = $db->prepare("INSERT INTO `message` (message_no, message_content,user_no,article_no)
            VALUES (:msgno , :content,:uid,:artno)");
        $sql->execute(['msgno' => $msgno, 'content' => $content, 'uid' => $uid, 'artno' => $artno]);
    }

    echo "<script type='text/javascript'>";
    echo "alert('新增留言成功');";
    echo "location.href='art_index.php?uid=" . $uid . "&artno=" . $artno . "&loginid=" . $loginid . "'";
    echo "</script>";
}

//update
function update()
{
    ['uid' => $uid, 'loginid' => $loginid, 'artno' => $artno, 'msgno' => $msgno] = $_GET;
    ['content' => $content] = $_POST;

    global $db;
    if ($uid != $loginid) {
        $sql = $db->prepare("UPDATE `message` SET  message_content = :content
        WHERE user_no = :loginid and article_no = :artno and message_no = :msgno ");
        $sql->execute(['content' => $content, 'loginid' => $loginid, 'artno' => $artno, 'msgno' => $msgno]);

    } else {
        $sql = $db->prepare("UPDATE `message` SET  message_content = :content
        WHERE user_no = :uid and article_no = :artno and message_no = :msgno ");
        $sql->execute(['content' => $content, 'uid' => $uid, 'artno' => $artno, 'msgno' => $msgno]);
    }

    echo "<script type='text/javascript'>";
    echo "alert('編輯留言成功');";
    echo "location.href='art_index.php?uid=" . $uid . "&artno=" . $artno . "&loginid=" . $loginid . "'";
    echo "</script>";
}

//delete
function del()
{
    ['uid' => $uid, 'loginid' => $loginid, 'artno' => $artno, 'msgno' => $msgno] = $_GET;

    global $db;
    $sql = $db->prepare("DELETE FROM `message`
    WHERE user_no = :loginid and article_no = :artno and message_no = :msgno");
    $sql->execute(['loginid' => $loginid, 'artno' => $artno, 'msgno' => $msgno]);

    echo "<script type='text/javascript'>";
    echo "alert('刪除留言成功');";
    echo "location.href='art_index.php?uid=" . $uid . "&artno=" . $artno . "&loginid=" . $loginid . "'";
    echo "</script>";
}
