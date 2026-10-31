<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class SongController
 * Handles actions related to the song library (catalog of songs and arrangements).
 *
 * All actions of this controller are public - the song library is accessible also to unregistered visitors.
 *
 * @package App\Controllers
 */
class SongController extends BaseController
{
    /**
     * Authorizes controller actions based on the specified action name.
     *
     * The song library is public, so all actions are authorized unconditionally.
     *
     * @param string $action The action name to authorize.
     * @return bool Returns true, allowing all actions.
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * Displays the song catalog page.
     *
     * This action selects the view App/Views/Song/index.view.php, which is rendered inside the common root layout.
     *
     * @return Response The response object containing the rendered HTML for the song catalog.
     */
    public function index(Request $request): Response
    {
        return $this->html();
    }
}
