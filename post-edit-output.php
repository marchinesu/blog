<head>
    <!-- ▼ CSS読み込み -->
    <link rel="stylesheet" href="./kiji.css">
    <link rel="stylesheet" href="./all.css">

    <style>
        body {
            font-family: sans-serif;
            background: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 320px;
        }

        .center-only {
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin: 20px auto !important;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    require 'db.php';
    if (!isset($_SESSION['user_id'])) {
        header('Location: login-input.php');
        exit;
    }
    if (
        !isset($_POST['post_id']) ||
        !isset($_POST['title']) ||
        !isset($_POST['content'])
    ) {
        exit('不正なリクエストです');
    }
    $post_id = (int)$_POST['post_id'];
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    if ($content === '') {
        exit('本文が空です');
    }
    $sql = $pdo->prepare(
        'SELECT user_id FROM posts WHERE post_id = ?'
    );
    $sql->execute([$post_id]);
    $post = $sql->fetch(PDO::FETCH_ASSOC);
    if (!$post) {
        exit('記事が存在しません');
    }
    if ((int)$post['user_id'] !== (int)$_SESSION['user_id']) {
        exit('編集権限がありません');
    }
    $sql = $pdo->prepare(
        'UPDATE posts SET title = ?, content = ? WHERE post_id = ?'
    );
    $sql->execute([$title, $content, $post_id]);

    echo '
    <div class="container"><p>記事を更新しました</p>

<a href="post-detail.php?post_id=' . $post_id . '" class="home-button center-only">記事へ戻る</a>

</div>';
    exit;
    ?>
</body>