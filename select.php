<?php

//1. XSS対策用関数
// function h($str){
//     return htmlspecialchars($str, ENT_QUOTES);
// }
require_once('funcs.php');
$pdo = db_conn();

//2. 検索されたメールアドレスを取得
$search_email = isset($_POST['search_email']) ? trim($_POST['search_email']) : '';


// 4. データ取得SQL作成
if (!empty($search_email)) {
    // メールアドレスで検索する場合
    $stmt = $pdo->prepare("SELECT * FROM Shop_table WHERE email = :email");
    $stmt->bindValue(':email', $search_email, PDO::PARAM_STR);
} else {
    // 検索なし（全件表示）の場合
    $stmt = $pdo->prepare("SELECT * FROM Shop_table ORDER BY date DESC");
}

$status = $stmt->execute();



//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){

    $view .= '<div class="result-card" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">';    
    
    // --- 1. カードヘッダー部分を追加 ---
    // paddingの「15px」の部分を増やすことで、縦幅を自由に調整できます。
    $view .= '<div style="background: #f8f9fa; padding: 8px 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">';
    
    // 左側：店舗名をタイトルとして表示
    $view .= '<span style="font-weight: bold; color: #4285F4; font-size: 1em;"><i class="fas fa-store"></i> ' . h($result['shop_name']) . '</span>';
    
    // 右側：削除ボタン
    $view .= '<a href="delete.php?id=' . h($result['id']) . '" 
                onclick="return confirm(\'この店舗データを削除してもよろしいですか？\');"
                style="background: #eb4d4b; color: white; text-decoration: none; padding: 4px 10px; border-radius: 4px; font-size: 0.75em; font-weight: bold; transition: 0.3s;">
                <i class="fas fa-trash-alt"></i> 削除
              </a>';
    
    $view .= '</div>'; // ヘッダー終了
    

    $view .= '<table style="width: 100%; border-collapse: collapse; color: #333333; margin-top: 0; border-spacing: 0;">';
        
    // 各項目を1行ずつ作成（DBのカラム名に合わせる）
    $view .= '<tr><th style="width: 30%; background: #f8f9fa; padding: 10px; border-bottom: 1px solid #eee; text-align: left; color: #333333;">登録日時</th>';
    $view .= '<td style="padding: 10px; border-bottom: 1px solid #eee; color: #333333;">' . h($result['date']) . '</td></tr>';
    
    $view .= '<tr><th style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #eee; text-align: left; color: #333333;">店舗名</th>';
    $view .= '<td style="padding: 10px; border-bottom: 1px solid #eee; color: #333333;">' . h($result['shop_name']) . '</td></tr>';
    
    $view .= '<tr><th style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #eee; text-align: left; color: #333333;">代表者</th>';
    $view .= '<td style="padding: 10px; border-bottom: 1px solid #eee; color: #333333;">' . h($result['repre_name']) . '</td></tr>';
    
    $view .= '<tr><th style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #eee; text-align: left; color: #333333;">住所</th>';
    $view .= '<td style="padding: 10px; border-bottom: 1px solid #eee; color: #333333;">' . h($result['address']) . '</td></tr>';
    
    $view .= '<tr><th style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #eee; text-align: left; color: #333333;">メール</th>';
    $view .= '<td style="padding: 10px; border-bottom: 1px solid #eee; color: #333333;">' . h($result['email']) . '</td></tr>';

    $view .= '<tr><th style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #eee; text-align: left; color: #333333;">子供可否</th>';
    $view .= '<td style="padding: 10px; border-bottom: 1px solid #eee; color: #333333;">' . h($result['children']) . ' / ' . h($result['allergy']) . '</td></tr>';
    
    $view .= '</table>';
    $view .= '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗情報照会 - SQL版</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <h1>📊 店舗情報マスタ</h1>
        
        <form method="post" action="select.php" style="margin-bottom: 30px; display: flex; gap: 10px;">
            <input type="email" name="search_email" placeholder="メールアドレスで検索" 
                   value="<?= h($search_email) ?>" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
            <button type="submit" style="background: #4285F4; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">検索</button>
            <a href="select.php" style="padding: 10px; text-decoration: none; color: #666;">リセット</a>
        </form>

        <div class="data-container">
            <?php if(empty($view)): ?>
                <p style="text-align: center; color: #999;">データが見つかりませんでした。</p>
            <?php else: ?>
                <?= $view ?>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="index.php" style="color: #4285F4;">入力画面に戻る</a>
        </div>
    </div>
</body>
</html>