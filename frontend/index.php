
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bệnh án Blockchain</title>

    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>

<div class="dashboard">

    <aside class="sidebar">
        <div class="logo">
            <div class="logo-icon">B</div>
            <div>
                
                <span>Quản lý bệnh án</span>
            </div>
        </div>

        <div class="menu-label">CHỨC NĂNG</div>

        <nav class="menu">
            <button class="menu-item active"
                    data-page="./danh-sach-benh-an.php"
                    data-title="Danh sách bệnh án">
                <span class="menu-icon">▤</span>
                <span>Danh sách bệnh án</span>
            </button>

            <button class="menu-item"
                    data-page="./benh-nhan.php"
                    data-title="Quản lý bệnh nhân">
                <span class="menu-icon">♙</span>
                <span>Bệnh nhân</span>
            </button>

            <button class="menu-item"
                    data-page="./tao-benh-an.php"
                    data-title="Tạo bệnh án">
                <span class="menu-icon">＋</span>
                <span>Tạo bệnh án</span>
            </button>

            <button class="menu-item"
                    data-page="./kiem-tra-blockchain.php"
                    data-title="Kiểm tra Blockchain">
                <span class="menu-icon">◇</span>
                <span>Kiểm tra Blockchain</span>
            </button>
        </nav>

        <div class="sidebar-bottom">
            <div class="system-status">
                <span class="status-dot"></span>
                <div>
                    <strong>Hệ thống hoạt động</strong>
                    <small>Ganache Local</small>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">

        <header class="topbar">
            <div>
                <h1 id="pageTitle">Danh sách bệnh án</h1>
                <p>Hệ thống quản lý bệnh án ứng dụng Blockchain</p>
            </div>

            <div class="topbar-right">
                <span class="network-status">
                    <span class="status-dot"></span>
                    Ganache Local
                </span>
            </div>
        </header>

        <section class="content-area">
            <div class="page-container">
                <iframe
                    id="contentFrame"
                    title="Nội dung chức năng"
                    src="./danh-sach-benh-an.php">
                </iframe>
            </div>
        </section>

    </main>

</div>

<script src="./js/dashboard.js"></script>
</body>
</html>
