<?php

namespace App\Models;

use Exception;
use Framework\Core\Model;
use Framework\Http\Request;

/**
 * Class Song
 *
 * Represents a guitar song arrangement stored in the `songs` database table.
 * Uses the built-in Vaííčko ORM (`Framework\Core\Model`) for CRUD operations
 * and N:1 relation resolution to `App\Models\Artist`.
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
        'artistId',
        'title',
        'difficulty',
        'chords',
        'tags',
        'lyrics',
    ];

    protected ?int $id = null;
    protected ?int $artistId = null;
    protected ?string $title = null;
    protected ?string $difficulty = 'Beginner';
    protected ?string $chords = null;
    protected ?string $tags = null;
    protected ?string $lyrics = null;

    /**
     * Populates the Song model properties from the HTTP request while safely converting
     * the nullable foreign key `artistId` to an integer or null.
     *
     * @param Request $request The incoming HTTP request.
     * @param string[]|null $fields Optional list of allowed fields.
     * @return void
     * @throws Exception
     */
    public function setFromRequest(Request $request, ?array $fields = null): void
    {
        $allowed = $fields ?? static::$fillable ?? [];
        $scalarFields = array_values(array_diff($allowed, ['artistId']));
        parent::setFromRequest($request, $scalarFields);

        if (in_array('artistId', $allowed, true)) {
            $rawArtistId = $request->value('artistId');
            if ($rawArtistId !== null && $rawArtistId !== '' && is_numeric($rawArtistId) && (int)$rawArtistId > 0) {
                $this->artistId = (int)$rawArtistId;
            } else {
                $this->artistId = null;
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistId(): ?int
    {
        return $this->artistId;
    }

    public function setArtistId(?int $artistId): void
    {
        $this->artistId = $artistId;
    }

    /**
     * Retrieves the related Artist entity (N:1 relationship) using the built-in Vaííčko ORM.
     *
     * @return Artist|null
     * @throws Exception
     */
    public function getArtist(): ?Artist
    {
        if ($this->artistId === null) {
            return null;
        }

        try {
            /** @var Artist|null $artist */
            $artist = $this->getOneRelated(Artist::class);
            return $artist;
        } catch (Exception) {
            return Artist::getOne($this->artistId);
        }
    }

    /**
     * Returns the name of the related Artist or a fallback label if no artist is assigned.
     *
     * @return string
     * @throws Exception
     */
    public function getArtistName(): string
    {
        return $this->getArtist()?->getName() ?? 'Unassigned';
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
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
