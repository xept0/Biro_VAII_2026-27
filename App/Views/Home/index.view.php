<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
?>
<div class="page-header">
    <div class="title-group">
        <h1>Dashboard</h1>
        <p>Welcome to <?= App\Configuration::APP_NAME ?> – your self-hosted library of guitar chords and tabs.</p>
    </div>
    <a href="<?= $link->url('song.index') ?>" class="btn-primary">Browse Song Library →</a>
</div>

<!-- Library statistics -->
<section class="stats" aria-label="Library statistics">
    <div class="stat-card">
        <span class="stat-value">18</span>
        <span class="stat-label">Songs</span>
    </div>
    <div class="stat-card">
        <span class="stat-value">12</span>
        <span class="stat-label">Artists</span>
    </div>
    <div class="stat-card">
        <span class="stat-value">11</span>
        <span class="stat-label">No barre arrangements</span>
    </div>
    <div class="stat-card">
        <span class="stat-value">7</span>
        <span class="stat-label">PDF tabs</span>
    </div>
</section>

<!-- Quick search -->
<section class="filters" aria-label="Quick search">
    <form class="quick-search" action="#" role="search">
        <div class="input-group">
            <label for="quick-search">Quick search</label>
            <input type="search" id="quick-search" placeholder="🔍 Song, artist or chord...">
        </div>
        <button type="submit" class="btn-primary">Search</button>
    </form>
</section>

<!-- Latest songs -->
<section class="catalog-list" aria-labelledby="latest-heading">
    <div class="list-header">
        <h2 id="latest-heading">Recently added songs</h2>
        <a href="<?= $link->url('song.index') ?>" class="open-list">Show all →</a>
    </div>
    <ul class="latest-songs">
        <li>
            <div>
                <strong>Zombie</strong>
                <small>The Cranberries · Em · C · G · D</small>
            </div>
            <span class="tag">Beginner</span>
        </li>
        <li>
            <div>
                <strong>Wonderwall</strong>
                <small>Oasis · Em7 · G · Dsus4 · A7sus4</small>
            </div>
            <span class="tag">Intermediate</span>
        </li>
        <li>
            <div>
                <strong>Come As You Are</strong>
                <small>Nirvana · Em · D · Am · C</small>
            </div>
            <span class="tag">Beginner</span>
        </li>
    </ul>
</section>

<!-- Practice list widget -->
<aside class="practice-widget">
    <div class="widget-info">
        <strong>My practice list · Evening warmup</strong>
        <p>3 songs · Zombie, Wonderwall, Free Fallin' · for registered guitarist</p>
    </div>
    <a href="#" class="open-list">Open list →</a>
</aside>
