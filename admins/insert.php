<?php

    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'utf-8') : '';
    $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender'], ENT_QUOTES, 'utf-8') : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'utf-8') : '';

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $stmt = $dbh->prepare('insert into contacts(
        name,
        email,
        gender,
        message
    ) values(
        :name,
        :email,
        :gender,
        :message
    )');
    //bindParamで各パラメータにconfirm.phpから取得した値を代入する
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':message', $message);
    //insertを実行
    $stmt->execute();

    //ログ
    $last_id = $dbh->lastInsertId();
    $admin_name = $_SESSION['admin_name'];
    $fp = fopen('log.txt', 'a');
    fwrite($fp, date('Y-m-d H:i:s').": ID:$last_id was created!(by $admin_name)\n");
    fclose($fp);

    header('Location:index.php');