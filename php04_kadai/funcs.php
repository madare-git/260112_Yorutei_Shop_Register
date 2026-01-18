<?php
//XSS対応（ echoする場所で使用！）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//DB接続関数：db_conn() 
//※関数を作成し、内容をreturnさせる。
//※ DBname等、今回の授業に合わせる。


function db_conn(){
    // dbset_error表示
    ini_set('display_errors', "On");
    error_reporting(E_ALL);
    
    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        // ローカル環境（XAMPPなど）の設定
        $db_name = 'XXX';    //データベース名
        $db_id   = 'root';      //アカウント名
        $db_pw   = '';      //パスワード：MAMPは'root'
        $db_host = 'localhost'; //DBホスト
    } else {
        // 本番環境（さくらサーバーなど）の設定
        $db_name = 'XXX';    //データベース名
        $db_id   = 'XXX';      //アカウント名(DB名と同じ) 
        $db_pw   = 'XXX';      //パスワード(非公開)
        $db_host = 'XXX'; //DBホスト
    }

    //DSN(Data Source Name)の設定
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

    // PDOのオプション設定(安全に、楽に、バグを少なく開発するための保険)
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {

        $pdo = new PDO($dsn, $db_id, $db_pw, $options);
        return $pdo;  //db_conn関数の外でも$pdoを使えるようにreturnで返す
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}


//SQLエラー
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
}

//リダイレクト
function redirect($file_name)
{
    header('Location: ' . $file_name);
    exit();
}


// ログインチェク処理 loginCheck()

function loginCheck()
{    
    if(!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !==session_id()){
        // issetは、変数が存在しているかを確認する関数
        // !は否定の意味、つまり、上記はissetでセッション変数が存在していない場合、もしくは、セッションIDが一致しない場合、という意味
        // ||は、または(or)、の意味

        // login情報がなければ、ここで終了(ログインページへリダイレクト)
        exit('LOGIN ERROR: ログインしてください。 <a href="login.php">ログイン画面へ</a>');
    }

    // ログインOKの場合、セッションIDを更新(新しく発行し直す)
    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
}