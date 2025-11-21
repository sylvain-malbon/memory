<?php
namespace App\Classes;

class Card {
    private int $id;
    private string $name;
    private string $image;
    private string $status;

    public const STATUS_HIDDEN = 'hidden';
    public const STATUS_VISIBLE = 'visible';
    public const STATUS_MATCHED = 'matched';

    public function __construct(int $id, string $name, string $image, string $status = self::STATUS_HIDDEN) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->status = $status;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getImage(): string { return $this->image; }
    public function getStatus(): string { return $this->status; }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function flip(): void {
        $this->status = ($this->status === self::STATUS_HIDDEN)
            ? self::STATUS_VISIBLE
            : self::STATUS_HIDDEN;
    }

    public function match(): void {
        $this->status = self::STATUS_MATCHED;
    }
}
