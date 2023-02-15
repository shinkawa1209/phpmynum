<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'utf-8') : '';

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //select文作成
    if ($keyword == '') {
        $stmt = $dbh->prepare('SELECT * FROM contacts');
    } else {
        $stmt = $dbh->prepare('SELECT * FROM contacts WHERE name like :keyword');
        $stmt->bindValue(':keyword', '%'.$keyword.'%');
    }
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $fp = fopen('contacts.csv', 'w');

    //BOMあり
    fwrite($fp, "\xEF\xBB\xBF");

    $header = ['ID', '名前', 'メールアドレス', '性別', 'お問い合わせ内容', '受付日時', '更新日時', '処理'];
    fputcsv($fp, $header);

    foreach ($contacts as $contact) {
        fputcsv($fp, $contact);
    }

    fclose($fp);

    //ログ
        $admin_name = $_SESSION['admin_name'];
        $fp = fopen('log.txt', 'a');
        fwrite($fp, date('Y-m-d H:i:s').": CSV downloaded.(by $admin_name)\n");
        fclose($fp);

    header('Location:contacts.csv');