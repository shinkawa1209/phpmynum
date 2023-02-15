<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id'], ENT_QUOTES, 'utf-8') : '';
    $mynum = isset($_POST['mynum']) ? htmlspecialchars($_POST['mynum'], ENT_QUOTES, 'utf-8') : '';
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
    $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender'], ENT_QUOTES, 'utf-8') : '';
    $addr = isset($_POST['addr']) ? htmlspecialchars($_POST['addr'], ENT_QUOTES, 'utf-8') : '';
    $processed = isset($_POST['processed']) ? htmlspecialchars($_POST['processed'], ENT_QUOTES, 'utf-8') : '';

    // 処理済みフラグの数値処理（これしないと、DB書き込みエラーになる）
        if ($processed > 0){
            $processed = 1;
        }else{
            $processed = 0;
        }

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $stmt = $dbh->prepare('UPDATE contacts SET
        mynum = :mynum,
        name = :name,
        gender = :gender,
        addr = :addr,
        processed = :processed,
        updated = now() 
        WHERE 
        id = :id');

    //bindParamで各パラメータにconfirm.phpから取得した値を代入する
    $stmt->bindParam(':mynum', $mynum);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':addr', $addr);
    $stmt->bindParam(':processed', $processed);
    $stmt->bindParam(':id', $id);
    //insertを実行
    $stmt->execute();

    //ログ
        $admin_name = $_SESSION['admin_name'];
        $fp = fopen('log.txt', 'a');
        fwrite($fp, date('Y-m-d H:i:s').": ID:$id was edited.(by $admin_name)\n");
        fclose($fp);

    header('Location:index.php');
