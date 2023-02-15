<?php
       if (isset($_POST['name']) ? $name = $_POST['name'] : $name = '');
       if (isset($_POST['email']) ? $email = $_POST['email'] : $email = '');
       if (isset($_POST['gender']) ? $gender = $_POST['gender'] : $gender = '');
       if (isset($_POST['message']) ? $message = $_POST['message'] : $message = '');
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
                <li><a href="/admins/login.php">admins</a></li>
                <li><a href="/admins/data/data.php">makedata</a></li>
            </ul>
        </nav>
        <header>
            <h1 id="main-title">Sample Web Form</h1>
        </header>
        <main>
            <section class="form-section">
                <h2>お問合せフォーム（1/3）</h2>
                <div class="form-container">
                    <form id="form">
                        <div class="form-group">
                            <label>氏名</label>
                            <input type="text" name="name" id="name" class="form-item" value="<?php echo $name; ?>">
                            <span id="name-error-message">名前は必須かつ2文字以上8文字以下。</span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-item" value="<?php echo $email; ?>">
                            <span id="email-error-message">Emailの形式では無いようです。</span>
                        </div>
                        <div class="form-group">
                            <label>性別</label>
                                男性：<input type="radio" name="gender" value="男性" <?php if($gender == "男性") echo "checked"; ?>>
                                女性：<input type="radio" name="gender" value="女性" <?php if($gender == "女性") echo "checked"; ?>>
                            <span id="gender-error-message" style="color:red;display:block">どちらかを選択してください。</span>
                        </div>
                        <div class="form-group">
                            <label>お問合せ内容</label>
                            <textarea name="message" class="form-item" id="message"><?php echo $message; ?></textarea>
                            <span id="message-error-message" style="color:red;display:block">内容は必須です。</span>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="next">確認へ</button>
                        </div>
                    </form>
                </div>
            </section>
       </main>
       <footer>
           &copy 20xx Sample corporation.
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
                const btn = document.getElementById("next");

                //バリデーションパターン
                const nameExp = /^[a-zA-Zぁ-んァ-ヶｱ-ﾝﾞﾟ一-龠]{2,8}$/;
                const emailExp = /^[a-z]+@[a-z]+\.[a-z]+$/;
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
                })

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
                })

                //gender
                gender.forEach(e=>{
                    e.addEventListener("click",()=>{
                        // console.log(document.querySelector("input:checked[name=gender]").value)
                        gender_error_message.style.display = "none";
                        checkSuccess();
                    })
                })

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
                    if (name.value && email.value && document.querySelector("input:checked[name=gender]")) {
                        if (name.getAttribute("class").includes("success") 
                            && email.getAttribute("class").includes("success") 
                            && document.querySelector("input:checked[name=gender]").value) {
                            btn.disabled = false;
                        } else {
                            btn.disabled = true;
                        }
                    }
                }

                //confirm.phpから戻ってきたときの制御
                   window.addEventListener('load', (event) => {
                       if (name.value && email.value && document.querySelector("input:checked[name=gender]")) {
                           name.setAttribute("class", "success");
                           email.setAttribute("class", "success");
                           gender_error_message.style.display = "none";
                           btn.disabled = false;
                       }
                   });

                //submit
                btn.addEventListener("click", e => {
                    e.preventDefault();
                    form.method = "post";
                    form.action = "confirm.php";
                    form.submit();
                })
           
       </script>
   </body>
/html>