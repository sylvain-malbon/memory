<?php
namespace App\Classes;

class Game {
    private int $id;
    private string $playerName;
    private int $pairs;
    private int $moves;
    private float $score;
    private string $createdAt;

    public function __construct(
        int $id,
        string $playerName,
        int $pairs,
        int $moves,
        float $score,
        string $createdAt
    ) {
        $this->id = $id;
        $this->playerName = $playerName;
        $this->pairs = $pairs;
        $this->moves = $moves;
        $this->score = $score;
        $this->createdAt = $createdAt;
    }

    // --- Getters ---
    public function getId(): int { return $this->id; }
    public function getPlayerName(): string { return $this->playerName; }
    public function getPairs(): int { return $this->pairs; }
    public function getMoves(): int { return $this->moves; }
    public function getScore(): float { return $this->score; }
    public function getCreatedAt(): string { return $this->createdAt; }

    // --- Méthodes métier ---
    public function addMove(): void {
        $this->moves++;
        $this->calculateScore();
    }

    private function calculateScore(): void {
        if ($this->pairs > 0) {
            $this->score = $this->moves / $this->pairs;
        }
    }
}
