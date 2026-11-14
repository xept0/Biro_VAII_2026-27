<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Song[] $songs */
/** @var \App\Models\Artist[] $artists */
?>
<div class="page-header">
    <div class="title-group">
        <h1>Content Management</h1>
        <p>Welcome, <strong><?= e($user->getName()) ?></strong>! Manage artists, songs, and guitar arrangements in the database.</p>
    </div>
    <div class="action-buttons">
        <a href="<?= $link->url('artist.add') ?>" class="btn-secondary">Add Artist +</a>
        <a href="<?= $link->url('song.add') ?>" class="btn-primary">Add Song +</a>
    </div>
</div>

<!-- Managed Artists -->
<section class="catalog-list admin-section-card" aria-label="Managed artists">
    <div class="list-header">
        <h2>All artists in database (<?= count($artists) ?>)</h2>
        <a href="<?= $link->url('artist.index') ?>" class="open-list">Public Artists Catalog →</a>
    </div>

    <?php if (empty($artists)) { ?>
        <p class="empty-state">No artists in the database yet. <a href="<?= $link->url('artist.add') ?>" class="open-list">Create the first artist →</a></p>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="songs-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Artist / Band</th>
                    <th>Genre</th>
                    <th>Country</th>
                    <th>Songs (1:N)</th>
                    <th>Detail</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($artists as $artist) { ?>
                    <?php $artistSongs = $artist->getSongs(); ?>
                    <tr>
                        <td>#<?= e($artist->getId()) ?></td>
                        <td><strong><?= e($artist->getName()) ?></strong></td>
                        <td><?= e($artist->getGenre() ?: '—') ?></td>
                        <td><?= e($artist->getCountry() ?: '—') ?></td>
                        <td><?= count($artistSongs) ?></td>
                        <td>
                            <a href="<?= $link->url('artist.show', ['id' => $artist->getId()]) ?>" class="btn-secondary">View</a>
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="<?= $link->url('artist.edit', ['id' => $artist->getId()]) ?>" class="btn-secondary">Edit</a>
                                <form method="post" action="<?= $link->url('artist.delete', ['id' => $artist->getId()]) ?>" class="inline-form">
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

<!-- Managed Songs -->
<section class="catalog-list" aria-label="Managed songs">
    <div class="list-header">
        <h2>All songs in database (<?= count($songs) ?>)</h2>
        <a href="<?= $link->url('song.index') ?>" class="open-list">Public Song Catalog →</a>
    </div>

    <?php if (empty($songs)) { ?>
        <p class="empty-state">No songs in the database yet. <a href="<?= $link->url('song.add') ?>" class="open-list">Create the first song →</a></p>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="songs-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Song Title</th>
                    <th>Artist</th>
                    <th>Difficulty</th>
                    <th>Chords</th>
                    <th>Tags</th>
                    <th>Detail</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($songs as $song) { ?>
                    <?php $artist = $song->getArtist(); ?>
                    <tr>
                        <td>#<?= e($song->getId()) ?></td>
                        <td><strong><?= e($song->getTitle()) ?></strong></td>
                        <td>
                            <?php if ($artist !== null) { ?>
                                <a href="<?= $link->url('artist.show', ['id' => $artist->getId()]) ?>" class="open-list">
                                    <?= e($artist->getName()) ?>
                                </a>
                            <?php } else { ?>
                                Unassigned
                            <?php } ?>
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
