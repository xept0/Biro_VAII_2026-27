<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Song $song */
/** @var \App\Models\Artist[] $artists */
/** @var array<string, string> $errors */
/** @var string $formAction */
/** @var string $submitLabel */
?>
<?php if (!empty($errors)) { ?>
    <div class="alert-error" role="alert">
        <strong>Please fix the following errors:</strong>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?= e($error) ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<section class="catalog-list">
    <form method="post" action="<?= $formAction ?>" class="song-form">
        <?php if ($song->getId() !== null) { ?>
            <input type="hidden" name="id" value="<?= e($song->getId()) ?>">
        <?php } ?>

        <div class="form-row">
            <div class="input-group">
                <label for="song-title">Song Title *</label>
                <input
                    type="text"
                    id="song-title"
                    name="title"
                    value="<?= e($song->getTitle()) ?>"
                    placeholder="E.g. Come As You Are"
                    required
                >
            </div>

            <div class="input-group">
                <div class="label-with-link">
                    <label for="song-artist">Artist / Band *</label>
                    <a href="<?= $link->url('artist.add') ?>" class="open-list">+ New artist</a>
                </div>
                <select id="song-artist" name="artistId" required>
                    <option value="">-- Select an artist --</option>
                    <?php foreach ($artists as $artistOption) { ?>
                        <option
                            value="<?= e($artistOption->getId()) ?>"
                            <?= $song->getArtistId() === $artistOption->getId() ? 'selected' : '' ?>
                        >
                            <?= e($artistOption->getName()) ?>
                            <?= $artistOption->getGenre() ? ' (' . e($artistOption->getGenre()) . ')' : '' ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="input-group">
                <label for="song-difficulty">Difficulty *</label>
                <select id="song-difficulty" name="difficulty" required>
                    <?php foreach (\App\Models\Song::DIFFICULTIES as $diffOption) { ?>
                        <option value="<?= e($diffOption) ?>" <?= $song->getDifficulty() === $diffOption ? 'selected' : '' ?>>
                            <?= e($diffOption) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="input-group">
                <label for="song-chords">Chords *</label>
                <input
                    type="text"
                    id="song-chords"
                    name="chords"
                    value="<?= e($song->getChords()) ?>"
                    placeholder="E.g. Em · D · Am · C"
                    required
                >
            </div>
        </div>

        <div class="input-group">
            <label for="song-tags">Tags (comma-separated)</label>
            <input
                type="text"
                id="song-tags"
                name="tags"
                value="<?= e($song->getTags()) ?>"
                placeholder="E.g. No barre, 90s rock, Open chords"
            >
        </div>

        <div class="input-group">
            <label for="song-lyrics">Chord Sheet / Lyrics with Chords</label>
            <textarea
                id="song-lyrics"
                name="lyrics"
                rows="12"
                placeholder="[Intro]&#10;Em  D  Em  D&#10;&#10;[Verse 1]&#10;Em              D&#10;Come as you are..."
            ><?= e($song->getLyrics()) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><?= e($submitLabel) ?></button>
            <a href="<?= $link->url('song.index') ?>" class="btn-secondary">Cancel</a>
        </div>
    </form>
</section>
