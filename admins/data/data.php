<?php

    $msg1 = 'データの生成が完了しました。';
    $msg2 = '<a href="../../index.php">topへ</a>';

    try {
            //PDOを使ってDBに接続
            $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';port='.getenv("MYSQL_PORT").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
            //エラーがある場合に表示させる
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            //データの初期化
            $delete_contacts = $dbh->exec('TRUNCATE TABLE contacts');

            //お問い合わせのデータinsert文を実行する準備
            $firstNames = ['山田', '鈴木', '田中', '吉田', '佐藤', '渡辺', '山口', '中川', '酒井', '吉本', '杉田', '武田', '平井', '川田', '黒田', '阿部', '角田', '加藤', '谷口', '金子', '笠井', '山本'];
            $lastNames = ['太郎', '次郎', '三郎', '四郎', '五郎', '六郎', '七郎', '八郎', '九郎', '一子', 'ニ子', '三子', '四子', '五子', '六子', '七子', '八子', '九子'];
            $genders = ['男性', '女性'];
            $addrs = ['東京都千代田区', '東京都豊島区', '埼玉県さいたま市', '千葉県千葉市', '大阪府大阪市', '愛知県名古屋市', '神奈川県横浜市', '広島県広島市', '福岡県博多市', '京都府京都市', '兵庫県神戸市', '北海道札幌市', '東京都中野区', '東京都練馬区'];
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
                $name = $firstNames[rand(0, count($firstNames)-1)].$lastNames[rand(0, count($lastNames)-1)];
                if (preg_match("/子/", $name)){
                    $gender = $genders[1];
                }else{
                    $gender = $genders[0];
                }
                $addr = $addrs[rand(0, count($addrs)-1)].rand(1,5).'-'.rand(1,99).'-'.rand(1,99);

                $contacts_stmt->bindParam(':mynum', $mynum);
                $contacts_stmt->bindParam(':name', $name);
                $contacts_stmt->bindParam(':gender', $gender);
                $contacts_stmt->bindParam(':addr', $addr);
                $contacts_stmt->execute();
            }

        }catch(PDOException $e){
            $msg1 = 'DB接続エラー。DBを再起動してください';
        }

echo $msg1;
echo $msg2;