<p>
    または新しいカテゴリーを入力：<br>
    <input type="text" name="new_category" placeholder="">
</p>

<?php
$category_id = $_REQUEST['category_id'];
$new_category = trim($_REQUEST['new_category'] ?? '');

if ($new_category !== '') {
    $check = $pdo->prepare('SELECT category_id FROM category WHERE category_name = ?');
    $check->execute([$new_category]);
    $exist_id = $check->fetchColumn();

    if ($exist_id) {
        $category_id = $exist_id;
    } else {
        $ins = $pdo->prepare('INSERT INTO category (category_name) VALUES (?)');
        $ins->execute([$new_category]);

        $category_id = $pdo->lastInsertId();
    }
} ?>