<?php
namespace Models;

class Student extends User
{
    private int $studentId;
    private Career $career;

    private string $firstName;
    private string $lastName;
    private string $dni;
    private ?string $fileNumber = null;
    private ?string $gender = null;
    private ?string $birthDate= null;
    private ?string $phoneNumber= null;
    private bool $active;

    public function __construct()
    {
        parent::__construct();
        $this->setRole(self::ROLE_STUDENT);
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
       CAREER (OBJETO)
    ===================== */

    public function getCareer(): Career
    {
        return $this->career;
    }

    public function setCareer(Career $career): self
    {
        $this->career = $career;
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

    public function setFileNumber(string $fileNumber): self
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
