<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8') : '';

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
        <title>Simple Form</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="../index.php">お問い合わせ</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </nav>
        <main>
            <section class="form-section">
                <h2>新規お問い合わせ作成</h2>
                <div class="form-container">
                    <form id="form">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label>氏名</label>
                            <input type="text" name="name" id="name" class="form-item" value="<?php echo $contact['name']; ?>">
                            <span id="name-error-message">名前は必須かつ3文字以上6文字以下。</span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-item" value="<?php echo $contact['email']; ?>">
                            <span id="email-error-message">Emailの形式では無いようです。</span>
                        </div>
                        <div class="form-group">
                            <label>性別</label>
                            男性：<input type="radio" name="gender" value="男性" <?php if ($contact['gender'] == '男性') {
                                    echo 'checked';
                                } ?>>
                            女性：<input type="radio" name="gender" value="女性" <?php if ($contact['gender'] == '女性') {
                                    echo 'checked';
                                } ?>>
                            <span id="gender-error-message" style="color:red;display:block">どちらかを選択してください。</span>
                        </div>
                        <div class="form-group">
                            <label>お問合せ内容</label>
                            <textarea name="message" class="form-item" id="message"><?php echo $contact['message']; ?></textarea>
                            <span id="message-error-message" style="color:red;display:block">内容は必須です。</span>
                        </div>
                        <div class="form-group">
                            <label>処理</label>
                            <input type="checkbox" name="processed" value="1" <?php if ($contact['processed'] == '1') {
                                    echo 'checked';
                                } ?>>処理した
                        </div>
                        <div class="form-group">
                            <button type="submit" id="next" class="btn btn-primary">更新</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <footer>
            &copy; 20xx Sample corporation.
        </footer>
        <script>

            //Element取得

            //form
            const form = document.getElementById("form");
            //form element
            const name = document.getElementById("name");
            const email = document.getElementById("email");
            const gender = document.getElementsByName("gender");
            const message = document.getElementById("message");
            //error message
            const name_error_message = document.getElementById("name-error-message");
            const email_error_message = document.getElementById("email-error-message");
            const gender_error_message = document.getElementById("gender-error-message");
            const message_error_message = document.getElementById("message-error-message");
            //button

            //button
            const btn = document.getElementById("next");

            //バリデーションパターン
            const nameExp = /^[a-zA-Zぁ-んァ-ヶｱ-ﾝﾞﾟ一-龠0-9]{2,8}$/;
            const emailExp = /^[a-zA-Z0-9\._-]+@[a-z]+\.[a-z]+$/;
            const messageExp = /^\S+/;

            //初期状態設定
            btn.disabled = true;

            //event

            //name
            name.addEventListener("keyup", e => {
                if (nameExp.test(name.value)) {
                    name.setAttribute("class", "success");
                    name_error_message.style.display = "none";
                } else {
                    name.setAttribute("class", "error");
                    name_error_message.style.display = "block";
                }
                console.log(name.getAttribute("class").includes("success"));
                checkSuccess();
            });

            //email
            email.addEventListener("keyup", e => {
                if (emailExp.test(email.value)) {
                    email.setAttribute("class", "success");
                    email_error_message.style.display = "none";

                } else {
                    email.setAttribute("class", "error");
                    email_error_message.style.display = "block";
                }
                checkSuccess();
            });

            //gender
            gender.forEach(e=>{
                e.addEventListener("click",()=>{
                    gender_error_message.style.display = "none";
                    checkSuccess();
                })
            });

            //message
            message.addEventListener("keyup", e => {
                if (messageExp.test(message.value)) {
                    message.setAttribute("class", "success");
                    message_error_message.style.display = "none";
                } else {
                    message.setAttribute("class", "error");
                    message_error_message.style.display = "block";
                }
                checkSuccess();
            })

            //ボタンのdisabled制御
            const checkSuccess = () => {
                if (name.value && email.value && document.querySelector("input:checked[name=gender]")&&message.value) {
                    if (name.getAttribute("class").includes("success") 
                        && email.getAttribute("class").includes("success") 
                        && message.getAttribute("class").includes("success")
                        && document.querySelector("input:checked[name=gender]").value) {
                        btn.disabled = false;
                    } else {
                        btn.disabled = true;
                    }
                }
            }

            //最初の制御
            window.addEventListener('load', (event) => {
                if (name.value && email.value && document.querySelector("input:checked[name=gender]")&&message.value) {
                    name.setAttribute("class", "success");
                    email.setAttribute("class", "success");
                    message.setAttribute("class", "success");
                    name_error_message.style.display = "none";
                    email_error_message.style.display = "none";
                    gender_error_message.style.display = "none";
                    message_error_message.style.display = "none";
                    btn.disabled = false;
                }
            });

            //submit
            btn.addEventListener("click", e => {
                e.preventDefault();
                form.method = "post";
                form.action = "update.php";
                form.submit();
            });

        </script>
    </body>
</html>