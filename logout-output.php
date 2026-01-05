<!-- ログアウトボタン押下時 -->

<?php session_start();

// セッションを削除
session_unset();
session_destroy();

session_start();
$_SESSION['logout-success'] = "ログアウトしました";


// トップページにリダイレクト
header("Location: No1_blog.php");
exit;
