<head>
    <!-- ▼ CSS読み込み -->
    <link rel="stylesheet" href="./post-delete.css">
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
    <div class="container">
        <?php
        $pdo = new PDO(
            'mysql:host=localhost;dbname=blog;charset=utf8',
            'admin',
            'password'
        );

        $sql = $pdo->prepare('DELETE FROM posts WHERE post_id = ?');

        if ($sql->execute([$_REQUEST['post_id']])) {
            echo '<div class="message success">削除しました</div>';
        } else {
            echo '<div class="message error">削除に失敗しました</div>';
        }
        ?>

        <div class="home-button  center-only">
            <a href="No1_blog.php">ホームに戻る</a>
        </div>
    </div>

</body>