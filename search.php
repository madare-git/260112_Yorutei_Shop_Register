<?php
require_once('funcs.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗情報照会 - 入力</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>🔍 登録情報照会</h1>
        <p style="text-align: center; color: #666; margin-bottom: 30px;">ご登録情報を入力してください。</p>
        
        <form method="post" action="detail.php">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">代表者氏名</label>
                <input type="text" name="search_name" placeholder="例: 山田 太郎" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">メールアドレス</label>
                <input type="email" name="search_email" placeholder="例: example@email.com" required
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>

            <button type="submit" style="width: 100%; background: #4285F4; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1.1em;">
                情報を照会する
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="color: #666; font-size: 0.9em; margin-bottom: 10px;">まだ登録がお済みでない方はこちら</p>
            <a href="index.php" style="color: #4285F4; text-decoration: none; font-weight: bold;">
                <i class="fas fa-edit"></i> 新規店舗登録へ戻る
            </a>
        </div>
    </div>

</body>
</html>