<?php
namespace Models;

class Student
{
    /* =====================
       IDS
    ===================== */
    private int $studentId;
    private int $userId;
    private int $careerId;

    /* =====================
       PERSONAL DATA
    ===================== */
    private string $firstName;
    private string $lastName;
    private string $dni;
    private ?string $fileNumber = null;
    private ?string $gender = null;
    private ?string $birthDate = null;
    private ?string $phoneNumber = null;
    private bool $active;

    public function __construct()
    {
        $this->active = true;
    }

    /* =====================
       STUDENT ID
    ===================== */
    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): self
    {
        $this->studentId = $studentId;
        return $this;
    }

    /* =====================
       USER ID
    ===================== */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /* =====================
       CAREER ID
    ===================== */
    public function getCareerId(): int
    {
        return $this->careerId;
    }

    public function setCareerId(int $careerId): self
    {
        $this->careerId = $careerId;
        return $this;
    }

    /* =====================
       DATA
    ===================== */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;
        return $this;
    }

    public function getFileNumber(): ?string
    {
        return $this->fileNumber;
    }

    public function setFileNumber(?string $fileNumber): self
    {
        $this->fileNumber = $fileNumber;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function setBirthDate(?string $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /* =====================
       STATUS
    ===================== */
    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
