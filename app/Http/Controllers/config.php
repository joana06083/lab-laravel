<?php
include_once "db.php";
switch ($_GET["method"]) {
    case "login":
        login();
        break;
    case "signup":
        signup();
        break;
    case "logout":
        logout();
        break;
    default:
        break;
}

//登入
function login()
{
    $acc = $_POST["account"];
    $pwd = $_POST["password"];
    global $db;
    $sql = $db->prepare("SELECT * FROM `user` WHERE user_no = :acc && password = :pwd ");
    $sql->execute(array(
        'acc' => $acc,
        'pwd' => $pwd,
    ));
    $row = $sql->fetch();
    print_r($row);
    echo $row['user_no'];
    if ($row == "") {
        echo "<script type='text/javascript'>";
        echo "alert('帳密錯誤');";
        echo "location.href='login.php';";
        echo "</script>";
    } else {
        session_start();
        $_SESSION["user_id"] = $row['user_no'];
        echo "<script type='text/javascript'>";
        echo "alert('登入成功');";
        echo "location.href='index.php';";
        echo "</script>";
    }
}

//註冊
function signup()
{
    $acc = $_POST["account"];
    $pwd = $_POST["password"];
    $name = $_POST["name"];
    $sex = $_POST["sex"];

    global $db;
    $sql = $db->prepare("SELECT * FROM `user` WHERE user_no = :acc");
    $sql->execute(array(
        'acc' => $acc,
    ));
    $row = $sql->fetch();

    if (empty($row) == false) {
        echo "<script type='text/javascript'>";
        echo "alert('已經辦過帳號囉');";
        echo "location.href='login.php';";
        echo "</script>";
    } else {
        global $db;
        $sql = $db->prepare("INSERT INTO `user` (user_no, password,user_name,sex)
            VALUES ( :acc,:pwd,:name,:sex )");
        $sql->execute(array(
            'acc' => $acc,
            'pwd' => $pwd,
            'name' => $name,
            'sex' => $sex,
        ));

        $sql = $db->prepare("SELECT * FROM `user` WHERE user_no = :acc && password = :pwd ");
        $sql->execute(array(
            'acc' => $acc,
            'pwd' => $pwd,
        ));
        $row = $sql->fetch();

        session_start();
        $_SESSION["user_id"] = $row['user_no'];
        echo "<script type='text/javascript'>";
        echo "alert('註冊成功');";
        echo "location.href='index.php';";
        echo "</script>";
    }
}

//登出
function logout()
{
    session_start();
    if (isset($_SESSION["user_id"])) {
        session_unset();
        echo "<script type='text/javascript'>";
        echo "alert('登出成功');";
        echo "location.href='index.php';";
        echo "</script>";
    }
}
