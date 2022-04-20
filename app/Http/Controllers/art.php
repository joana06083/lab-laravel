<?php
include_once "db.php";
session_start();
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

//img
function img()
{
    //限制圖片型別格式，大小
    if ((($_FILES["profile_pic"]["type"] == "image/png")
        || ($_FILES["profile_pic"]["type"] == "image/jpeg")
        || ($_FILES["profile_pic"]["type"] == "image/jpg"))
        && ($_FILES["profile_pic"]["size"] < 200000)) {
        if ($_FILES["profile_pic"]["error"] > 0) {
            echo "Return Code: " . $_FILES["profile_pic"]["error"] . "<br />";
        } else {
            echo "檔名: " . $_FILES["profile_pic"]["name"] . "<br />";
            echo "檔案型別: " . $_FILES["profile_pic"]["type"] . "<br />";
            echo "檔案大小: " . ($_FILES["profile_pic"]["size"] / 1024) . " Kb<br />";
            echo "快取檔案: " . $_FILES["profile_pic"]["tmp_name"] . "<br />";

            //設定檔案上傳路徑，選擇指定資料夾
            if (file_exists("../lab/upload/" . $_FILES["profile_pic"]["name"])) {
                echo $_FILES["profile_pic"]["name"] . " already exists. ";
            } else {
                echo "遷移圖檔";
                move_uploaded_file(
                    $_FILES["profile_pic"]["tmp_name"],
                    "../lab/upload/" . $_FILES["profile_pic"]["name"]
                );
                echo "儲存於: " . "../lab/upload/" . $_FILES["profile_pic"]["name"]; //上傳成功後提示上傳資訊
            }
        }
    } else {
        echo "上傳失敗！"; //上傳失敗後顯示錯誤資訊
    }

}
//add
function add()
{
    $uid = $_SESSION["user_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $artno = date('YmdHis', time());

    //定義變數，儲存檔案上傳路徑
    img();
    if ($_FILES["profile_pic"]["name"] != "") {
        $imgurl = "../lab/upload/" . $_FILES["profile_pic"]["name"];
    } else {
        $imgurl = null;
    }

    global $db;
    $sql = $db->prepare("INSERT INTO `article` (article_no, article_title, article_content,user_no,imgurl)
        VALUES (:artno , :title , :content , :uid , :imgurl )");
    $sql->execute(array(
        'artno' => $artno,
        'title' => $title,
        'content' => $content,
        'uid' => $uid,
        'imgurl' => $imgurl,
    ));

    echo "<script type='text/javascript'>";
    echo "alert('新增文章成功');";
    echo "location.href='index.php';";
    echo "</script>";
}

//update
function update()
{
    $uid = $_GET["uid"];
    $artno = $_GET["artno"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    global $db;
    $sql = $db->prepare("UPDATE `article`
    SET article_title = :title, article_content = :content
    WHERE user_no = :uid and article_no = :artno ");
    $sql->execute(array(
        'title' => $title,
        'content' => $content,
        'uid' => $uid,
        'artno' => $artno,
    ));
    echo "<script type='text/javascript'>";
    echo "alert('編輯文章成功');";
    echo "location.href='index.php';";
    echo "</script>";
}

//delete
function del()
{
    $uid = $_GET["uid"];
    $artno = $_GET["artno"];

    global $db;
    $sql = $db->prepare("DELETE FROM `article` WHERE user_no = :uid and article_no = :artno");
    $sql->execute(array(
        'uid' => $uid,
        'artno' => $artno,
    ));
    echo "<script type='text/javascript'>";
    echo "alert('刪除文章成功');";
    echo "location.href='index.php';";
    echo "</script>";
}
