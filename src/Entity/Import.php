<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Enum\ImportStatus;
use App\Enum\ImportType;
use App\Repository\ImportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImportRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Import
{
    use Blameable;
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $caption;

    #[ORM\Column(enumType: ImportType::class)]
    private ImportType $type;

    #[ORM\Column(enumType: ImportStatus::class)]
    private ImportStatus $status;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Hospital $hospital;

    #[ORM\Column]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    protected User $createdBy;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    protected ?User $updatedBy = null;

    #[ORM\Column(length: 255)]
    private string $filePath;

    #[ORM\Column(length: 255)]
    private string $fileType;

    #[ORM\Column(length: 255)]
    private string $fileExtension;

    #[ORM\Column]
    private int $fileSize = 0;

    #[ORM\Column]
    private int $runTime = 0;

    #[ORM\Column]
    private int $runCount = 0;

    #[ORM\Column]
    private int $rowCount = 0;

    #[ORM\Column]
    private int $skippedRows = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastError = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): static
    {
        $this->caption = $caption;

        return $this;
    }

    public function getType(): ImportType
    {
        return $this->type;
    }

    public function setType(ImportType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ImportStatus
    {
        return $this->status;
    }

    public function setStatus(ImportStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getHospital(): Hospital
    {
        return $this->hospital;
    }

    public function setHospital(Hospital $hospital): static
    {
        $this->hospital = $hospital;

        return $this;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getFileType(): string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): static
    {
        $this->fileType = $fileType;

        return $this;
    }

    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    public function setFileExtension(string $fileExtension): static
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getRunTime(): int
    {
        return $this->runTime;
    }

    public function setRunTime(int $runTime): static
    {
        $this->runTime = $runTime;

        return $this;
    }

    public function getRunCount(): int
    {
        return $this->runCount;
    }

    public function setRunCount(int $runCount): static
    {
        $this->runCount = $runCount;

        return $this;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function setRowCount(int $rowCount): static
    {
        $this->rowCount = $rowCount;

        return $this;
    }

    public function getSkippedRows(): int
    {
        return $this->skippedRows;
    }

    public function setSkippedRows(int $skippedRows): static
    {
        $this->skippedRows = $skippedRows;

        return $this;
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    public function setLastError(?string $lastError): static
    {
        $this->lastError = $lastError;

        return $this;
    }
}
