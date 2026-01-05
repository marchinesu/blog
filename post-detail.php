 <!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./all.css">
 <link rel="stylesheet" href="./post-detail.css">

 <?php
  session_start();
  require 'db.php';

  // idが指定されていない場合は一覧へ戻す
  if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    header('Location: No1_blog.php');
    exit;
  }

  $post_id = (int)$_GET['post_id'];


  // 記事1件取得（投稿者名も一緒に）
  $sql = $pdo->prepare(
    'SELECT 
        posts.post_id,
        posts.user_id,
        posts.title,
        posts.content,
        posts.created_at,
        users.username,
        category.category_name
     FROM posts
     LEFT JOIN users ON posts.user_id = users.id
     LEFT JOIN category ON posts.category_id = category.category_id
     WHERE posts.post_id = ?'

  );
  $sql->execute([$post_id]);
  $post = $sql->fetch(PDO::FETCH_ASSOC);

  $countStmt = $pdo->prepare(
    'SELECT COUNT(*) FROM comment WHERE post_id = ?'
  );
  $countStmt->execute([$post_id]);
  $comment_count = $countStmt->fetchColumn();


  // 記事が存在しない場合
  if (!$post) {
    echo '記事が見つかりません';
    exit;
  }
  ?>

 <!DOCTYPE html>
 <html lang="ja">

 <head>
   <meta charset="UTF-8">
   <title><?= htmlspecialchars($post['title']) ?></title>
   <link rel="stylesheet" href="./no1.css">
 </head>

 <body>

   <header id="top" class="header">

     <div class="header-right">
       <?php if (isset($_SESSION['username'])): ?>
         <p>ようこそ <?= htmlspecialchars($_SESSION['username']) ?> さん</p>
         <a href="logout-output.php" class="login-button">ログアウト</a>
       <?php else: ?>
         <a href="login-input.php" class="login-button">ログイン</a>
       <?php endif; ?>
     </div>
   </header>

   <div class="post-header">
     <h3 class="title"><?= htmlspecialchars($post['title']) ?></h3>
     <!-- 投稿者判定と編集ボタンの表示 -->
     <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$post['user_id']): ?>
       <div class="edit-button">
         <a href="post-edit.php?post_id=<?= $post['post_id'] ?>">【編集する】</a>
         <a href="post-delete-input.php?post_id=<?= $post['post_id'] ?>">【削除する】</a>
       </div>
     <?php endif; ?>
   </div>


   <p>
     投稿者：<?= htmlspecialchars($post['username'] ?? '不明') ?><br>
     投稿日時：<?= $post['created_at'] ?><br>
     カテゴリ：<?= htmlspecialchars($post['category_name']) ?>

   </p>


   <div class="post-content">
     <?= nl2br(htmlspecialchars($post['content'])) ?>
   </div>

   <h2>コメント（<?= $comment_count ?>件）</h2>

   <?php
    $sql = "SELECT comment.comment,comment.date,users.username 
    FROM comment
    LEFT JOIN users ON comment.user_id = users.id
    WHERE comment.post_id = ?
    ORDER BY comment.date ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id]);

    if ($comment_count === 0) {
      echo '<p>この投稿にはまだコメントがありません。</p>';
    } else {
      foreach ($stmt as $row) {
        echo '<p>';
        echo htmlspecialchars($row['username'] ?? '名無し', ENT_QUOTES, 'UTF-8');
        echo '：';
        echo htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8');
        echo ' ';
        echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8');
        echo '</p>';
      }
    }
    ?>

   <div class="comment-button">
     <a href="comment-input.php?post_id=<?= $post['post_id'] ?>">コメントする</a>
   </div>


     <a href="No1_blog.php" class="home-button">←記事一覧に戻る</a>


 </body>

 </html>