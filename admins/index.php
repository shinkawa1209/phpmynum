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

        //ページング設定///////////////////////////////////////
        //1. 何件ずつ表示させるか（固定。今回は10件ずつ）
        $rows = 10;

         //2. 現在表示しているページ数（GETで取得。初回など送られてこなければ1を設定する）
        $page = isset($_GET['page']) ? htmlspecialchars($_GET['page'], ENT_QUOTES, 'utf-8') : 1;

          //3. 表示するページに応じたレコード取得開始位置（2ページ目の場合は、10件目から表示なので、10*(2-1)で$offset=10が入る）
        $offset = $rows * ($page - 1);

         //4. 全件のレコード数。
         if ($keyword == '') {
        //queryで実行し、fetchColumn()で取得したcountを返す。
            $all_rows = $dbh->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
            } else {
                   //検索条件を考慮
                   $all_rows_stmt = $dbh->prepare('SELECT * FROM contacts WHERE name like :keyword');
                   $all_rows_stmt->bindValue(':keyword', '%'.$keyword.'%');
                   $all_rows_stmt->execute();
                   //取得したcountを返す。
                   $all_rows = $all_rows_stmt->rowCount();
            }

         //5.  全件を10件ずつ表示させた場合のページ数。全件÷表示件数をして、0以下の場合は、ページ数は1に固定。
        if ((int) ($all_rows / $rows) <= 0) {
            $pages = 1;
        } else {
           $pages = ceil($all_rows / $rows);
        }
    
         //6.  次のページ数（基本的に現在ページ+1。現在ページ+1が全ページ数より大きくなってしまうとページが無いのでその場合は''とする）
        $next = ($page + 1 > $pages) ? '' : $page + 1;
         //7.  一つ前のページ数（基本的に現在ページ-1。現在ページ-1が0になってしまうとページが無いのでその場合は''とする）
        $prev = ($page - 1 <= 0) ? '' : $page - 1;
        //ページング設定ここまで///////////////////////////////////////

        if ($keyword == '') {
                   $stmt = $dbh->prepare('SELECT * FROM contacts limit :offset,:rows');
               } else {
                   //検索条件を考慮
                   $stmt = $dbh->prepare('SELECT * FROM contacts WHERE name like :keyword limit :offset,:rows');
                   $stmt->bindValue(':keyword', '%'.$keyword.'%');
               }

	    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':rows', $rows, PDO::PARAM_INT);
	    $stmt->execute();
	    //結果を$contactsに格納
	    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <!-- <li><a href="">Home</a></li> -->
                <li><a href="../index.php">占いTOP</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </nav>
        <main>
            <section>
                <h2>管理画面トップページ</h2>
                <div class="list">
                <div class="list-box">
                       <a href="create.php"><button class="btn btn-primary">新規作成</button></a>
                       <a href="download.php?keyword=<?php echo $keyword; ?>"><button class="btn btn-primary">CSVダウンロード</button></a>
                       <form class="search" action="index.php" method="GET">
                           <input type="text" name="keyword" placeholder="名前検索" value="<?php echo $keyword; ?>">
                           <button type="submit" class="btn btn-primary" >検索</button>
                       </form>
                   </div>
	                <table>
	                    <thead>
	                        <tr>
	                            <th>id</th>
	                            <th>マイナンバー</th>
	                            <th>名前</th>
	                            <th>取得日時</th>
                                <th>確認状況</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <?php foreach ($contacts as $contact): ?>
	                        <tr>
                            <td><a href="show.php?id=<?php echo $contact['id']; ?>"><?php echo $contact['id']; ?></td>
	                            <td><?php echo $contact['mynum']; ?></td>
	                            <td><?php echo $contact['name']; ?></td>
	                            <td><?php echo $contact['created']; ?></td>
                                <td><?php if ($contact['processed'] == 0): ?><span style="color:red">未確認</span><?php else: ?><span style="color:green">確認済</span><?php endif; ?></td>
	                        </tr>
	                        <?php endforeach; ?>
	                    </tbody>
	                </table>
                    <ul class="paging">
                    <li><a href="index.php?keyword=<?php echo $keyword; ?>">« 最初</a></li>
                     <?php if ($prev != ''): ?>
                        <li><a href="index.php?page=<?php echo $prev; ?>&keyword=<?php echo $keyword; ?>"><?php echo $page - 1; ?></a></li>
                     <?php endif; ?>
                     <li><span><?php echo $page; ?></span></li>
                     <?php if ($next != ''):  ?>
                        <li><a href="index.php?page=<?php echo $next; ?>&keyword=<?php echo $keyword; ?>"><?php echo $page + 1; ?></a></li>
                     <?php endif; ?>
                     <li><a href="index.php?page=<?php echo $pages; ?>&keyword=<?php echo $keyword; ?>">最後 »</a></li>
                 </ul>
	                </div>
            </section>
        </main>
        <footer>
            <?php echo getenv("CORP_NAME"); ?>
        </footer>
    </body>
</html> 