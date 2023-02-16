<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'utf-8') : '';

    try {
        //PDOを使ってDBに接続
        $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';port='.getenv("MYSQL_PORT").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
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
    }catch(PDOException $e){
        echo 'DB接続エラー';
        echo '<a href="index.php">topへ</a>';
    }

    $fp = fopen('contacts.csv', 'w');

    //BOMあり
    fwrite($fp, "\xEF\xBB\xBF");

    $header = ['ID', 'マイナンバー', '氏名', '性別', '住所', '登録日時', '更新日時', '確認'];
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