<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $message = $_POST['message'];

    //DBへのINSERT
    //PDOを使ってDBに接続
    // $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';port='.getenv("MYSQL_PORT").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させるようにする
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //insert文を実行する準備
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
    //insert文の各パラメータ（:がついてるパラメータ）にbindParamでconfirm.phpから取得した値を代入する
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':message', $message);
    //insertを実行
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple Form</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <ul>
                <!-- <li><a href="">Home</a></li>
                <li><a href="">Service</a></li>
                <li><a href="">About</a></li> -->
                <li><a href="index.php">Contact us</a></li>
            </ul>
        </nav>
        <header>
            <h1 id="main-title">Sample Web Form</h1>
        </header>
        <main>
            <section class="form-section">
                <h2>お問合せを受付ました（3/3）</h2>
                <div class="form-container">
                    <p class="thankyou-message">ありがとうございました。</p>
                    <p>以下の内容を受け取りました。</p>
                    <p><?php print_r($_POST); ?></p>
                </div>
            </section>
        </main>
        <footer>
            &copy 20xx Sample corporation.
        </footer>
    </body>
</html>