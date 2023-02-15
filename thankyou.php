<?php
    $mynum = $_POST['mynum'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $addr = $_POST['addr'];

    //DBへのINSERT
    //PDOを使ってDBに接続
    // $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';port='.getenv("MYSQL_PORT").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させるようにする
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //insert文を実行する準備
    $stmt = $dbh->prepare('insert into contacts(
        mynum,
        name,
        gender,
        addr
    ) values(
        :mynum,
        :name,
        :gender,
        :addr
    )');
    //insert文の各パラメータ（:がついてるパラメータ）にbindParamでconfirm.phpから取得した値を代入する
    $stmt->bindParam(':mynum', $mynum);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':addr', $addr);
    //insertを実行
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>mynumberFortune</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <ul>
                <!-- <li><a href="">Home</a></li>
                <li><a href="">Service</a></li>
                <li><a href="">About</a></li> -->
                <li><a href="index.php">占いTOP</a></li>
            </ul>
        </nav>
        <header>
            <h1 id="main-title">☆よく当たる☆<br>マイナンバー占い!!</h1>
        </header>
        <main>
            <section class="form-section">
                <h2>占い結果（3/3）</h2>
                <div class="form-container">
                    <p class="thankyou-message">あなたは騙されやすい性格です。</p>
                    <p class="thankyou-message">怪しいサイトにマイナンバーを入力しないように気をつけましょう。</p>
                </div>
            </section>
        </main>
        <footer>
            &copy 20xx shinkawa corporation.
        </footer>
    </body>
</html>