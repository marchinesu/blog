 <!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./login-page.css">
 <link rel="stylesheet" href="./all.css">

 <header id="top" class="header"><br><br></header>


 <?php
  session_start();
  ?>

 <div class=" formTitle">
   <p>新規登録ページ</p>
 </div>

 <div class="simple-login-page">

   <?php
    require 'db.php';


    $errorMessage = '';
    $isRegistered = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if (empty($_POST['username']) || empty($_POST['password'])) {
        $errorMessage = 'ユーザー名とパスワードを入力してください。';
      } else {

        // ユーザー名の重複チェック
        $checkSql = "SELECT COUNT(*) FROM users WHERE username = ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$_POST['username']]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
          $errorMessage = 'そのユーザー名はすでに存在しています。';
        } else {
          // 新規登録
          $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

          $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$_POST['username'], $hash]);

          $_SESSION['username'] = $_POST['username'];
          $isRegistered = true;
        }
      }
    }
    ?>

   <?php if (!$isRegistered): ?>
     <form method="post">
       ユーザー名<br>
       <input type="text" name="username"><br><br>

       パスワード<br>
       <input type="password" name="password"><br><br>

       <input type="submit" value="登録">
     </form>
     <?php if ($errorMessage !== ''): ?>
       <p style="color:red;"><?php echo $errorMessage; ?></p>
     <?php endif; ?>
   <?php else: ?>
     <p style="text-align: center;">登録完了しました。</p>

     <?php $_SESSION['username'] = $_POST['username'];
      $userId = $pdo->lastInsertId();
      $_SESSION['user_id']  = (int)$userId; ?>

 </div>
 <?php endif; ?>


   <a href="No1_blog.php" class="home-button">ホームに戻る</a>
