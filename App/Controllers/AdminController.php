<?php

namespace App\Controllers;

use App\Models\Song;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class AdminController
 *
 * This controller manages admin-related actions within the application. It extends the base controller functionality
 * provided by BaseController.
 *
 * @package App\Controllers
 */
class AdminController extends BaseController
{
    /**
     * Authorizes actions in this controller.
     *
     * This method checks if the user is logged in, allowing or denying access to specific actions based
     * on the authentication state.
     *
     * @param Request $request The incoming HTTP request.
     * @param string $action The name of the action to authorize.
     * @return bool Returns true if the user is logged in; false otherwise.
     */
    public function authorize(Request $request, string $action): bool
    {
        return $this->user->isLoggedIn();
    }

    /**
     * Displays the index page of the admin panel (content management overview).
     *
     * This action requires authorization. It returns an HTML response for the admin dashboard.
     *
     * @param Request $request The incoming HTTP request.
     * @return Response Returns a response object containing the rendered HTML.
     * @throws Exception If a database query fails.
     */
    public function index(Request $request): Response
    {
        $songs = Song::getAll(orderBy: '`id` DESC');

        return $this->html([
            'songs' => $songs,
        ]);
    }
}
