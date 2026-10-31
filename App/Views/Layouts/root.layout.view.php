<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */

// URL of the currently displayed page (current controller + action) - used to highlight the active menu item
$currentUrl = $link->url([]);

/**
 * Returns the CSS class for a navigation link, "active" if the link points to the currently displayed page.
 */
$navClass = fn(string $destination): string => $link->url($destination) === $currentUrl ? 'active' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= App\Configuration::APP_NAME ?></title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $link->asset('favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $link->asset('favicons/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $link->asset('favicons/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= $link->asset('favicons/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= $link->asset('favicons/favicon.ico') ?>">
    <!-- Application styles -->
    <link rel="stylesheet" href="<?= $link->asset('css/style.css') ?>">
</head>
<body>
<!-- Header -->
<header class="top-header">
    <a class="logo" href="<?= $link->url('home.index') ?>">
        <img src="<?= $link->asset('images/logo.svg') ?>" alt="" width="32" height="32">
        <span><?= App\Configuration::APP_NAME ?></span>
    </a>
    <form class="search-bar" action="#" role="search">
        <label for="global-search" class="visually-hidden">Search the entire library</label>
        <input type="search" id="global-search" placeholder="🔍 Search the entire library...">
    </form>
    <div class="user-profile">
        <?php if ($user->isLoggedIn()) { ?>
            <div class="avatar"><?= e(strtoupper(substr($user->getName(), 0, 2))) ?></div>
            <div class="user-info">
                <strong><?= e($user->getName()) ?></strong>
                <a href="<?= $link->url('auth.logout') ?>">Log out</a>
            </div>
        <?php } else { ?>
            <div class="avatar">?</div>
            <div class="user-info">
                <strong>Visitor</strong>
                <a href="<?= App\Configuration::LOGIN_URL ?>">Log in</a>
            </div>
        <?php } ?>
    </div>
</header>

<div class="app-container">
    <!-- Sidenav -->
    <aside class="sidebar">
        <nav aria-label="Main navigation">
            <div class="nav-section">MAIN NAVIGATION</div>
            <ul>
                <li><a href="<?= $link->url('home.index') ?>" class="<?= $navClass('home.index') ?>">Dashboard</a></li>
                <li><a href="<?= $link->url('song.index') ?>" class="<?= $navClass('song.index') ?>">Song Library</a></li>
                <!-- Pages below are not implemented yet -->
                <li><span class="nav-disabled" title="Coming soon">Artists</span></li>
                <li><span class="nav-disabled" title="Coming soon">Favorites</span></li>
                <li><span class="nav-disabled" title="Coming soon">Practice Lists</span></li>
            </ul>
            <div class="nav-section admin-section">
                <a href="<?= $link->url('admin.index') ?>" class="<?= $navClass('admin.index') ?>">Content Management <span>Admin only</span></a>
            </div>
        </nav>

        <div class="role-info">
            <strong>Role-based access</strong>
            <ul>
                <li>Visitor: public library</li>
                <li>Guitarist: favorites and profile</li>
                <li>Admin: content management</li>
            </ul>
        </div>
    </aside>

    <!-- Main content (rendered from the view selected by the controller action) -->
    <main class="main-content">
        <?= $contentHTML ?>
    </main>
</div>

<!-- Footer -->
<footer class="app-footer">
    <div class="footer-left"><?= App\Configuration::APP_NAME ?> · Chords and tabs for guitarists</div>
    <div class="footer-right">Lukáš Bíro · Study group 5ZYI34</div>
</footer>
</body>
</html>
