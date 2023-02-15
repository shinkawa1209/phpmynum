<?php
    if (isset($_POST['mynum']) ? $mynum = $_POST['mynum'] : $mynum = '');
    if (isset($_POST['name']) ? $name = $_POST['name'] : $name = '');
    if (isset($_POST['gender']) ? $gender = $_POST['gender'] : $gender = '');
    if (isset($_POST['addr']) ? $addr = $_POST['addr'] : $addr = '');
    $errors = [];
	    if (empty($mynum)) {
	        $errors[] = 'マイナンバーは必須です。';
	    } else {
	        //パターンミスマッチ
	        if (!preg_match('/^[0-9]{2,12}$/', $mynum)) {
	            $errors[] = '半角数字で12桁以内で入力してください';
	        }
	    }

	    if (empty($name)) {
	        $errors[] = '氏名は必須です';
	    } else {
	        //パターンミスマッチ
	        if (!preg_match('/^[a-zA-Zぁ-んァ-ヶｱ-ﾝﾞﾟ一-龠0-9]{2,12}$/', $name)) {
	            $errors[] = '氏名は2文字以上、8文字以下です';
	        }
	    }

	    if (empty($gender)) {
	        $errors[] = '性別はどちらかを選択してください';
	    }

		if (empty($addr)) {
       	$errors[] = '住所は必須です。';
   	} 

	    if (empty($errors)) {
	        $btn = '';
	    } else {
	        $btn = 'disabled=disabled';
	    }
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
                <h2>内容の確認（2/3）</h2>
                <div class="form-container">
                    <?php foreach ($errors as $error): ?>
    		            <span class="error_message"><?php echo $error; ?></span>
    		        <?php endforeach; ?>
                    <form id="form">
                        <div class="form-group">
                            <label>マイナンバー</label>
                            <span class="confirm-item"><?php echo $mynum; ?></span>
                            <input type="hidden" name="mynum" value="<?php echo $mynum; ?>">
                        </div>
                        <div class="form-group">
                            <label>氏名</label>
                            <span class="confirm-item"><?php echo $name; ?></span>
                            <input type="hidden" name="name" value="<?php echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <label>性別</label>
                            <span class="confirm-item"><?php echo $gender; ?></span>
                            <input type="hidden" name="gender" value="<?php echo $gender; ?>">
                        </div>
                        <div class="form-group">
                            <label>住所</label>
                            <span class="confirm-item"><?php echo $addr; ?></span>
                            <input type="hidden" name="addr" value="<?php echo $addr; ?>">
                        </div>
                        <div class="form-group">
                        <input type="button" id="back" value="戻る">
                        <button type="submit" id="next" <?php echo $btn; ?>>上記で占う</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <footer>
            &copy 20xx shinkawa corporation.
        </footer>
        <script>
            const back = document.getElementById("back");
               //back
               back.addEventListener("click", (e) => {
                   e.preventDefault();
                   form.method = "post";
                   form.action = "index.php";
                   form.submit();
               });

            var button = document.getElementById("next");
            button.addEventListener("click",function(e){
                e.preventDefault();
                form.method = "post";
                form.action = "thankyou.php"
                form.submit();
            })
        </script>
    </body>
</html>