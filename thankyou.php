<?php
    $mynum = $_POST['mynum'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $addr = $_POST['addr'];

    $msg1 = "あなたは騙されやすい性格です。";
    $msg2 = "怪しいサイトにマイナンバーを入力しないように気をつけましょう。";

    //DBへのINSERT
    //PDOを使ってDBに接続

    try {
            $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';port='.getenv("MYSQL_PORT").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
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
        }catch(PDOException $e){
            //エラー出力
            $msg1 = "データベースエラー（PDOエラー）";
            $msg2 = "データベースを見直してください";
            //var_dump($e->getMessage());    //エラーの詳細を調べる場合、コメントアウトを外す
        }

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo getenv("SITE_TITLE"); ?></title>
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
            <h1 id="main-title"><?php echo getenv("PAGE_TITLE"); ?></h1>
        </header>
        <main>
            <section class="form-section">
                <h2>占い結果（3/3）</h2>
                <div class="form-container">
                    <p class="thankyou-message"><?php echo $msg1; ?></p>
                    <p class="thankyou-message"><?php echo $msg2; ?></p>
                </div>
            </section>
        </main>
        <footer>
        <?php echo getenv("CORP_NAME"); ?>
        </footer>
    </body>
</html>