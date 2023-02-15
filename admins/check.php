<?php
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'utf-8') : '';

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //select文の準備
    $stmt = $dbh->prepare('SELECT * FROM admins WHERE(
        name = :name
    )');
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $pass = $stmt->fetch();

    //ログ準備
       $fp = fopen('log.txt', 'a');

    if (password_verify($password, $pass['password_hash'])) {
        //セッションに保存
        session_start();
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_name'] = $name;

        //操作ログ（ログイン成功）
           fwrite($fp, date('Y-m-d H:i:s').": $name was Logged in.\n");
           fclose($fp);

        //index.phpに飛ぶ
        header('Location:index.php');
        exit;
    } else {

        //操作ログ(ログイン失敗)
           fwrite($fp, date('Y-m-d H:i:s').": $name was failed to logged in.\n");
           fclose($fp);

        //ログイン画面に戻る
        header('Location:login.php');
        exit;
    }