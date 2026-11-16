
// SPDX-License-Identifier: MIT
pragma solidity ^0.8.28;

contract MedicalRecord {

    struct Record {
        bytes32 recordHash;
        address doctor;
        uint256 createdAt;
    }

    address public owner;

    mapping(string => Record) private records;

    event RecordCreated(
        string recordId,
        bytes32 recordHash,
        address doctor,
        uint256 createdAt
    );

    constructor() {
        owner = msg.sender;
    }

    // Tao benh an va luu ma bam len Blockchain
    function createRecord(
        string memory recordId,
        bytes32 recordHash
    ) public {
        require(bytes(recordId).length > 0, "Record ID is empty");
        require(recordHash != bytes32(0), "Hash is empty");
        require(
            records[recordId].createdAt == 0,
            "Record already exists"
        );

        records[recordId] = Record({
            recordHash: recordHash,
            doctor: msg.sender,
            createdAt: block.timestamp
        });

        emit RecordCreated(
            recordId,
            recordHash,
            msg.sender,
            block.timestamp
        );
    }

    // Lay thong tin benh an
    function getRecord(
        string memory recordId
    ) public view returns (
        bytes32,
        address,
        uint256
    ) {
        Record memory record = records[recordId];

        require(record.createdAt != 0, "Record not found");

        return (
            record.recordHash,
            record.doctor,
            record.createdAt
        );
    }

    // Kiem tra ma bam
    function verifyRecord(
        string memory recordId,
        bytes32 hashToCheck
    ) public view returns (bool) {
        Record memory record = records[recordId];

        if (record.createdAt == 0) {
            return false;
        }

        return record.recordHash == hashToCheck;
    }
}
