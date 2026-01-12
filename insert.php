<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得
$repre_name=$_POST['repre_name'];
$shop_name=$_POST['shop_name'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$genre=$_POST['genre'];
$children=$_POST['children'];
$allergy=$_POST['allergy'];

//2. DB接続します
// try&catchは頑張ってやってみてエラーが出たら〜catch以下を実行してください
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO 
                        Shop_table(shop_name, repre_name, phone, email, address, genre, children, allergy, date) 
                        VALUES(:shop_name, :repre_name, :phone, :email, :address, :genre, :children, :allergy, now() )");

//  2. バインド変数を用意（セキュリティのため）
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':repre_name', $repre_name, PDO::PARAM_STR);
$stmt->bindValue(':shop_name', $shop_name, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':genre', $genre, PDO::PARAM_STR);
$stmt->bindValue(':children', $children, PDO::PARAM_STR);
$stmt->bindValue(':allergy', $allergy, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{

// 登録成功時：ここから下にご希望のHTMLを記述します
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>よる定 - 登録完了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f4f7f6; /* 背景を少し落ち着いた色に */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        .success-icon {
            font-size: 60px;
            color: #4285F4;
            background-color: #e8f0fe;
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            margin: 0 auto 20px;
        }
        h1 {
            color: #4285F4;
            font-size: 1.5em;
            margin-bottom: 15px;
        }
        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .nav-links a {
            display: block;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-list {
            background-color: #4285F4;
            color: white;
        }
        .btn-list:hover {
            background-color: #3367d6;
        }
        .btn-back {
            background-color: transparent;
            color: #4285F4;
            border: 2px solid #4285F4;
        }
        .btn-back:hover {
            background-color: #e8f0fe;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✓</div>
        <h1>申し込みが完了しました</h1>
        <p>ご登録ありがとうございます。</p>
        <ul class="nav-links">
            <li><a href="search.php" class="btn-list">登録情報を確認</a></li>
            <li><a href="index.php" class="btn-back">入力画面に戻る</a></li>
        </ul>
    </div>
</body>
</html>
<?php

} // elseの閉じタグ
?>

<!-- 
  //５．index.phpへリダイレクト
  header('Location: index.php');
}
?> -->
