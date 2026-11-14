<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Artist $artist */
/** @var \App\Models\Song[] $allSongs */
/** @var int[] $selectedSongIds */
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
        <?php if ($artist->getId() !== null) { ?>
            <input type="hidden" name="id" value="<?= e($artist->getId()) ?>">
        <?php } ?>

        <div class="form-row">
            <div class="input-group">
                <label for="artist-name">Artist / Band Name *</label>
                <input
                    type="text"
                    id="artist-name"
                    name="name"
                    value="<?= e($artist->getName()) ?>"
                    placeholder="E.g. Nirvana"
                    required
                >
            </div>

            <div class="input-group">
                <label for="artist-genre">Genre</label>
                <input
                    type="text"
                    id="artist-genre"
                    name="genre"
                    value="<?= e($artist->getGenre()) ?>"
                    placeholder="E.g. Grunge / Alternative Rock"
                >
            </div>
        </div>

        <div class="form-row">
            <div class="input-group">
                <label for="artist-country">Country / Origin</label>
                <input
                    type="text"
                    id="artist-country"
                    name="country"
                    value="<?= e($artist->getCountry()) ?>"
                    placeholder="E.g. United States"
                >
            </div>

            <div class="input-group">
                <label for="artist-image-url">Image URL (optional)</label>
                <input
                    type="url"
                    id="artist-image-url"
                    name="imageUrl"
                    value="<?= e($artist->getImageUrl()) ?>"
                    placeholder="https://example.com/artist.jpg"
                >
            </div>
        </div>

        <div class="input-group">
            <label for="artist-bio">Biography / Guitar Style Notes</label>
            <textarea
                id="artist-bio"
                name="bio"
                rows="5"
                placeholder="Short description of the artist, signature chord progressions, or strumming style..."
            ><?= e($artist->getBio()) ?></textarea>
        </div>

        <div class="input-group">
            <label>Linked Songs (1:N Relationship – select songs belonging to this artist)</label>
            <?php if (empty($allSongs)) { ?>
                <p class="empty-state">No songs exist in the database yet. You can add songs in the Song Catalog.</p>
            <?php } else { ?>
                <div class="checkbox-grid">
                    <?php foreach ($allSongs as $songItem) { ?>
                        <?php
                        $songId = (int)$songItem->getId();
                        $isChecked = in_array($songId, $selectedSongIds, true);
                        $currentArtistName = $songItem->getArtist()?->getName();
                        ?>
                        <label class="checkbox-item">
                            <input
                                type="checkbox"
                                name="songIds[]"
                                value="<?= e($songId) ?>"
                                <?= $isChecked ? 'checked' : '' ?>
                            >
                            <span>
                                <strong><?= e($songItem->getTitle()) ?></strong>
                                <small>
                                    (<?= e($songItem->getChords()) ?> ·
                                    <?= $currentArtistName !== null ? 'Current artist: ' . e($currentArtistName) : 'Unassigned' ?>)
                                </small>
                            </span>
                        </label>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><?= e($submitLabel) ?></button>
            <a href="<?= $link->url('artist.index') ?>" class="btn-secondary">Cancel</a>
        </div>
    </form>
</section>
