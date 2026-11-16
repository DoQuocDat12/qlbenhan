window.CONTRACT_ABI = [
    {
        "inputs": [
            { "internalType": "string", "name": "recordId", "type": "string" },
            { "internalType": "bytes32", "name": "recordHash", "type": "bytes32" }
        ],
        "name": "createRecord",
        "outputs": [],
        "stateMutability": "nonpayable",
        "type": "function"
    },



{
    "inputs": [
        {
            "internalType": "string",
            "name": "recordId",
            "type": "string"
        }
    ],
    "name": "getRecord",
    "outputs": [
        {
            "internalType": "bytes32",
            "name": "",
            "type": "bytes32"
        },
        {
            "internalType": "address",
            "name": "",
            "type": "address"
        },
        {
            "internalType": "uint256",
            "name": "",
            "type": "uint256"
        }
    ],
    "stateMutability": "view",
    "type": "function"
},
{
    "inputs": [
        {
            "internalType": "string",
            "name": "recordId",
            "type": "string"
        },
        {
            "internalType": "bytes32",
            "name": "hashToCheck",
            "type": "bytes32"
        }
    ],
    "name": "verifyRecord",
    "outputs": [
        {
            "internalType": "bool",
            "name": "",
            "type": "bool"
        }
    ],
    "stateMutability": "view",
    "type": "function"
}

];