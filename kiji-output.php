 <!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./kiji.css">
 <link rel="stylesheet" href="./all.css">

 <body>
     <?php
        session_start();


        $pdo = new PDO(
            'mysql:host=localhost;dbname=blog;charset=utf8',
            'admin',
            'password'
        );

        if (empty($_REQUEST['content'])) {
            echo '<p class="submit-error">記事を書き込めませんでした</p>';
            echo '<div class="home-button"><a href="./kiji-input.php">前のページに戻る</a></div>';
        } else {
            echo '<p class="submit-success">投稿しました！</p>';
            // 適当な画像
            echo ' <img src="./img/post.png" alt="右下画像" style="display: block; margin: 0 auto; width: 200px; height: auto;">';
            echo '<a href="No1_blog.php" class="home-button">ホームに戻る</a>';

            $category_id   = $_POST['category_id'] ?? null;
            $new_category  = trim($_POST['new_category'] ?? '');


            if ($new_category !== '') {
                // すでに同じカテゴリ名があるか確認
                $stmt = $pdo->prepare(
                    'SELECT category_id FROM category WHERE category_name = ?'
                );
                $stmt->execute([$new_category]);
                $existing = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existing) {
                    // 既存カテゴリを使う
                    $category_id = $existing['category_id'];
                } else {
                    // 新規カテゴリを追加
                    $stmt = $pdo->prepare(
                        'INSERT INTO category (category_name) VALUES (?)'
                    );
                    $stmt->execute([$new_category]);
                    $category_id = $pdo->lastInsertId();
                }
                if ($category_id === null) {
                    exit('カテゴリを選択するか、新規カテゴリを入力してください');
                }
            }


            $sql = $pdo->prepare('insert into posts
            (user_id,title, content,created_at,category_id) values(?,?,?,NOW(),?)');
            $sql->execute([
                $_SESSION['user_id'],
                $_REQUEST['title'],
                $_REQUEST['content'],
                $category_id

            ]);
        }
        ?>
     <br>

 </body>