 <!-- ▼ CSS読み込み -->
 <link rel="stylesheet" href="./kiji.css">
 <link rel="stylesheet" href="./all.css">

 <header id="top" class="header"><br></header>

 <?php
    $pdo = new PDO(
        'mysql:host =localhost;dbname=blog;charset=utf8',
        'admin',
        'password',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    /* カテゴリー取得 */
    $stmt = $pdo->query(
        'SELECT category_id, category_name FROM category ORDER BY category_name'
    );
    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>



 <div class="post-container">
     <?php require 'header.php'; ?>
     <div class="post">

         <p class="post-title">記事投稿</p>

         <form action="kiji-output.php" method="post" class="label">
             タイトル：<input type="text" name="title">
             <br>
             <h4> 本文：</h4>
             <textarea name="content" rows="15" cols="60"></textarea>

             <p>
                 カテゴリー<br>
                 <select name="category_id" id="categorySelect">
                     <option value="">選択してください</option>
                     <?php foreach ($category as $cat): ?>
                         <option value="<?= $cat['category_id'] ?>">
                             <?= htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8') ?>
                         </option>
                     <?php endforeach; ?>
                 </select>

                 <br>

             <p>
                 または新しいカテゴリーを入力：<br>
                 <input type="text" name="new_category" placeholder="" id="newCategory">
             </p>
             </p>

             <script>
                 const select = document.getElementById('categorySelect');
                 const input = document.getElementById('newCategory');

                 // 既存カテゴリを選んだら新規入力を無効化
                 select.addEventListener('change', () => {
                     if (select.value !== '') {
                         input.value = '';
                         input.disabled = true;
                     } else {
                         input.disabled = false;
                     }
                 });

                 // 新規カテゴリを入力したら select を無効化
                 input.addEventListener('input', () => {
                     if (input.value.trim() !== '') {
                         select.value = '';
                         select.disabled = true;
                     } else {
                         select.disabled = false;
                     }
                 });
             </script>

             <input type="submit" value="投稿" class="submit-btn">
         </form>
         <?php require 'footer.php'; ?>
     </div>
 </div>
 <br>


     <a href="No1_blog.php" class="home-button">ホームに戻る</a>
