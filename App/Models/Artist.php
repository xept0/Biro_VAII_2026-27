<?php

namespace App\Models;

use Exception;
use Framework\Core\Model;

/**
 * Class Artist
 *
 * Represents a musical artist or band stored in the `artists` database table.
 * Connected to `App\Models\Song` in a 1:N relationship (one artist has many songs)
 * using the built-in Vaííčko ORM (`Framework\Core\Model`).
 *
 * @package App\Models
 */
class Artist extends Model
{
    protected static ?string $tableName = 'artists';
    protected static ?string $primaryKey = 'id';

    /**
     * Whitelist of properties that can be populated via Model::setFromRequest().
     *
     * @var string[]|null
     */
    protected static ?array $fillable = [
        'name',
        'genre',
        'country',
        'bio',
        'imageUrl',
    ];

    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $genre = null;
    protected ?string $country = null;
    protected ?string $bio = null;
    protected ?string $imageUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * Retrieves all songs belonging to this artist (1:N relation) using the built-in Vaííčko ORM.
     *
     * @return Song[]
     * @throws Exception
     */
    public function getSongs(): array
    {
        if ($this->id === null) {
            return [];
        }

        try {
            /** @var Song[] $songs */
            $songs = $this->getAllRelated(Song::class);
            return $songs;
        } catch (Exception) {
            return Song::getAll('`artistId` = ?', [$this->id], '`id` DESC');
        }
    }
}
