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
        'min_stock',
        'unit',
        'warehouse',
        'description',
    ];

    protected ?int $id = null;
    protected ?string $title = null;
    protected ?string $code = null;
    protected ?int $in_stock = null;
    protected ?int $min_stock = null;
    protected ?string $unit = null;
    protected ?string $warehouse = null;
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

    public function getMinStock(): ?int
    {
        return $this->min_stock;
    }

    public function setMinStock(?int $min_stock): self
    {
        $this->min_stock = $min_stock;
        return $this;
    }

    /**
     * Checks if the material stock is at a critical level (in stock is less than minimal stock).
     *
     * @return bool
     */
    public function isCritical(): bool
    {
        return ($this->in_stock ?? 0) < ($this->min_stock ?? 0);
    }

    /**
     * Checks if the material stock is saturated (in stock is greater than or equal to minimal stock).
     *
     * @return bool
     */
    public function isSaturated(): bool
    {
        return ($this->in_stock ?? 0) >= ($this->min_stock ?? 0);
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

    /**
     * Dynamically determines the status of the material based on stock levels.
     *
     * @return string 'Kritický' if in_stock < min_stock, otherwise 'Saturovaný'
     */
    public function getStatus(): string
    {
        return $this->isCritical() ? 'Kritický' : 'Saturovaný';
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
        return $this->isCritical() ? 'badge-critical' : 'badge-active';
    }
}
