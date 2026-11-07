<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Song $song */
?>
<div class="page-header">
    <div class="title-group">
        <h1><?= e($song->getTitle()) ?></h1>
        <p><?= e($song->getArtist()) ?> · Simplified guitar arrangement</p>
    </div>
    <div class="action-buttons">
        <a href="<?= $link->url('song.index') ?>" class="btn-secondary">← Back to Catalog</a>
        <a href="<?= $link->url('song.edit', ['id' => $song->getId()]) ?>" class="btn-primary">Edit Song</a>
        <form method="post" action="<?= $link->url('song.delete', ['id' => $song->getId()]) ?>" class="inline-form">
            <button type="submit" class="btn-danger">Delete Song</button>
        </form>
    </div>
</div>

<section class="stats" aria-label="Song metadata">
    <div class="stat-card">
        <span class="stat-label">Artist</span>
        <span class="stat-meta"><?= e($song->getArtist()) ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Difficulty</span>
        <span class="stat-meta"><?= e($song->getDifficulty()) ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Chords</span>
        <span class="stat-meta"><?= e($song->getChords()) ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Tags</span>
        <span class="stat-meta"><?= e($song->getTags() ?: 'None') ?></span>
    </div>
</section>

<section class="catalog-list" aria-labelledby="chord-sheet-heading">
    <div class="list-header">
        <h2 id="chord-sheet-heading">Chord Sheet & Lyrics</h2>
        <a href="<?= $link->url('song.edit', ['id' => $song->getId()]) ?>" class="open-list">Edit chord sheet →</a>
    </div>
    <?php if (trim((string)$song->getLyrics()) !== '') { ?>
        <pre class="chord-sheet"><?= e($song->getLyrics()) ?></pre>
    <?php } else { ?>
        <p class="empty-state">No chord sheet has been added for this song yet.</p>
    <?php } ?>
</section>
