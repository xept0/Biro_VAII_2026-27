<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Artist $artist */
/** @var \App\Models\Song[] $songs */
?>
<div class="page-header">
    <div class="title-group">
        <h1><?= e($artist->getName()) ?></h1>
        <p>
            <?= e($artist->getGenre() ?: 'General guitar repertoire') ?>
            <?= $artist->getCountry() ? ' · ' . e($artist->getCountry()) : '' ?>
        </p>
    </div>
    <div class="action-buttons">
        <a href="<?= $link->url('artist.index') ?>" class="btn-secondary">← Back to Artists</a>
        <a href="<?= $link->url('song.add', ['artistId' => $artist->getId()]) ?>" class="btn-secondary">+ Add Song for Artist</a>
        <a href="<?= $link->url('artist.edit', ['id' => $artist->getId()]) ?>" class="btn-primary">Edit Artist & Links</a>
        <form method="post" action="<?= $link->url('artist.delete', ['id' => $artist->getId()]) ?>" class="inline-form">
            <button type="submit" class="btn-danger">Delete Artist</button>
        </form>
    </div>
</div>

<section class="stats" aria-label="Artist metadata">
    <div class="stat-card">
        <span class="stat-label">Artist Name</span>
        <span class="stat-meta"><?= e($artist->getName()) ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Genre</span>
        <span class="stat-meta"><?= e($artist->getGenre() ?: 'Not specified') ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Country</span>
        <span class="stat-meta"><?= e($artist->getCountry() ?: 'Not specified') ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Linked Songs</span>
        <span class="stat-meta"><?= count($songs) ?></span>
    </div>
</section>

<!-- Artist biography and optional image -->
<section class="catalog-list artist-bio-section" aria-labelledby="artist-bio-heading">
    <div class="list-header">
        <h2 id="artist-bio-heading">About Artist</h2>
        <a href="<?= $link->url('artist.edit', ['id' => $artist->getId()]) ?>" class="open-list">Edit biography →</a>
    </div>
    <div class="artist-profile-content">
        <?php if (trim((string)$artist->getImageUrl()) !== '') { ?>
            <div class="artist-image-wrapper">
                <img src="<?= e($artist->getImageUrl()) ?>" alt="<?= e($artist->getName()) ?>" class="artist-image">
            </div>
        <?php } ?>
        <div class="artist-bio-text">
            <?php if (trim((string)$artist->getBio()) !== '') { ?>
                <p><?= nl2br(e($artist->getBio())) ?></p>
            <?php } else { ?>
                <p class="empty-state">No biography has been added for this artist yet.</p>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Linked Songs (1:N relationship) -->
<section class="catalog-list" aria-labelledby="artist-songs-heading">
    <div class="list-header">
        <h2 id="artist-songs-heading">Songs by <?= e($artist->getName()) ?> (<?= count($songs) ?>)</h2>
        <div class="row-actions">
            <a href="<?= $link->url('artist.edit', ['id' => $artist->getId()]) ?>" class="open-list">Manage song links →</a>
            <a href="<?= $link->url('song.add', ['artistId' => $artist->getId()]) ?>" class="btn-secondary">+ Add New Song</a>
        </div>
    </div>

    <?php if (empty($songs)) { ?>
        <p class="empty-state">
            No songs are currently linked to this artist.
            <a href="<?= $link->url('song.add', ['artistId' => $artist->getId()]) ?>" class="open-list">Create a new song for <?= e($artist->getName()) ?></a>
            or <a href="<?= $link->url('artist.edit', ['id' => $artist->getId()]) ?>" class="open-list">link existing songs</a>.
        </p>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="songs-table">
                <thead>
                <tr>
                    <th>☆</th>
                    <th>Song / Arrangement</th>
                    <th>Difficulty</th>
                    <th>Chords</th>
                    <th>Tags</th>
                    <th>Detail</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($songs as $song) { ?>
                    <tr>
                        <td>☆</td>
                        <td>
                            <a href="<?= $link->url('song.show', ['id' => $song->getId()]) ?>" class="song-title-link">
                                <strong><?= e($song->getTitle()) ?></strong>
                            </a><br>
                            <small>Simplified arrangement · chords</small>
                        </td>
                        <td><?= e($song->getDifficulty()) ?></td>
                        <td><?= e($song->getChords()) ?></td>
                        <td><?= e($song->getTags() ?: '—') ?></td>
                        <td>
                            <a href="<?= $link->url('song.show', ['id' => $song->getId()]) ?>" class="btn-secondary">View</a>
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="<?= $link->url('song.edit', ['id' => $song->getId()]) ?>" class="btn-secondary">Edit</a>
                                <form method="post" action="<?= $link->url('song.delete', ['id' => $song->getId()]) ?>" class="inline-form">
                                    <button type="submit" class="btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</section>
