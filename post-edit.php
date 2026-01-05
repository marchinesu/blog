 <!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./kiji.css">
 <link rel="stylesheet" href="./all.css">

 <?php
    session_start();
    require 'db.php';

    //idチェック
    if (!isset($_GET['post_id'])) {
        header('location: No1_blog.php');
        exit;
    }
    $post_id = (int)$_GET['post_id'];

    //記事取得
    $sql = $pdo->prepare(
        'SELECT post_id, user_id, content, title FROM posts WHERE post_id = ?'
    );

    $sql->execute([$post_id]);
    $post = $sql->fetch(PDO::FETCH_ASSOC);

    //記事が存在しない
    if (!$post) {
        exit('記事が見つかりません...');
    }

    //投稿者本人チェック
    if ($_SESSION['user_id'] !== $post['user_id']) {
        exit('編集権限がありません');
    }
    ?>

 <!DOCTYPE html>
 <html lang="ja">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>編集中</title>
     <link rel="stylesheet" href="kiji.css">
     <link rel="stylesheet" href="all.css">
 </head>

 <body>

     <header id="top" class="header"><br><br></header>

     <div class="post-container">
         <h3 class="post-title">記事編集</h3>
         <form action="post-edit-output.php" method="post">
             <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
             <p>
             <h4> タイトル：</h4>
             <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>">
             </p>
             <p>
             <h4> 本文：</h4>
             <textarea name="content" rows="10" cols="50" required><?= htmlspecialchars($post['content']) ?></textarea>
             </p>

             <button type="submit">更新する</button>
         </form>

         <p><a href="post-detail.php?post_id=<?= $post['post_id'] ?>" class="back-btn">【記事詳細に戻る】</a></p>

     </div>

 
         <a href="No1_blog.php" class="home-button">ホームに戻る</a>


 </body>

 </html>