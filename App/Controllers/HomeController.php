<?php

namespace App\Controllers;

use App\Models\Song;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class HomeController
 * Handles actions related to the home page and other public actions.
 *
 * This controller includes actions that are accessible to all users, including the default landing page (dashboard)
 * of the application. It provides a mechanism for authorizing actions based on user permissions.
 *
 * @package App\Controllers
 */
class HomeController extends BaseController
{
    /**
     * Authorizes controller actions based on the specified action name.
     *
     * In this implementation, all actions are authorized unconditionally.
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
     * Displays the default home page (dashboard) with live statistics and latest songs from the database.
     *
     * This action selects the view App/Views/Home/index.view.php, which is rendered inside the common root layout.
     *
     * @param Request $request The incoming HTTP request.
     * @return Response The response object containing the rendered HTML for the home page.
     * @throws Exception If a database query fails.
     */
    public function index(Request $request): Response
    {
        $songs = Song::getAll(orderBy: '`id` DESC');

        $artists = [];
        $noBarreCount = 0;

        foreach ($songs as $song) {
            $artistName = strtolower(trim((string)$song->getArtist()));
            if ($artistName !== '') {
                $artists[$artistName] = true;
            }
            if (stripos((string)$song->getTags(), 'no barre') !== false) {
                $noBarreCount++;
            }
        }

        return $this->html([
            'latestSongs' => array_slice($songs, 0, 3),
            'songsCount' => count($songs),
            'artistsCount' => count($artists),
            'noBarreCount' => $noBarreCount,
        ]);
    }
}
