console.log("flash.js 読み込みOK");

document.addEventListener("DOMContentLoaded", function () {
    const msg = document.getElementById("flash-message");
    if (msg) {
        setTimeout(() => {
            msg.style.transition = "opacity 0.5s";
            msg.style.opacity = "0";
            setTimeout(() => msg.remove(), 500);
        }, 1000); // ← 1秒後に消える
    }
});