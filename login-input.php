 <!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./login-page.css">
 <link rel="stylesheet" href="./all.css">

 <?php require 'header.php'; ?>
 <header id="top" class="header"><br></header>


 <!-- ログイン -->
 <div class=" formTitle">
     <p>ログインページ</p>
 </div>

 <div class="login-page">


     <form action="login-output.php" method="post" required><br>

         ログイン名：<input type="text" name="login"><br>
         <br>
         パスワード：<input type="password" name="password"><br>
         <br>
         <input type="submit" value="ログイン">
         <br>


         <!-- ログイン失敗時の表示（outputから戻ってきたとき） -->
         <?php
            session_start();
            ?>
         <?php if (!empty($_SESSION['login-error'])): ?>
             <p class="login-error">
                 <?= htmlspecialchars($_SESSION['login-error'], ENT_QUOTES, 'UTF-8') ?>
             </p>
             <?php unset($_SESSION['login-error']); ?>
         <?php endif; ?>


         <div class="newUser">
             <a href="register.php" class="newUser">新規登録はこちら</a>
         </div>



     </form>

 </div>


     <a href="No1_blog.php" class="home-button">ホームに戻る</a>



 <?php require 'footer.php'; ?>