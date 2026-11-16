
const menuItems = document.querySelectorAll(".menu-item");
const contentFrame = document.getElementById("contentFrame");
const pageTitle = document.getElementById("pageTitle");

// Chuyển đổi chức năng
menuItems.forEach(item => {
    item.addEventListener("click", function () {
        const duongDan = this.dataset.page;
        const tieuDe = this.dataset.title;

        contentFrame.src = duongDan;
        pageTitle.textContent = tieuDe;

        // Cập nhật trạng thái menu
        menuItems.forEach(menu => {
            menu.classList.remove("active");
        });

        this.classList.add("active");
    });
});
