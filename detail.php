<?php
require_once('funcs.php');
$pdo = db_conn();

// 1. POSTデータ取得（search.php から送られてきた値）
// trimで前後の空白を削除、issetで未定義エラーを防止
$search_name  = isset($_POST['search_name'])  ? trim($_POST['search_name'])  : '';
$search_email = isset($_POST['search_email']) ? trim($_POST['search_email']) : '';

// 入力がない場合は入力画面に戻す
if (empty($search_name) || empty($search_email)) {
    header('Location: search.php');
    exit();
}

// 2. データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM Shop_table WHERE repre_name = :repre_name AND email = :email");
$stmt->bindValue(':repre_name', $search_name,  PDO::PARAM_STR);
$stmt->bindValue(':email',      $search_email, PDO::PARAM_STR);
$status = $stmt->execute();

// 3. データ取得結果の確認
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// データが見つからない場合の処理
if (!$result) {
    echo "<script>alert('該当するデータが見つかりませんでした。入力内容を確認してください。'); location.href='search.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>よる定 - 店舗情報編集</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <style>
        /* index.php と同じデザインを適用 */
        h1 { color: #4285F4; text-align: center; margin-bottom: 5px; font-size: 1.8em; }
        .subtitle { text-align: center; color: #666; margin-bottom: 30px; border-bottom: 2px solid #e0e0e0; padding-bottom: 15px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        input[type="text"], input[type="email"], input[type="number"], select {
            width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; font-size: 1em;
            transition: border-color 0.3s;
        }
        input:focus, select:focus { border-color: #4285F4; outline: none; }
        .button-group { text-align: center; margin-top: 30px; display: flex; flex-direction: column; gap: 15px; }
        #updateButton {
            padding: 15px; font-size: 1.1em; font-weight: 600; border: none; border-radius: 8px; cursor: pointer;
            background-color: #4285F4; color: white; width: 100%;
        }
        #updateButton:hover { background-color: #3367d6; }
        .radio-group { display: flex; flex-wrap: wrap; gap: 20px 30px; margin-top: 5px; }
        .radio-group label { font-weight: normal; margin-bottom: 0; }
    </style>
</head>

<body>

    <div class="container">
        <h1>よる定 - 店舗情報編集</h1>
        <p class="subtitle">現在の登録内容です。変更したい箇所を書き換えて保存してください。</p>

        <form action="update.php" method="post">
            
            <input type="hidden" name="id" value="<?= h($result['id']) ?>">

            <div class="form-group">
                <label for="repre_name">代表者氏名</label>
                <input type="text" name="repre_name" value="<?= h($result['repre_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="shop_name">店舗名</label>
                <input type="text" name="shop_name" value="<?= h($result['shop_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" value="<?= h($result['address']) ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">電話番号</label>
                <input type="text" name="phone" value="<?= h($result['phone']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" value="<?= h($result['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="genre">主なジャンル</label>
                <select name="genre" required>
                    <option value="和食" <?= $result['genre'] == '和食' ? 'selected' : '' ?>>和食</option>
                    <option value="魚料理" <?= $result['genre'] == '魚料理' ? 'selected' : '' ?>>魚料理</option>
                    <option value="鶏料理" <?= $result['genre'] == '鶏料理' ? 'selected' : '' ?>>鶏料理</option>
                    <option value="うどん・そば" <?= $result['genre'] == 'うどん・そば' ? 'selected' : '' ?>>うどん・そば</option>
                    <option value="とんかつ" <?= $result['genre'] == 'とんかつ' ? 'selected' : '' ?>>とんかつ</option>
                    <option value="中華" <?= $result['genre'] == '中華' ? 'selected' : '' ?>>中華</option>
                    <option value="洋食" <?= $result['genre'] == '洋食' ? 'selected' : '' ?>>洋食</option>
                    <option value="カレー" <?= $result['genre'] == 'カレー' ? 'selected' : '' ?>>カレー</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>お子様の入店ポリシー</label>
                <div class="radio-group">
                    <input type="radio" id="children_ok" name="children" value="子供OK" <?= $result['children'] == '子供OK' ? 'checked' : '' ?> required>
                    <label for="children_ok">子供OK</label>
                    <input type="radio" id="children_age" name="children" value="年齢制限あり" <?= $result['children'] == '年齢制限あり' ? 'checked' : '' ?> required>
                    <label for="children_age">年齢制限あり</label>
                    <input type="radio" id="children_ng" name="children" value="幼児NG" <?= $result['children'] == '幼児NG' ? 'checked' : '' ?> required>
                    <label for="children_ng">幼児NG</label>
                </div>
            </div>

            <div class="form-group">
                <label>アレルギー対応の可否</label>
                <div class="radio-group">
                    <input type="radio" id="allergy_ok" name="allergy" value="可" <?= $result['allergy'] == '可' ? 'checked' : '' ?> required>
                    <label for="allergy_ok">個別対応 可</label>
                    <input type="radio" id="allergy_consult" name="allergy" value="要相談" <?= $result['allergy'] == '要相談' ? 'checked' : '' ?> required>
                    <label for="allergy_consult">要相談</label>
                    <input type="radio" id="allergy_ng" name="allergy" value="不可" <?= $result['allergy'] == '不可' ? 'checked' : '' ?> required>
                    <label for="allergy_ng">不可</label>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" id="updateButton">変更を保存する</button>
                <a href="index.php" style="color: #666; text-decoration: none; font-size: 0.9em;">キャンセルして戻る</a>
            </div>
        </form>
    </div>

</body>
</html>