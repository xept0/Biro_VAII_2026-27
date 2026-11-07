<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Song[] $songs */
?>
<div class="page-header">
    <div class="title-group">
        <h1>Content Management</h1>
        <p>Welcome, <strong><?= e($user->getName()) ?></strong>! Manage songs and guitar arrangements in the database.</p>
    </div>
    <a href="<?= $link->url('song.add') ?>" class="btn-primary">Add Song +</a>
</div>

<section class="catalog-list" aria-label="Managed songs">
    <div class="list-header">
        <h2>All songs in database (<?= count($songs) ?>)</h2>
        <a href="<?= $link->url('song.index') ?>" class="open-list">Public Catalog →</a>
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
                    <tr>
                        <td>#<?= e($song->getId()) ?></td>
                        <td><strong><?= e($song->getTitle()) ?></strong></td>
                        <td><?= e($song->getArtist()) ?></td>
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
