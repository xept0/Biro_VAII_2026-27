<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Song[] $songs */
/** @var string $search */
/** @var string $difficulty */
/** @var string $tag */

$availableTags = ['Open chords', 'No barre', '90s rock', 'Folk rock', 'Rock'];
?>
<div class="page-header">
    <div class="title-group">
        <h1>Song Catalog</h1>
        <p>Find an arrangement you can play. Even without barre chords.</p>
    </div>
    <a href="<?= $link->url('song.add') ?>" class="btn-primary">Add Song +</a>
</div>

<!-- Filters -->
<section class="filters" aria-label="Song filters">
    <form method="get" action="<?= $link->url('song.index') ?>">
        <input type="hidden" name="c" value="song">
        <?php if ($tag !== '') { ?>
            <input type="hidden" name="tag" value="<?= e($tag) ?>">
        <?php } ?>
        <div class="filter-inputs">
            <div class="input-group">
                <label for="filter-text">Song, Artist or Chord</label>
                <input type="text" id="filter-text" name="q" value="<?= e($search) ?>" placeholder="🔍 E.g. Zombie or Nirvana">
            </div>
            <div class="input-group">
                <label for="filter-difficulty">Difficulty</label>
                <select id="filter-difficulty" name="difficulty">
                    <option value="">All difficulties</option>
                    <?php foreach (\App\Models\Song::DIFFICULTIES as $diffOption) { ?>
                        <option value="<?= e($diffOption) ?>" <?= $difficulty === $diffOption ? 'selected' : '' ?>>
                            <?= e($diffOption) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="filter-submit">
                <button type="submit" class="btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <div class="tags-filter">
        <span>Tags:</span>
        <?php foreach ($availableTags as $tagItem) { ?>
            <?php
            $isActiveTag = strcasecmp($tag, $tagItem) === 0;
            $tagUrl = $link->url('song.index', array_filter([
                'q' => $search !== '' ? $search : null,
                'difficulty' => $difficulty !== '' ? $difficulty : null,
                'tag' => $isActiveTag ? null : $tagItem,
            ]));
            ?>
            <a href="<?= $tagUrl ?>" class="tag <?= $isActiveTag ? 'active-tag' : '' ?>">
                <?= $isActiveTag ? '✓ ' : '' ?><?= e($tagItem) ?>
            </a>
        <?php } ?>
        <a href="<?= $link->url('song.index') ?>" class="clear-filters">Clear all filters</a>
    </div>
</section>

<!-- Song list -->
<section class="catalog-list" aria-label="Song list">
    <div class="list-header">
        <span><?= count($songs) ?> <?= count($songs) === 1 ? 'song' : 'songs' ?> in catalog</span>
        <a href="<?= $link->url('song.add') ?>" class="open-list">+ Add new song</a>
    </div>

    <?php if (empty($songs)) { ?>
        <p class="empty-state">
            No songs matched your criteria.
            <a href="<?= $link->url('song.add') ?>" class="open-list">Add a new song</a> or
            <a href="<?= $link->url('song.index') ?>" class="open-list">reset filters</a>.
        </p>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="songs-table">
                <thead>
                <tr>
                    <th>☆</th>
                    <th>Song / Arrangement</th>
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
                        <td>☆</td>
                        <td>
                            <a href="<?= $link->url('song.show', ['id' => $song->getId()]) ?>" class="song-title-link">
                                <strong><?= e($song->getTitle()) ?></strong>
                            </a><br>
                            <small>Simplified arrangement · chords</small>
                        </td>
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

    <p class="footnote">Showing simplified arrangements loaded from the MariaDB database via Vaííčko ORM.</p>
</section>

<!-- Practice list widget -->
<aside class="practice-widget">
    <div class="widget-info">
        <strong>My practice list · Evening warmup</strong>
        <p>3 songs · Zombie, Wonderwall, Free Fallin' · for registered guitarist</p>
    </div>
    <a href="<?= $link->url('home.index') ?>" class="open-list">Back to Dashboard →</a>
</aside>
