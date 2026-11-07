<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Song[] $latestSongs */
/** @var int $songsCount */
/** @var int $artistsCount */
/** @var int $noBarreCount */
?>
<div class="page-header">
    <div class="title-group">
        <h1>Dashboard</h1>
        <p>Welcome to <?= App\Configuration::APP_NAME ?> – your self-hosted library of guitar chords and tabs.</p>
    </div>
    <div class="action-buttons">
        <a href="<?= $link->url('song.add') ?>" class="btn-secondary">+ Add Song</a>
        <a href="<?= $link->url('song.index') ?>" class="btn-primary">Browse Song Library →</a>
    </div>
</div>

<!-- Library statistics -->
<section class="stats" aria-label="Library statistics">
    <div class="stat-card">
        <span class="stat-value"><?= e($songsCount) ?></span>
        <span class="stat-label">Songs</span>
    </div>
    <div class="stat-card">
        <span class="stat-value"><?= e($artistsCount) ?></span>
        <span class="stat-label">Artists</span>
    </div>
    <div class="stat-card">
        <span class="stat-value"><?= e($noBarreCount) ?></span>
        <span class="stat-label">No barre arrangements</span>
    </div>
    <div class="stat-card">
        <span class="stat-value"><?= e($songsCount) ?></span>
        <span class="stat-label">Chord sheets</span>
    </div>
</section>

<!-- Quick search -->
<section class="filters" aria-label="Quick search">
    <form class="quick-search" action="<?= $link->url('song.index') ?>" method="get" role="search">
        <input type="hidden" name="c" value="song">
        <div class="input-group">
            <label for="quick-search">Quick search</label>
            <input type="search" id="quick-search" name="q" placeholder="🔍 Song, artist or chord...">
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
    <?php if (empty($latestSongs)) { ?>
        <p class="empty-state">No songs in the library yet. <a href="<?= $link->url('song.add') ?>" class="open-list">Add the first song →</a></p>
    <?php } else { ?>
        <ul class="latest-songs">
            <?php foreach ($latestSongs as $song) { ?>
                <li>
                    <div>
                        <a href="<?= $link->url('song.show', ['id' => $song->getId()]) ?>" class="song-title-link">
                            <strong><?= e($song->getTitle()) ?></strong>
                        </a>
                        <small><?= e($song->getArtist()) ?> · <?= e($song->getChords()) ?></small>
                    </div>
                    <span class="tag"><?= e($song->getDifficulty()) ?></span>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</section>

<!-- Practice list widget -->
<aside class="practice-widget">
    <div class="widget-info">
        <strong>My practice list · Evening warmup</strong>
        <p>3 songs · Zombie, Wonderwall, Free Fallin' · for registered guitarist</p>
    </div>
    <a href="<?= $link->url('song.index') ?>" class="open-list">Open library →</a>
</aside>
