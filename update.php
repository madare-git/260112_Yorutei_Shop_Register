<!-- 
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更 -->

<?php

    //1. POSTデータ取得

    $repre_name=$_POST['repre_name'];
    $shop_name=$_POST['shop_name'];
    $address=$_POST['address'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $genre=$_POST['genre'];
    $children=$_POST['children'];
    $allergy=$_POST['allergy'];
    $id     = $_POST['id'];

    //2. DB接続します
    //*** function化する！  *****************
    require_once('funcs.php');
    $pdo = db_conn();

    //３．データ登録SQL作成
        $stmt = $pdo->prepare('UPDATE 
                                    Shop_table 
                                SET 
                                    repre_name=:repre_name, 
                                    shop_name=:shop_name, 
                                    address=:address, 
                                    phone=:phone, 
                                    email=:email, 
                                    genre=:genre, 
                                    children=:children, 
                                    allergy=:allergy,
                                    date=now() 
                                where id=:id;' );

    // 数値の場合 PDO::PARAM_INT
    // 文字の場合 PDO::PARAM_STR
    $stmt->bindValue(':repre_name', $repre_name, PDO::PARAM_STR);
    $stmt->bindValue(':shop_name', $shop_name, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':genre', $genre, PDO::PARAM_STR);
    $stmt->bindValue(':children', $children, PDO::PARAM_STR);
    $stmt->bindValue(':allergy', $allergy, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute(); //実行

    //４．データ登録処理後
    if ($status === false) {
        //*** function化する！******\
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {

// 登録成功時：ここから下にご希望のHTMLを記述します
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>よる定 - 登録更新完了</title>
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
        <h1>登録情報の更新が完了しました</h1>
        <ul class="nav-links">
            <li><a href="detail.php" class="btn-list">登録情報を再度確認</a></li>
            <li><a href="index.php" class="btn-back">入力画面に戻る</a></li>
        </ul>
    </div>
</body>
</html>
<?php

} // elseの閉じタグ
?>
