<?php

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    //データの初期化
    $delete_contacts = $dbh->exec('TRUNCATE TABLE contacts');

    //お問い合わせのデータinsert文を実行する準備
    $names = ['山田太郎', '鈴木次郎', '田中三郎', '吉田四郎', '佐藤五郎', '渡辺六郎', '山口七郎', '中川八郎', '酒井九郎', '吉本一子', '杉田ニ美', '武田三子'];
    $genders = ['男性', '女性'];
    $addrs = ['東京都千代田区', '東京都豊島区', '埼玉県さいたま市', '千葉県千葉市', '大阪府大阪市', '愛知県名古屋市', '神奈川県横浜市', '広島県広島市', '福岡県博多市', '京都府京都市', '兵庫県神戸市', '北海道札幌市'];
    $contacts_stmt = $dbh->prepare('INSERT INTO contacts(
            mynum,
            name,
            gender,
            addr,
            created
        ) values(
            :mynum,
            :name,
            :gender,
            :addr,
            now()
        )');

    for ($i = 0; $i < 110; ++$i) {
        $mynum = rand(100000000000, 999999999999);
        $name = $names[rand(0, 11)];
        $gender = $genders[rand(0, 1)];
        $addr = $addrs[rand(0, 11)];

        $contacts_stmt->bindParam(':mynum', $mynum);
        $contacts_stmt->bindParam(':name', $name);
        $contacts_stmt->bindParam(':gender', $gender);
        $contacts_stmt->bindParam(':addr', $addr);
        $contacts_stmt->execute();
    }

echo 'データの生成が完了しました。';
echo '<a href="../../index.php">topへ</a>';