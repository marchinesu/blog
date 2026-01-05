 <!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./login-page.css">
 <link rel="stylesheet" href="./all.css">

 <?php
    session_start();
    require 'header.php';

    // 既存のログイン情報をクリア
    unset($_SESSION['users']);

    $pdo = new PDO(
        'mysql:host=localhost;dbname=blog;charset=utf8',
        'admin',
        'password',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // ログインチェック
    $sql = $pdo->prepare(
        'SELECT * FROM users WHERE username = ?'
    );
    $sql->execute([$_POST['login']]);
    $row = $sql->fetch();

    // ログイン成功時
    if ($row && password_verify($_POST['password'], $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id']  = $row['id'];

        // フラッシュメッセージ
        $_SESSION['login-success'] = 'ログインしました';
        // ホームへ
        header('Location: No1_blog.php');
        exit;

        // ログイン失敗時
    } else {
        $_SESSION['login-error'] = 'ログイン名またはパスワードが違います';
        header('Location: login-input.php');
        exit;
    }
    ?>
 <br>

 <?php require 'footer.php'; ?>