<!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./kiji.css">
 <link rel="stylesheet" href="./all.css">


<?php


session_start();

if (!isset($_GET['post_id'])) {
    exit('記事IDがありません');
}

$post_id = (int)$_GET['post_id'];

require 'db.php';
$pdo = new PDO(
    'mysql:host =localhost;dbname=blog;charset=utf8',
    'admin',
    'password'
);

?>
<div class="post-container">
  <div class="post">

    <p class="post-title">コメントを書く</p>

    <form action="comment-output.php" method="post" class="label">
      <input type="hidden" name="post_id" value="<?= $post_id ?>">

      <textarea name="comment" rows="6" required placeholder="コメントを入力してください"></textarea>

      <button type="submit" class="submit-btn">コメントする</button>
    </form>
  </div>


        <a href="post-detail.php?post_id=<?= $post_id ?>" class="home-button">記事に戻る</a>

