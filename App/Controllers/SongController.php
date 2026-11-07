<?php

namespace App\Controllers;

use App\Models\Song;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class SongController
 * Handles CRUD actions for the song library (catalog of songs and guitar arrangements).
 *
 * Uses the built-in Vaííčko ORM (`App\Models\Song`) to list, view, create, update, and delete records.
 *
 * @package App\Controllers
 */
class SongController extends BaseController
{
    /**
     * Authorizes controller actions based on the specified action name.
     *
     * All actions are public so that CRUD operations can be used without requiring authentication.
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
     * Displays the song catalog page with records loaded from the database (Read).
     *
     * Supports optional filtering by text (title, artist, chords), difficulty, and tag.
     *
     * @param Request $request The incoming HTTP request.
     * @return Response The response object containing the rendered HTML for the song catalog.
     * @throws Exception If a database query fails.
     */
    public function index(Request $request): Response
    {
        $search = trim((string)($request->get('q') ?? ''));
        $difficulty = trim((string)($request->get('difficulty') ?? ''));
        $tag = trim((string)($request->get('tag') ?? ''));

        $conditions = [];
        $params = [];

        if ($search !== '') {
            $conditions[] = '(`title` LIKE ? OR `artist` LIKE ? OR `chords` LIKE ?)';
            $like = '%' . $search . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if ($difficulty !== '' && in_array($difficulty, Song::DIFFICULTIES, true)) {
            $conditions[] = '`difficulty` = ?';
            $params[] = $difficulty;
        }

        if ($tag !== '') {
            $conditions[] = '`tags` LIKE ?';
            $params[] = '%' . $tag . '%';
        }

        $whereClause = !empty($conditions) ? implode(' AND ', $conditions) : null;
        $songs = Song::getAll($whereClause, $params, '`id` DESC');

        return $this->html([
            'songs' => $songs,
            'search' => $search,
            'difficulty' => $difficulty,
            'tag' => $tag,
        ]);
    }

    /**
     * Displays the detail page of a single song (Read).
     *
     * @param Request $request The incoming HTTP request.
     * @return Response The response object containing the rendered song detail.
     * @throws Exception If the song does not exist or a database error occurs.
     */
    public function show(Request $request): Response
    {
        $id = $request->value('id');
        $song = Song::getOne($id);
        if ($song === null) {
            throw new HttpException(404, 'Requested song was not found.');
        }

        return $this->html([
            'song' => $song,
        ]);
    }

    /**
     * Displays the form for adding a new song and handles form submission (Create).
     *
     * @param Request $request The incoming HTTP request.
     * @return Response Redirects to the song list on success or renders the form view.
     * @throws Exception If a database error occurs.
     */
    public function add(Request $request): Response
    {
        $song = new Song();
        $errors = [];

        if ($request->isPost()) {
            $errors = $this->populateAndValidate($request, $song);
            if (empty($errors)) {
                $song->save();
                return $this->redirect($this->url('song.index'));
            }
        }

        return $this->html([
            'song' => $song,
            'errors' => $errors,
        ]);
    }

    /**
     * Displays the form for editing an existing song and handles form submission (Update).
     *
     * @param Request $request The incoming HTTP request.
     * @return Response Redirects to the song list on success or renders the edit form view.
     * @throws Exception If the song is not found or a database error occurs.
     */
    public function edit(Request $request): Response
    {
        $id = $request->value('id');
        $song = Song::getOne($id);
        if ($song === null) {
            throw new HttpException(404, 'Requested song was not found.');
        }

        $errors = [];

        if ($request->isPost()) {
            $errors = $this->populateAndValidate($request, $song);
            if (empty($errors)) {
                $song->save();
                return $this->redirect($this->url('song.index'));
            }
        }

        return $this->html([
            'song' => $song,
            'errors' => $errors,
        ]);
    }

    /**
     * Deletes an existing song from the database and redirects to the updated song list (Delete).
     *
     * @param Request $request The incoming HTTP request.
     * @return Response Redirects to the song catalog page.
     * @throws Exception If a database error occurs.
     */
    public function delete(Request $request): Response
    {
        $id = $request->value('id');
        $song = Song::getOne($id);
        if ($song !== null) {
            $song->delete();
        }

        return $this->redirect($this->url('song.index'));
    }

    /**
     * Populates the Song model from the request using the ORM and performs basic validation.
     *
     * @param Request $request The incoming HTTP request.
     * @param Song $song The song model instance to populate.
     * @return array<string, string> Validation error messages indexed by field name.
     * @throws Exception If model mass-assignment whitelist is misconfigured.
     */
    private function populateAndValidate(Request $request, Song $song): array
    {
        $song->setFromRequest($request);

        $song->setTitle(trim((string)$song->getTitle()));
        $song->setArtist(trim((string)$song->getArtist()));
        $song->setDifficulty(trim((string)$song->getDifficulty()));
        $song->setChords(trim((string)$song->getChords()));
        $song->setTags(trim((string)$song->getTags()));
        $song->setLyrics(trim((string)$song->getLyrics()));

        $errors = [];

        if ($song->getTitle() === '') {
            $errors['title'] = 'Song title is required.';
        }

        if ($song->getArtist() === '') {
            $errors['artist'] = 'Artist name is required.';
        }

        if (!in_array($song->getDifficulty(), Song::DIFFICULTIES, true)) {
            $errors['difficulty'] = 'Please select a valid difficulty level.';
        }

        if ($song->getChords() === '') {
            $errors['chords'] = 'Chords are required (e.g. Em · C · G · D).';
        }

        return $errors;
    }
}
