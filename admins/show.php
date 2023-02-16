<?php

    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8') : '';

    //DBへのINSERT
    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host='.getenv("MYSQL_HOST").';dbname='.getenv("MYSQL_DATABASE"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //SELECT文準備
    $stmt = $dbh->prepare('SELECT * FROM contacts WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $contact = $stmt->fetch();
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
                <li><a href="index.php">管理画面</a></li>
                <li><a href="../index.php">占いTOP</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </nav>
        <main>
            <section>
                <h2>管理画面　データ詳細</h2>
                <div class="list">
                <table>
                    <tbody>
                        <tr>
                            <th>id</th><td><?php echo $contact['id']; ?></td>
                        </tr>
                        <tr>
                            <th>マイナンバー</th><td><?php echo $contact['mynum']; ?></td>
                        </tr>
                        <tr>
                            <th>氏名</th><td><?php echo $contact['name']; ?></td>
                        </tr>
                        <tr>
                            <th>性別</th><td><?php echo $contact['gender']; ?></td>
                        </tr>
                        <tr>
                            <th>住所</th><td><?php echo $contact['addr']; ?></td>
                        </tr>
                        <tr>
                            <th>登録日時</th><td><?php echo $contact['created']; ?></td>
                        </tr>
                        <tr>
                       <th>最終更新日時</th><td><?php echo $contact['updated']; ?></td>
                        </tr>
                        <tr>
                            <th>確認</th>
                            <td>
                                <?php if ($contact['processed'] == 0): ?>
                                    未確認
                                <?php else: ?>
                                    確認済
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                        <td colspan="2">
                           <a href="index.php"><button class="btn btn-primary">一覧へ戻る</button></a>
                           <a href="edit.php?id=<?php echo $contact['id']; ?>"><button class="btn btn-info">編集</button></a>
                           <button class="delete btn btn-danger">削除</button>
                           <form method="POST" action="delete.php" id="delete_form">
                               <input type="hidden" value="<?php echo $contact['id']; ?>" id="id" name="id">
                           </form> 
                        </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </section>
        </main>
        <footer>
            <?php echo getenv("CORP_NAME"); ?>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
        $(".delete").click(function(){
            const form = document.getElementById("delete_form");
            const id = document.getElementById("id").value;
            if(confirm("ID:"+id+"番のデータを本当に削除していいですか？")){
                //OK
                form.submit();
            }else{
                //キャンセル
                return false;
            }
        })
        </script>
    </body>
</html> 