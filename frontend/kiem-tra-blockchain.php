
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra Blockchain</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
        }

        .container {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #1e293b;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 15px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }

        button {
            background: #2563eb;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 5px;
            overflow-wrap: anywhere;
        }

        .hash {
            font-size: 13px;
            margin: 10px 0;
        }

        .success {
            color: #15803d;
            font-weight: bold;
        }

        .error {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>KIỂM TRA TÍNH TOÀN VẸN BỆNH ÁN</h2>

    <p>Địa chỉ ví MetaMask:</p>
    <p id="diaChiVi">Chưa kết nối ví</p>

    <button type="button" onclick="ketNoiMetaMask()">
        Kết nối MetaMask
    </button>

    <hr>

    <label for="maBenhAn">
        Chọn mã bệnh án cần kiểm tra:
    </label>

    <select id="maBenhAn">
        <option value="">Đang tải danh sách...</option>
    </select>

    <button type="button" id="btnKiemTra">
        Kiểm tra Blockchain
    </button>

    <div class="result" id="ketQua" hidden>
        <h3>Kết quả kiểm tra</h3>

        <p id="trangThai"></p>

        <p><strong>Mã SHA-256 tính lại từ MySQL:</strong></p>
        <p class="hash" id="hashMySQL"></p>

        <p><strong>Mã băm đọc từ Blockchain:</strong></p>
        <p class="hash" id="hashBlockchain"></p>
    </div>

    <p>
        <a href="./danh-sach-benh-an.php">
            Quay lại danh sách bệnh án
        </a>
    </p>

</div>

<script src="https://cdn.jsdelivr.net/npm/ethers@6/dist/ethers.umd.min.js"></script>
<script src="../blockchain/contract-info.js"></script>
<script src="./js/wallet.js"></script>
<script src="./js/blockchain.js"></script>
<script src="./js/kiem-tra-blockchain.js"></script>

</body>
</html>
