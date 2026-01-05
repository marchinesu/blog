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
    </style>
</head>

<body>


    <?php
    $pdo = new PDO(
        'mysql:host=localhost;dbname=blog;charset=utf8',
        'admin',
        'password'
    );
    ?>

    <body>

        <div class="container">

            <h3>削除しますか？</h3>

            <div class="trash-wrap">
                <div class="trash-container">
                    <img src="./img/trash-yes.png" class="trash-yes" alt="はい">
                    <img src="./img/trash-lid.png" class="trash-lid" alt="ふた">
                    <a href="post-delete-output.php?post_id=<?= $_REQUEST['post_id'] ?>" class="trash-link">
                        <img src="./img/trash-body.png" class="trash-body" alt="ごみ箱">
                    </a>
                </div>

                <div class="trash-container">
                    <img src="./img/trash-no.png" class="trash-yes" alt="いいえ">
                    <img src="./img/trash-lid.png" class="trash-lid" alt="ふた">
                    <a href="post-detail.php?post_id=<?= $_REQUEST['post_id'] ?>" class="trash-link">
                        <img src="./img/trash-body.png" class="trash-body" alt="ごみ箱">
                    </a>
                </div>
            </div>

        </div>

        <script src="./post-delete.js"></script>
    </body>

    <!--JavaScript読み込み -->
    <script src="./post-delete.js"></script>

</body>