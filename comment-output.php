<head>



    <style>
        /* #region ===== 配色パレット ===== */
        :root {
            /* メイン */
            --color-main-dark: #a1a1a1;
            --color-main: #BFBFBF;
            --color-main-light: #dddddd;
            /* アクセント */
            --color-accent-red: rgb(168, 28, 28);
            --color-accent-blue: #156082;
            /* 背景 */
            --color-base: #d1d1d1;
            /* 白黒 */
            --color-white: #ffffff;
            --color-black: #000000;
        }

        .home-button {
            background: var(--color-main-dark);
            width: 120px;
            height: 30px;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            z-index: 5;
            display: flex;
            align-items: center;
            /* 縦中央 */
            justify-content: center;
            /* 横中央 */
            text-decoration: none;
            /* リンク下線を消す */
            color: var(--color-white);
            /* 文字色 */
            font-weight: bold;
            /* 太字 */
        }


        .home-button:active {
            transform: scale(0.9);
        }

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
            display: flex;
            justify-content: center;
            margin: 20px 0;
            padding: 0;
        }

        .center-only p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php
        session_start();
        $user_id = $_SESSION['user_id'] ?? null;


        $pdo = new PDO(
            'mysql:host=localhost;dbname=blog;charset=utf8',
            'admin',
            'password'
        );


        $post_id = $_REQUEST['post_id'];
        if (empty($_REQUEST['comment'])) {
            echo '<p class="submit-error">コメントを書き込めませんでした</p>';
            echo '<p class="center-only"><a href="post-detail.php?post_id=' . $post_id . '" class="home-button">【記事に戻る】</a></p>';
        } else {
            echo '<div>';
            echo '<p class="submit-success">書き込みました</p>';
            echo '<p class="center-only"><a href="post-detail.php?post_id=' . $post_id . '" class="home-button">【記事に戻る】</a></p>';



            echo '</div>';

            $sql = $pdo->prepare(
                'insert into comment(user_id, comment,date,post_id)
             values(?,?,NOW(),?)'
            );

            $sql->execute([
                $user_id,
                $_REQUEST['comment'],
                $_REQUEST['post_id']

            ]);
        }
        ?>
    </div>
    <br>

</body>