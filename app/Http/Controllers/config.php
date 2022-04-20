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
    ['account' => $acc, 'password' => $pwd] = $_POST;

    global $db;
    $sql = $db->prepare("SELECT * FROM `user` WHERE user_no = :acc && password = :pwd ");
    $sql->execute(['acc' => $acc, 'pwd' => $pwd]);
    $row = $sql->fetch();

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
    ['account' => $acc, 'password' => $pwd, 'name' => $name, 'sex' => $sex] = $_POST;

    global $db;
    $sql = $db->prepare("SELECT * FROM `user` WHERE user_no = :acc");
    $sql->execute(['acc' => $acc]);
    $row = $sql->fetch();

    if (empty($row) == false) {
        echo "<script type='text/javascript'>";
        echo "alert('此帳號已被使用 OR 已辦過帳號！');";
        echo "location.href='login.php';";
        echo "</script>";
    } else {
        try {
            global $db;
            $sql = $db->prepare("INSERT INTO `user` (user_no, password,user_name,sex) VALUES ( :acc,:pwd,:name,:sex )");
            $sql->execute(['acc' => $acc, 'pwd' => $pwd, 'name' => $name, 'sex' => $sex]);
        } catch (PDOException $e) {
            echo empty($e);
        }
        if (empty($e) == true) {
            $row = $sql->fetch();
            session_start();
            $_SESSION["user_id"] = $acc;

            echo "<script type='text/javascript'>";
            echo "alert('註冊成功!');";
            echo "location.href='index.php';";
            echo "</script>";
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('註冊失敗！請重新填寫資料!');";
            echo "location.href='signup.php';";
            echo "</script>";
        }
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
