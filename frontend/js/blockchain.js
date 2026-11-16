
let provider;
let signer;
let medicalContract;



// Tải cấu hình và kết nối Smart Contract
async function ketNoiBlockchain() {
    try {
        if (!window.ethereum) {
            throw new Error("Bạn chưa cài đặt MetaMask!");
        }

        if (!diaChiVi) {
            throw new Error("Vui lòng kết nối MetaMask trước!");
        }

        const chainId = await window.ethereum.request({
            method: "eth_chainId"
        });

        if (chainId.toLowerCase() !== GANACHE_CHAIN_ID) {
            throw new Error("Vui lòng chuyển sang mạng Ganache Local!");
        }

        // Tải địa chỉ Contract từ PHP
        const response = await fetch(
            "../backend/cau-hinh/contract-config.php"
        );

        if (!response.ok) {
            throw new Error("Không tải được cấu hình Contract!");
        }

        const config = await response.json();

        const contractAddress = config.contractAddress;

        if (!contractAddress) {
            throw new Error("Chưa có địa chỉ Smart Contract!");
        }

        // Kiểm tra ABI
        if (!window.CONTRACT_ABI) {
            throw new Error("Không tìm thấy ABI của Smart Contract!");
        }

        // Khởi tạo Ethers.js
        provider = new ethers.BrowserProvider(window.ethereum);

        signer = await provider.getSigner();

        // Khởi tạo Smart Contract
        medicalContract = new ethers.Contract(
            contractAddress,
            window.CONTRACT_ABI,
            signer
        );

        console.log("Kết nối Smart Contract thành công!");
        console.log("Địa chỉ Contract:", contractAddress);
        console.log("Địa chỉ ví:", diaChiVi);

        alert("Kết nối Blockchain thành công!");

        return medicalContract;

    } catch (error) {
        console.error("Lỗi kết nối Blockchain:", error);
        alert("Không thể kết nối Blockchain: " + error.message);
        return null;
    }
}
