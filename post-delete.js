/* #region ===== ゴミ箱開閉 & 削除 ここから ===== */

const giftBoxes = document.querySelectorAll('.trash-container');

trashBoxes.forEach(box => {
  box.addEventListener('click', () => {
    box.classList.toggle('trash-open');
  });
});





// ふたを開く
box.classList.add('trash-open');

// 演出後すぐ削除
setTimeout(() => {
  location.href = box.dataset.deleteUrl;
}, 300); // CSS transition と同じ





/* #endregion ===== ゴミ箱開閉 & 削除 ここまで ===== */
