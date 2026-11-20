
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Danh sách bệnh án</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #1e293b;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .hash {
            max-width: 170px;
            overflow-wrap: anywhere;
            font-size: 12px;
        }

        .transaction {
            max-width: 150px;
            overflow-wrap: anywhere;
            font-size: 12px;
        }

        #thongBao {
            margin: 15px 0;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="top-bar">
        <h2>DANH SÁCH BỆNH ÁN</h2>

        <a href="./tao-benh-an.php" class="btn">
            + Tạo bệnh án mới
        </a>
        <a href="./kiem-tra-blockchain.php" class="btn">
            Kiểm tra Blockchain
        </a>
    </div>

    <p id="thongBao">Đang tải dữ liệu...</p>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã bệnh án</th>
                    <th>Bệnh nhân</th>
                    <th>Bác sĩ</th>
                    <th>Chẩn đoán</th>
                    <th>Giao dịch Blockchain</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>

            <tbody id="danhSachBenhAn">
                <tr>
                    <td colspan="7">Đang tải dữ liệu...</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script src="./js/danh-sach-benh-an.js"></script>

</body>
</html>
