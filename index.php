<!DOCTYPE html>
<html lang="ja">
<head>
    <title>よる定 - 店舗基本情報登録</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS: 基本的なレイアウトとデザイン */
        
        h1 { color: #4285F4; text-align: center; margin-bottom: 5px; font-size: 1.8em; }
        .subtitle { text-align: center; color: #666; margin-bottom: 30px; border-bottom: 2px solid #e0e0e0; padding-bottom: 15px; }
        
        /* リンクの見た目を調整 */
        .subtitle a {
            color: #4285F4;
            text-decoration: none;
            font-weight: bold;
        }
        .subtitle a:hover {
            text-decoration: underline;
        }

        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        input[type="text"], input[type="email"], input[type="number"], select {
            width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; font-size: 1em;
            transition: border-color 0.3s;
        }

        input:focus, select:focus { border-color: #4285F4; outline: none; }
        .button-group { text-align: right; margin-top: 30px; }
        #saveButton {
            padding: 12px 25px; font-size: 1em; font-weight: 600; border: none; border-radius: 8px; cursor: pointer;
            background-color: #4285F4; color: white;
        }
        #saveButton:hover { background-color: #3367d6; }
        .radio-group, .checkbox-group { display: flex; flex-wrap: wrap; gap: 20px 30px; margin-top: 5px; }
        .radio-group label, .checkbox-group label { font-weight: normal; margin-bottom: 0; }
    </style>
</head>

<body>

    <div class="container">
        <h1>よる定 - 店舗情報登録</h1>
        <p class="subtitle">登録済のお客様は<a href="search.php">こちら</a></p>

        <form action="insert.php" method="post">
            
            <div class="form-group">
                <label for="repre_name">代表者氏名</label>
                <input type="text" name="repre_name" placeholder="例: 山田 太郎" required>
            </div>
            <div class="form-group">
                <label for="shop_name">店舗名</label>
                <input type="text" name="shop_name" placeholder="店舗名を入力" required>
            </div>
            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" placeholder="都道府県から住所を入力" required>
            </div>
            <div class="form-group">
                <label for="phone">電話番号</label>
                <input type="text" name="phone" placeholder="例: 03-XXXX-XXXX" required>
            </div>
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" placeholder="メールアドレスを入力" required>
            </div>

            <div class="form-group">
                <label for="genre">主なジャンル</label>
                <select name="genre" required>
                    <option value="">選択してください</option>
                    <option value="和食">和食</option>
                    <option value="魚料理">魚料理</option>
                    <option value="鶏料理">鶏料理</option>
                    <option value="うどん・そば">うどん・そば</option>
                    <option value="とんかつ">とんかつ</option>
                    <option value="中華">中華</option>
                    <option value="洋食">洋食</option>
                    <option value="カレー">カレー</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>お子様の入店ポリシー</label>
                <div class="radio-group">
                    <input type="radio" id="children_ok" name="children" value="子供OK" required>
                    <label for="children_ok">子供OK (制限なし)</label>
                    <input type="radio" id="children_age" name="children" value="年齢制限あり" required>
                    <label for="children_age">年齢制限あり (例: 10歳以上)</label>
                    <input type="radio" id="children_ng" name="children" value="幼児NG" required>
                    <label for="children_ng">幼児NG / 小さなお子様不可</label>
                </div>
            </div>

            <div class="form-group">
                <label>アレルギー対応の可否</label>
                <div class="radio-group">
                    <input type="radio" id="allergy_ok" name="allergy" value="可" required>
                    <label for="allergy_ok">個別対応 可</label>
                    <input type="radio" id="allergy_consult" name="allergy" value="要相談" required>
                    <label for="allergy_consult">要相談 (当日の食材次第)</label>
                    <input type="radio" id="allergy_ng" name="allergy" value="不可" required>
                    <label for="allergy_ng">不可</label>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" id="saveButton">基本情報を保存・更新</button>
            </div>
        </form>
    </div>

    