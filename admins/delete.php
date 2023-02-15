<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id'], ENT_QUOTES, 'utf-8') : '';

    //DB接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $stmt = $dbh->prepare('DELETE FROM contacts WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    //ログ
        $admin_name = $_SESSION['admin_name'];
        $fp = fopen('log.txt', 'a');
        fwrite($fp, date('Y-m-d H:i:s').": ID:$id was deleted.(by $admin_name)\n");
        fclose($fp);

    header('location:index.php');
