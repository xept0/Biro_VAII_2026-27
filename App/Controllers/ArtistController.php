<?php

namespace App\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class ArtistController
 * Handles CRUD operations for the `Artist` entity and manages its 1:N relationship with `Song` records.
 *
 * Uses the built-in Vaííčko ORM (`App\Models\Artist` and `App\Models\Song`).
 *
 * @package App\Controllers
 */
class ArtistController extends BaseController
{
    /**
     * Authorizes controller actions based on the specified action name.
     *
     * All actions are public so that CRUD operations can be tested and used without requiring authentication.
     *
     * @param Request $request The incoming HTTP request.
     * @param string $action The action name to authorize.
     * @return bool Returns true, allowing all actions.
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * Displays the catalog of artists loaded from the database (Read – list).
     *
     * Supports optional filtering by search text (name, genre, country, biography) and country.
     *
     * @param Request $request The incoming HTTP request.
     * @return Response The response object containing the rendered HTML for the artist list.
     * @throws Exception If a database query fails.
     */
    public function index(Request $request): Response
    {
        $search = trim((string)($request->get('q') ?? ''));
        $country = trim((string)($request->get('country') ?? ''));

        $conditions = [];
        $params = [];

        if ($search !== '') {
            $conditions[] = '(`name` LIKE ? OR `genre` LIKE ? OR `country` LIKE ? OR `bio` LIKE ?)';
            $like = '%' . $search . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if ($country !== '') {
            $conditions[] = '`country` = ?';
            $params[] = $country;
        }

        $whereClause = !empty($conditions) ? implode(' AND ', $conditions) : null;
        $artists = Artist::getAll($whereClause, $params, '`name` ASC');

        $allArtists = Artist::getAll(orderBy: '`country` ASC');
        $countries = [];
        foreach ($allArtists as $artistItem) {
            $countryVal = trim((string)$artistItem->getCountry());
            if ($countryVal !== '' && !in_array($countryVal, $countries, true)) {
                $countries[] = $countryVal;
            }
        }

        return $this->html([
            'artists' => $artists,
            'search' => $search,
            'country' => $country,
            'countries' => $countries,
        ]);
    }

    /**
     * Displays the detail page of a single artist along with their linked songs (Read – detail).
     *
     * @param Request $request The incoming HTTP request.
     * @return Response The response object containing the rendered artist detail.
     * @throws Exception If the artist does not exist or a database error occurs.
     */
    public function show(Request $request): Response
    {
        $id = $request->value('id');
        $artist = Artist::getOne($id);
        if ($artist === null) {
            throw new HttpException(404, 'Requested artist was not found.');
        }

        $songs = $artist->getSongs();

        return $this->html([
            'artist' => $artist,
            'songs' => $songs,
        ]);
    }

    /**
     * Displays the form for adding a new artist and handles form submission (Create).
     *
     * Also allows assigning existing songs to the newly created artist (1:N relationship).
     *
     * @param Request $request The incoming HTTP request.
     * @return Response Redirects to the artist list on success or renders the form view.
     * @throws Exception If a database error occurs.
     */
    public function add(Request $request): Response
    {
        $artist = new Artist();
        $allSongs = Song::getAll(orderBy: '`title` ASC');
        $selectedSongIds = [];
        $errors = [];

        if ($request->isPost()) {
            $selectedSongIds = $this->extractSelectedSongIds($request);
            $errors = $this->populateAndValidate($request, $artist);
            if (empty($errors)) {
                $artist->save();
                $this->syncArtistSongs($artist, $selectedSongIds);
                return $this->redirect($this->url('artist.index'));
            }
        }

        return $this->html([
            'artist' => $artist,
            'allSongs' => $allSongs,
            'selectedSongIds' => $selectedSongIds,
            'errors' => $errors,
        ]);
    }

    /**
     * Displays the form for editing an existing artist and handles form submission (Update).
     *
     * Allows updating both the artist's attributes and the list of songs linked to this artist.
     *
     * @param Request $request The incoming HTTP request.
     * @return Response Redirects to the artist list on success or renders the edit form view.
     * @throws Exception If the artist is not found or a database error occurs.
     */
    public function edit(Request $request): Response
    {
        $id = $request->value('id');
        $artist = Artist::getOne($id);
        if ($artist === null) {
            throw new HttpException(404, 'Requested artist was not found.');
        }

        $allSongs = Song::getAll(orderBy: '`title` ASC');
        $selectedSongIds = array_map(fn(Song $song) => (int)$song->getId(), $artist->getSongs());
        $errors = [];

        if ($request->isPost()) {
            $selectedSongIds = $this->extractSelectedSongIds($request);
            $errors = $this->populateAndValidate($request, $artist);
            if (empty($errors)) {
                $artist->save();
                $this->syncArtistSongs($artist, $selectedSongIds);
                return $this->redirect($this->url('artist.index'));
            }
        }

        return $this->html([
            'artist' => $artist,
            'allSongs' => $allSongs,
            'selectedSongIds' => $selectedSongIds,
            'errors' => $errors,
        ]);
    }

    /**
     * Deletes an existing artist from the database and redirects to the updated artist list (Delete).
     *
     * Due to the `ON DELETE SET NULL` foreign key constraint, songs previously linked to this artist
     * remain in the database as unassigned.
     *
     * @param Request $request The incoming HTTP request.
     * @return Response Redirects to the artist catalog page.
     * @throws Exception If a database error occurs.
     */
    public function delete(Request $request): Response
    {
        $id = $request->value('id');
        $artist = Artist::getOne($id);
        if ($artist !== null) {
            $artist->delete();
        }

        return $this->redirect($this->url('artist.index'));
    }

    /**
     * Populates the Artist model from the request using the ORM and performs basic validation.
     *
     * @param Request $request The incoming HTTP request.
     * @param Artist $artist The artist model instance to populate.
     * @return array<string, string> Validation error messages indexed by field name.
     * @throws Exception If model mass-assignment whitelist is misconfigured.
     */
    private function populateAndValidate(Request $request, Artist $artist): array
    {
        $artist->setFromRequest($request);

        $artist->setName(trim((string)$artist->getName()));
        $genre = trim((string)$artist->getGenre());
        $country = trim((string)$artist->getCountry());
        $bio = trim((string)$artist->getBio());
        $imageUrl = trim((string)$artist->getImageUrl());

        $artist->setGenre($genre !== '' ? $genre : null);
        $artist->setCountry($country !== '' ? $country : null);
        $artist->setBio($bio !== '' ? $bio : null);
        $artist->setImageUrl($imageUrl !== '' ? $imageUrl : null);

        $errors = [];

        if ($artist->getName() === '') {
            $errors['name'] = 'Artist / band name is required.';
        }

        return $errors;
    }

    /**
     * Extracts the array of selected song IDs submitted from the artist form.
     *
     * @param Request $request The incoming HTTP request.
     * @return int[] List of selected song IDs.
     */
    private function extractSelectedSongIds(Request $request): array
    {
        $rawIds = $request->post('songIds') ?? [];
        if (!is_array($rawIds)) {
            return [];
        }

        $ids = [];
        foreach ($rawIds as $rawId) {
            if (is_numeric($rawId) && (int)$rawId > 0) {
                $ids[] = (int)$rawId;
            }
        }

        return array_values(array_unique($ids));
    }

    /**
     * Updates the 1:N relationship between this artist and songs using the Vaííčko ORM.
     *
     * Songs checked in the form are assigned to this artist; songs unchecked that previously belonged
     * to this artist are unassigned (`artistId = null`).
     *
     * @param Artist $artist The saved artist entity.
     * @param int[] $selectedSongIds IDs of songs that should belong to this artist.
     * @return void
     * @throws Exception If a database query fails.
     */
    private function syncArtistSongs(Artist $artist, array $selectedSongIds): void
    {
        $artistId = $artist->getId();
        if ($artistId === null) {
            return;
        }

        $allSongs = Song::getAll();
        foreach ($allSongs as $song) {
            $songId = (int)$song->getId();
            $isSelected = in_array($songId, $selectedSongIds, true);

            if ($isSelected && $song->getArtistId() !== $artistId) {
                $song->setArtistId($artistId);
                $song->save();
            } elseif (!$isSelected && $song->getArtistId() === $artistId) {
                $song->setArtistId(null);
                $song->save();
            }
        }
    }
}
