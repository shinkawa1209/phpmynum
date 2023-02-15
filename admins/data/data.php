<?php

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    //データの初期化
    // $delete_admins = $dbh->exec('TRUNCATE TABLE admins');
    $delete_contacts = $dbh->exec('TRUNCATE TABLE contacts');

    // //管理者データ生成
    // $admin_stmt = $dbh->prepare('INSERT INTO admins(
    //     name,
    //     password,
    //     password_hash,
    //     created,
    //     updated
    // ) values(
    //     :name,
    //     :password,
    //     :password_hash,
    //     now(),
    //     now()
    // )');

    // $admin_stmt->bindValue(':name', 'test');
    // $admin_stmt->bindValue(':password', 'test');
    // $admin_stmt->bindValue(':password_hash', password_hash('test', PASSWORD_DEFAULT));
    // $admin_stmt->execute();

    //お問い合わせのデータinsert文を実行する準備
    $genders = ['男性', '女性'];
    $contacts_stmt = $dbh->prepare('INSERT INTO contacts(
            name,
            email,
            gender,
            message,
            created
        ) values(
            :name,
            :email,
            :gender,
            :message,
            now()
        )');

    for ($i = 0; $i < 110; ++$i) {
        $name = 'user'.$i;
        $email = 'user'.$i.'@sample.com';
        $gender = $genders[rand(0, 1)];
        $message = 'user'.$i.'です。こんにちは。';

        $contacts_stmt->bindParam(':name', $name);
        $contacts_stmt->bindParam(':email', $email);
        $contacts_stmt->bindParam(':gender', $gender);
        $contacts_stmt->bindParam(':message', $message);
        $contacts_stmt->execute();
    }

echo 'データの生成が完了しました。';
echo '<a href="../../index.php">topへ</a>';