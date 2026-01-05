/* まとめる時用タグ↓ */
// #region ===== 省略 ここから =====
// #endregion ===== 省略 ここまで =====

// #region ===== 先頭に戻るボタン ここから =====
document.addEventListener("scroll", () => {
    const toTopBtn = document.querySelector(".to-top");
    if (!toTopBtn) return;

    // スクロールしたらボタンを表示するようにする
    if (window.scrollY > 30) {
        toTopBtn.style.display = "block";
    } else {
        toTopBtn.style.display = "none";
    }
});
// #endregion ===== 先頭に戻るボタン ここまで =====


// #region ===== タイトル文字を1文字ずつ <span> で囲む ここから =====
document.addEventListener("DOMContentLoaded", () => {
    const title = document.querySelector(".title");
    if (!title) return;

    const text = title.textContent.trim();
    title.textContent = "";

    [...text].forEach(char => {
        const span = document.createElement("span");
        span.textContent = char;
        title.appendChild(span);
    });
});
// #endregion ===== タイトル文字を1文字ずつ <span> で囲む ここまで =====

