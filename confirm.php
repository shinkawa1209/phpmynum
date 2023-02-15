<?php
    if (isset($_POST['name']) ? $name = $_POST['name'] : $name = '');
    if (isset($_POST['email']) ? $email = $_POST['email'] : $email = '');
    if (isset($_POST['gender']) ? $gender = $_POST['gender'] : $gender = '');
    if (isset($_POST['message']) ? $message = $_POST['message'] : $message = '');
    $errors = [];
	    if (empty($name)) {
	        $errors[] = '名前は必須です。';
	    } else {
	        //パターンミスマッチ
	        if (!preg_match('/^[a-zA-Zぁ-んァ-ヶｱ-ﾝﾞﾟ一-龠]{2,16}$/', $name)) {
	            $errors[] = '名前は2文字以上8文字以下で設定してください';
	        }
	    }

	    if (empty($email)) {
	        $errors[] = 'Emailは必須です。';
	    } else {
	        //パターンミスマッチ
	        if (!preg_match('/^[a-z]+@[a-z]+\.[a-z]+$/', $email)) {
	            $errors[] = 'Emailの形式では無いようです';
	        }
	    }

	    if (empty($gender)) {
	        $errors[] = '性別はどちらかを選択してください';
	    }

		if (empty($message)) {
       	$errors[] = 'お問い合わせ内容は必須です。';
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
                <h2>お問合せ内容の確認（2/3）</h2>
                <div class="form-container">
                    <?php foreach ($errors as $error): ?>
    		            <span class="error_message"><?php echo $error; ?></span>
    		        <?php endforeach; ?>
                    <form id="form">
                        <div class="form-group">
                            <label>氏名</label>
                            <span class="confirm-item"><?php echo $name; ?></span>
                            <input type="hidden" name="name" value="<?php echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <span class="confirm-item"><?php echo $email; ?></span>
                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <label>性別</label>
                            <span class="confirm-item"><?php echo $gender; ?></span>
                            <input type="hidden" name="gender" value="<?php echo $gender; ?>">
                        </div>
                        <div class="form-group">
                            <label>お問合せ内容</label>
                            <span class="confirm-item"><?php echo $message; ?></span>
                            <input type="hidden" name="message" value="<?php echo $message; ?>">
                        </div>
                        <div class="form-group">
                        <input type="button" id="back" value="戻る">
                        <button type="submit" id="next" <?php echo $btn; ?>>上記内容で問合せる</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <footer>
            &copy 20xx Sample corporation.
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