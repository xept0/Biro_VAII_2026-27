<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Artist[] $artists */
/** @var string $search */
/** @var string $country */
/** @var string[] $countries */
?>
<div class="page-header">
    <div class="title-group">
        <h1>Artists</h1>
        <p>Browse bands and guitarists in the library and manage their linked song repertoires.</p>
    </div>
    <a href="<?= $link->url('artist.add') ?>" class="btn-primary">Add Artist +</a>
</div>

<!-- Filters -->
<section class="filters" aria-label="Artist filters">
    <form method="get" action="<?= $link->url('artist.index') ?>">
        <input type="hidden" name="c" value="artist">
        <div class="filter-inputs">
            <div class="input-group">
                <label for="filter-artist-text">Artist, Genre or Bio</label>
                <input
                    type="text"
                    id="filter-artist-text"
                    name="q"
                    value="<?= e($search) ?>"
                    placeholder="🔍 E.g. Nirvana, Grunge, or Folk Rock"
                >
            </div>
            <div class="input-group">
                <label for="filter-country">Country / Origin</label>
                <select id="filter-country" name="country">
                    <option value="">All countries</option>
                    <?php foreach ($countries as $countryOption) { ?>
                        <option value="<?= e($countryOption) ?>" <?= $country === $countryOption ? 'selected' : '' ?>>
                            <?= e($countryOption) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="filter-submit">
                <button type="submit" class="btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <?php if ($search !== '' || $country !== '') { ?>
        <div class="tags-filter">
            <span>Active filters:</span>
            <?php if ($search !== '') { ?>
                <span class="tag active-tag">Search: <?= e($search) ?></span>
            <?php } ?>
            <?php if ($country !== '') { ?>
                <span class="tag active-tag">Country: <?= e($country) ?></span>
            <?php } ?>
            <a href="<?= $link->url('artist.index') ?>" class="clear-filters">Clear all filters</a>
        </div>
    <?php } ?>
</section>

<!-- Artist list -->
<section class="catalog-list" aria-label="Artist list">
    <div class="list-header">
        <span><?= count($artists) ?> <?= count($artists) === 1 ? 'artist' : 'artists' ?> in catalog</span>
        <a href="<?= $link->url('artist.add') ?>" class="open-list">+ Add new artist</a>
    </div>

    <?php if (empty($artists)) { ?>
        <p class="empty-state">
            No artists matched your criteria.
            <a href="<?= $link->url('artist.add') ?>" class="open-list">Add a new artist</a> or
            <a href="<?= $link->url('artist.index') ?>" class="open-list">reset filters</a>.
        </p>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="songs-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Artist / Band</th>
                    <th>Genre</th>
                    <th>Country</th>
                    <th>Linked Songs (1:N)</th>
                    <th>Detail</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($artists as $artist) { ?>
                    <?php $artistSongs = $artist->getSongs(); ?>
                    <tr>
                        <td>#<?= e($artist->getId()) ?></td>
                        <td>
                            <a href="<?= $link->url('artist.show', ['id' => $artist->getId()]) ?>" class="song-title-link">
                                <strong><?= e($artist->getName()) ?></strong>
                            </a><br>
                            <small>
                                <?php
                                $bio = trim((string)$artist->getBio());
                                echo $bio !== ''
                                    ? e(mb_strlen($bio) > 80 ? mb_substr($bio, 0, 77) . '...' : $bio)
                                    : 'No biography added yet.';
                                ?>
                            </small>
                        </td>
                        <td><?= e($artist->getGenre() ?: '—') ?></td>
                        <td><?= e($artist->getCountry() ?: '—') ?></td>
                        <td>
                            <span class="tag"><?= count($artistSongs) ?> <?= count($artistSongs) === 1 ? 'song' : 'songs' ?></span>
                            <?php if (!empty($artistSongs)) { ?>
                                <div class="linked-songs-inline">
                                    <?php foreach ($artistSongs as $linkedSong) { ?>
                                        <a href="<?= $link->url('song.show', ['id' => $linkedSong->getId()]) ?>" class="open-list">
                                            <?= e($linkedSong->getTitle()) ?>
                                        </a><?= $linkedSong !== end($artistSongs) ? ', ' : '' ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </td>
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

    <p class="footnote">Showing artists and their related 1:N songs loaded from MariaDB via Vaííčko ORM.</p>
</section>
