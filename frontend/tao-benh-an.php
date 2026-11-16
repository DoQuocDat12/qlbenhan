
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tạo bệnh án</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 850px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #1e293b;
        }

        .wallet-info {
            padding: 15px;
            margin-bottom: 25px;
            background: #eff6ff;
            border-radius: 6px;
            overflow-wrap: anywhere;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            padding: 11px 20px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        #thongBao {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>TẠO BỆNH ÁN MỚI</h2>

    <div class="wallet-info">
        <p><strong>Địa chỉ ví bác sĩ:</strong></p>

        <p id="diaChiVi">Chưa kết nối ví</p>

        <button type="button" onclick="ketNoiMetaMask()">
            Kết nối MetaMask
        </button>
    </div>

    <form id="formBenhAn">

        <div class="form-group">
            <label for="maSoBenhAn">Mã số bệnh án</label>

            <input
                type="text"
                id="maSoBenhAn"
                placeholder="Ví dụ: BA001"
                required
            >
        </div>

        <div class="form-group">
            <label for="maBenhNhan">Bệnh nhân</label>

            <select id="maBenhNhan" required>
                <option value="">Đang tải danh sách bệnh nhân...</option>
            </select>
        </div>

        <div class="form-group">
            <label for="trieuChung">Triệu chứng</label>

            <textarea
                id="trieuChung"
                placeholder="Nhập triệu chứng..."
            ></textarea>
        </div>

        <div class="form-group">
            <label for="chanDoan">Chẩn đoán</label>

            <textarea
                id="chanDoan"
                placeholder="Nhập chẩn đoán..."
                required
            ></textarea>
        </div>

        <div class="form-group">
            <label for="phuongPhapDieuTri">
                Phương pháp điều trị
            </label>

            <textarea
                id="phuongPhapDieuTri"
                placeholder="Nhập phương pháp điều trị..."
            ></textarea>
        </div>

        <button type="submit">
            Tạo bệnh án
        </button>

    </form>

    <p id="thongBao"></p>

</div>

<!-- Ethers.js -->
<script src="https://cdn.jsdelivr.net/npm/ethers@6/dist/ethers.umd.min.js"></script>

<!-- ABI Smart Contract -->
<script src="../blockchain/contract-info.js"></script>

<!-- Kết nối MetaMask -->
<script src="./js/wallet.js"></script>

<!-- Kết nối Smart Contract -->
<script src="./js/blockchain.js"></script>

<!-- Xử lý tạo bệnh án -->
<script src="./js/tao-benh-an.js"></script>

</body>
</html>
