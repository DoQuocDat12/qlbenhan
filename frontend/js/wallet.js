
let viMetaMask;
let diaChiVi = null;

const GANACHE_CHAIN_ID = "0x539";

// Kết nối MetaMask
async function ketNoiMetaMask() {
    if (!window.ethereum) {
        alert("Vui lòng cài đặt MetaMask!");
        return;
    }

    try {
        viMetaMask = window.ethereum;

        const taiKhoan = await viMetaMask.request({
            method: "eth_requestAccounts"
        });

        if (!taiKhoan || taiKhoan.length === 0) {
            throw new Error("Không tìm thấy tài khoản MetaMask.");
        }

        const chainId = await viMetaMask.request({
            method: "eth_chainId"
        });

        if (chainId.toLowerCase() !== GANACHE_CHAIN_ID) {
            diaChiVi = null;

            alert(
                "Vui lòng chuyển MetaMask sang mạng Ganache Local (Chain ID 1337)!"
            );
            return;
        }

        diaChiVi = taiKhoan[0];

        const phanTuDiaChi = document.getElementById("diaChiVi");

        if (phanTuDiaChi) {
            phanTuDiaChi.textContent = diaChiVi;
        }

        console.log("Địa chỉ ví:", diaChiVi);
        alert("Kết nối MetaMask thành công!");

    } catch (error) {
        console.error("Lỗi MetaMask:", error);
        alert("Không thể kết nối MetaMask: " + error.message);
    }
}

// Theo dõi khi người dùng đổi tài khoản
if (window.ethereum) {
    window.ethereum.on("accountsChanged", function (accounts) {
        diaChiVi = accounts.length > 0 ? accounts[0] : null;

        const phanTuDiaChi = document.getElementById("diaChiVi");

        if (phanTuDiaChi) {
            phanTuDiaChi.textContent =
                diaChiVi || "Chưa kết nối ví";
        }
    });

    // Theo dõi khi người dùng đổi mạng
    window.ethereum.on("chainChanged", function () {
        diaChiVi = null;

        const phanTuDiaChi = document.getElementById("diaChiVi");

        if (phanTuDiaChi) {
            phanTuDiaChi.textContent = "Vui lòng kết nối lại ví";
        }

        alert("Mạng Blockchain đã thay đổi. Vui lòng kết nối lại MetaMask!");
    });
}
