<!-- 省略コマンド -->
<?php
// #region ===== 省略 ここから =====
?>
<?php
// #endregion ===== 省略 ここまで =====
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>No1blog</title>

  <!-- ▼ CSS読み込み -->
  <link rel="stylesheet" href="./no1.css">
  <link rel="stylesheet" href="./login-page.css">

</head>

<body>

  <?php
  // #region ===== ログイン時 ここから =====
  ?>
  <?php if (!empty($_SESSION['login-success'])): ?>
    <div id="flash-message" class="flash-success">
      <?= htmlspecialchars($_SESSION['login-success'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['login-success']); ?>
  <?php endif; ?>
  <?php
  // #endregion ===== ログイン時 ここまで =====
  ?>


  <?php
  // #region ===== ログアウト時 ここから =====
  ?>
  <?php if (!empty($_SESSION['logout-success'])): ?>
    <div id="flash-message" class="flash-success">
      <?= htmlspecialchars($_SESSION['logout-success'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['logout-success']); ?>
  <?php endif; ?>
  <?php
  // #endregion ===== ログアウト時 ここまで =====
  ?>

  <?php
  // #region ===== ヘッダークラス ここから =====
  ?>
  <header id="top" class="header">

    <div class="header-right">
      <?php if (isset($_SESSION['username'])): ?>
        <p>ようこそ <?= htmlspecialchars($_SESSION['username']) ?> さん</p>
        <a href="kiji-input.php" class="write-button">記事を書く</a>
        <a href="logout-output.php" class="login-button">ログアウト</a>
      <?php else: ?>
        <a href="login-input.php" class="login-button">ログイン</a>
      <?php endif; ?>
    </div>
  </header>
  <?php
  // #endregion ===== ヘッダークラス ここまで =====
  ?>

  <?php
  // #region ===== タイトルクラス ここから =====
  ?>
  <div class="title-area">
    <h1 class="title-text">No1の開発プロジェクトブログ</h1>
    <div class="rabbit-container">
      <img src="./img/usagi.png" alt="usagi" class="rabbit">
      <img src="./img/top-fukidashi.png" alt="噴き出し" class="bubble">
    </div>
  </div>

  <?php
  // #endregion ===== タイトルクラス ここまで =====
  ?>

  <?php
  // #region ===== サブタイトル ここから =====
  ?>

  <?php
  // #endregion ===== サブタイトル ここまで =====
  ?>


  <?php
  // #region ===== 記事一覧 ここから =====

  // 並び順（デフォルト：新しい順）
  $sort = $_GET['sort'] ?? 'desc';

  if ($sort !== 'asc' && $sort !== 'desc') {
    $sort = 'desc';
  }


  // 変数宣言
  $perPage = 10; // 1ページの表示件数

  // 現在のページ番号
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $page = max($page, 1);

  // 全記事数を取得
  $countSql = "SELECT COUNT(*) FROM posts";
  $totalPosts = $pdo->query($countSql)->fetchColumn();

  // 総ページ数
  $totalPages = ceil($totalPosts / $perPage);

  // 取得開始位置
  $offset = ($page - 1) * $perPage;
  $keyword = $_GET['keyword'] ?? '';
  $order = ($sort === 'asc') ? 'ASC' : 'DESC';

  // 検索結果の総件数を取得
  if (!empty($keyword)) {
    $countSql = "SELECT COUNT(*) FROM posts WHERE content LIKE :keyword";
    $stmtCount = $pdo->prepare($countSql);
    $stmtCount->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmtCount->execute();
    $totalPosts = $stmtCount->fetchColumn();
  } else {
    $countSql = "SELECT COUNT(*) FROM posts";
    $totalPosts = $pdo->query($countSql)->fetchColumn();
  }

  $totalPages = ceil($totalPosts / $perPage);
  $offset = ($page - 1) * $perPage;

  // 記事取得
  $sql = "
SELECT
    posts.post_id,
    posts.title,
    posts.created_at,
    users.username,
    COUNT(comment.post_id) AS comment_count,
    category.category_name
FROM posts
LEFT JOIN users ON posts.user_id = users.id
LEFT JOIN comment ON posts.post_id = comment.post_id
LEFT JOIN category ON posts.category_id = category.category_id
";

  $categoryFilter = $_GET['category_name'] ?? '';
  $conditions = [];
  $params = [];

  // キーワード検索条件
  if (!empty($keyword)) {
    $conditions[] = "posts.content LIKE :keyword";
    $params[':keyword'] = '%' . $keyword . '%';
  }

  // カテゴリー条件
  if (!empty($categoryFilter)) {
    $conditions[] = "category.category_name = :category_name";
    $params[':category_name'] = $categoryFilter;
  }

  // WHERE句をまとめる
  if ($conditions) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
  }

  // GROUP, ORDER, LIMIT は元のまま
  $sql .= "
GROUP BY posts.post_id, posts.title, posts.created_at, users.username, category.category_name
ORDER BY posts.created_at $order
LIMIT $perPage OFFSET $offset
";

  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  ?>

  <h2 class="page-title">記事一覧</h2>

  <form method="get" action="" class="post-search-form">
    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">

    <input
      type="text"
      name="keyword"
      placeholder="本文のキーワードを検索"
      value="<?= htmlspecialchars($_GET['keyword'] ?? '', ENT_QUOTES) ?>">

    <!-- カテゴリー選択（追加部分） -->
    <select name="category_name">
      <option value="">すべてのカテゴリー</option>
      <?php
      $catStmt = $pdo->query("SELECT category_name FROM category");
      $selectedCategory = $_GET['category_name'] ?? '';
      while ($cat = $catStmt->fetch(PDO::FETCH_ASSOC)) {
        $selected = ($selectedCategory === $cat['category_name']) ? 'selected' : '';
        echo "<option value=\"" . htmlspecialchars($cat['category_name']) . "\" $selected>"
          . htmlspecialchars($cat['category_name'])
          . "</option>";
      }
      ?>
    </select>
    <button type="submit">検索</button>
  </form>


  <div class="sort-search">
    <div class="sort-buttons">
      <a href="?sort=desc"
        class="sort-btn <?= $sort === 'desc' ? 'active' : '' ?>">
        新しい順
      </a>

      <a href="?sort=asc"
        class="sort-btn <?= $sort === 'asc' ? 'active' : '' ?>">
        古い順
      </a>
    </div>
  </div>

  <div class="post-cards">
    <?php foreach ($stmt as $row): ?>

      <a
        href="post-detail.php?post_id=<?= $row['post_id'] ?>"
        title="<?= htmlspecialchars($row['title'] ?? '') ?>"
        class="post-card">
        <time class="post-date">
          <?= htmlspecialchars($row['created_at']) ?>
        </time>

        <h3 class="post-title">

          <?= htmlspecialchars(
            $row['title'] !== '' && $row['title'] !== null
              ? $row['title']
              : '(タイトルなし)'
          ) ?>

        </h3>

        <p class="post-author">
          by <?= htmlspecialchars($row['username'] ?? '未設定') ?>
        </p>

        <p class="post-comments">
          コメント <?= (int)$row['comment_count'] ?>件
        </p>
        <p>
          カテゴリー：<?= $row['category_name'] ?>
        </p>
      </a>
    <?php endforeach; ?>
  </div>


  <!-- ページ変更 -->
  <div class="pagination">

    <?php if ($page > 1): ?>
      <a href="?page=<?= $page - 1 ?>&sort=<?= $sort ?>">≪ 前へ</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <?php if ($i == $page): ?>
        <a href="?page=<?= $i ?>&sort=<?= $sort ?>"><?= $i ?></a>
      <?php else: ?>
        <a href="?page=<?= $i ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <a href="?page=<?= $page + 1 ?>&sort=<?= $sort ?>">次へ ≫</a>
    <?php endif; ?>
  </div>




  <?php
  // #endregion ===== 記事一覧 ここまで =====
  ?>

  <!-- 先頭に戻るボタンの追加 -->
  <a href="#" class="to-top">▲ 先頭に戻る</a>

  <!--JavaScript読み込み -->
  <script src="./no1.js"></script>
  <script src="./logout-output.js"></script>

</body>

</html>