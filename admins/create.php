<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
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
                <li><a href="index.php">管理画面</a></li>
                <li><a href="../index.php">占いTOP</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </nav>
        <main>
        <section class="form-section">
                <h2>新規データ作成</h2>
                <div class="form-container">
                    <form id="form">
                        <div class="form-group">
                            <label>マイナンバー</label>
                            <input type="text" name="mynum" id="mynum" class="form-item" >
                            <span id="mynum-error-message" style="color:red;display:block">半角数字で12桁以内</span>
                        </div>
                        <div class="form-group">
                            <label>氏名</label>
                            <input type="text" name="name" id="name" class="form-item" >
                            <span id="name-error-message" style="color:red;display:block">氏名は2文字以上、8文字以下</span>
                        </div>
                        <div class="form-group">
                            <label>性別</label>
                            男性：<input type="radio" name="gender" value="男性">
                            女性：<input type="radio" name="gender" value="女性">
                            <span id="gender-error-message" style="color:red;display:block">どちらかを選択</span>
                        </div>
                        <div class="form-group">
                            <label>住所</label>
                            <textarea name="addr" class="form-item" id="addr"></textarea>
                            <span id="addr-error-message" style="color:red;display:block">住所は必須です。</span>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="next" class="btn btn-primary">登録</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <footer>
        <?php echo getenv("CORP_NAME"); ?>
        </footer>
        <script>

            //Element取得

            //form
            const form = document.getElementById("form");
            //form element
            const mynum = document.getElementById("mynum");
            const name = document.getElementById("name");
            const gender = document.getElementsByName("gender");
            const addr = document.getElementById("addr");
            //error message
            const mynum_error_message = document.getElementById("mynum-error-message");
            const name_error_message = document.getElementById("name-error-message");
            const gender_error_message = document.getElementById("gender-error-message");
            const addr_error_message = document.getElementById("addr-error-message");
            //button

            //button
            const btn = document.getElementById("next");

            //バリデーションパターン
            const mynumExp = /^[0-9]{2,12}$/;
            const nameExp = /^[a-zA-Zぁ-んァ-ヶｱ-ﾝﾞﾟ一-龠0-9]{2,8}$/;
            const addrExp = /^\S+/;

            //初期状態設定
            btn.disabled = true;

            //event

            //mynum
            mynum.addEventListener("keyup", e => {
                if (mynumExp.test(mynum.value)) {
                    mynum.setAttribute("class", "success");
                    mynum_error_message.style.display = "none";
                } else {
                    mynum.setAttribute("class", "error");
                    mynum_error_message.style.display = "block";
                }
                console.log(mynum.getAttribute("class").includes("success"));
                checkSuccess();
            });

            //name
            name.addEventListener("keyup", e => {
                if (nameExp.test(name.value)) {
                    name.setAttribute("class", "success");
                    name_error_message.style.display = "none";

                } else {
                    name.setAttribute("class", "error");
                    name_error_message.style.display = "block";
                }
                checkSuccess();
            });

            //gender
            gender.forEach(e=>{
                e.addEventListener("click",()=>{
                    // console.log(document.querySelector("input:checked[name=gender]").value)
                    gender_error_message.style.display = "none";
                    checkSuccess();
                })
            });

            //addr
            addr.addEventListener("keyup", e => {
                if (addrExp.test(addr.value)) {
                    addr.setAttribute("class", "success");
                    addr_error_message.style.display = "none";
                } else {
                    addr.setAttribute("class", "error");
                    addr_error_message.style.display = "block";
                }
                checkSuccess();
            })

            //ボタンのdisabled制御
            const checkSuccess = () => {
                if (mynum.value && name.value && document.querySelector("input:checked[name=gender]")&&addr.value) {
                    if (mynum.getAttribute("class").includes("success") 
                        && name.getAttribute("class").includes("success") 
                        && addr.getAttribute("class").includes("success")
                        && document.querySelector("input:checked[name=gender]").value) {
                        btn.disabled = false;
                    } else {
                        btn.disabled = true;
                    }
                }
            }

            //submit
            btn.addEventListener("click", e => {
                e.preventDefault();
                form.method = "post";
                form.action = "insert.php";
                form.submit();
            });

        </script>
    </body>
</html> 