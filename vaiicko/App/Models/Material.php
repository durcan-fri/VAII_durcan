<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Class Material
 *
 * Represents a material item in the inventory/warehouse database.
 *
 * @package App\Models
 */
class Material extends Model
{
    protected static ?string $tableName = 'materials';
    protected static ?string $primaryKey = 'id';

    protected static ?array $fillable = [
        'title',
        'code',
        'in_stock',
        'unit',
        'warehouse',
        'status',
        'description',
    ];

    protected ?int $id = null;
    protected ?string $title = null;
    protected ?string $code = null;
    protected ?int $in_stock = null;
    protected ?string $unit = null;
    protected ?string $warehouse = null;
    protected ?string $status = null;
    protected ?string $description = null;
    protected ?string $created_at = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getInStock(): ?int
    {
        return $this->in_stock;
    }

    public function setInStock(?int $in_stock): self
    {
        $this->in_stock = $in_stock;
        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    public function getWarehouse(): ?string
    {
        return $this->warehouse;
    }

    public function setWarehouse(?string $warehouse): self
    {
        $this->warehouse = $warehouse;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }


    /**
     * Returns CSS class for the status badge.
     *
     * @return string
     */
    public function getStatusBadgeClass(): string
    {
        return match (mb_strtolower(trim($this->status ?? ''))) {
            'aktívny', 'aktivny', 'active' => 'badge-active',
            'rezerva', 'reserve' => 'badge-reserve',
            'kritický', 'kriticky', 'critical' => 'badge-critical',
            default => 'badge-active',
        };
    }
}
