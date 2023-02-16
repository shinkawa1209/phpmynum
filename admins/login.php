<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getenv("SITE_TITLE"); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section class="form-section">
            <h2>ログイン</h2>
            <div class="form-container">
                <form id="form" action="check.php" method="post">
                    <div class="form-group">
                        <label>氏名</label>
                        <input type="text" name="name" id="name" class="form-item">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-item">
                    </div>

                    <div class="form-group login">
                        <button type="submit" class="btn btn-primary">ログイン</button>
                        <a href="../index.php">戻る</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html> 