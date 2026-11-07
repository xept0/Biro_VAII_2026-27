<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Class Song
 *
 * Represents a guitar song arrangement stored in the `songs` database table.
 * Uses the built-in Vaííčko ORM (`Framework\Core\Model`) for CRUD operations.
 *
 * @package App\Models
 */
class Song extends Model
{
    public const DIFFICULTIES = ['Beginner', 'Intermediate', 'Advanced'];

    protected static ?string $tableName = 'songs';
    protected static ?string $primaryKey = 'id';

    /**
     * Whitelist of properties that can be populated via Model::setFromRequest().
     *
     * @var string[]|null
     */
    protected static ?array $fillable = [
        'title',
        'artist',
        'difficulty',
        'chords',
        'tags',
        'lyrics',
    ];

    protected ?int $id = null;
    protected ?string $title = null;
    protected ?string $artist = null;
    protected ?string $difficulty = 'Beginner';
    protected ?string $chords = null;
    protected ?string $tags = null;
    protected ?string $lyrics = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(?string $artist): void
    {
        $this->artist = $artist;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getChords(): ?string
    {
        return $this->chords;
    }

    public function setChords(?string $chords): void
    {
        $this->chords = $chords;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): void
    {
        $this->tags = $tags;
    }

    public function getLyrics(): ?string
    {
        return $this->lyrics;
    }

    public function setLyrics(?string $lyrics): void
    {
        $this->lyrics = $lyrics;
    }
}
