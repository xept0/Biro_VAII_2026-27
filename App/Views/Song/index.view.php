<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
?>
<div class="page-header">
    <div class="title-group">
        <h1>Song Catalog</h1>
        <p>Find an arrangement you can play. Even without barre chords.</p>
    </div>
    <button type="button" class="btn-primary">Add Song +</button>
</div>

<!-- Filters -->
<section class="filters" aria-label="Song filters">
    <div class="filter-inputs">
        <div class="input-group">
            <label for="filter-text">Song or Artist</label>
            <input type="text" id="filter-text" placeholder="🔍 E.g. Zombie or Nirvana">
        </div>
        <div class="input-group">
            <label for="filter-difficulty">Difficulty</label>
            <select id="filter-difficulty">
                <option>All difficulties</option>
                <option>Beginner</option>
                <option>Intermediate</option>
            </select>
        </div>
    </div>
    <div class="tags-filter">
        <span>Tags:</span>
        <button type="button" class="tag">Open chords</button>
        <button type="button" class="tag active-tag">✓ No barre</button>
        <button type="button" class="tag">90s rock</button>
        <a href="<?= $link->url('song.index') ?>" class="clear-filters">Clear all filters</a>
    </div>
</section>

<!-- Song list -->
<section class="catalog-list" aria-label="Song list">
    <div class="list-header">
        <span>18 songs · No barre chord arrangements</span>
        <div class="sort-group">
            <label for="sort-by">Sort by</label>
            <select id="sort-by">
                <option>Recommended</option>
            </select>
        </div>
    </div>

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
                <th>PDF</th>
                <th>Detail</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>⭐</td>
                <td>
                    <strong>Come As You Are</strong><br>
                    <small>Simplified arrangement · saved</small>
                </td>
                <td>Nirvana</td>
                <td>Beginner</td>
                <td>Em · D · Am · C</td>
                <td>No barre, 90s rock</td>
                <td>PDF ↓</td>
                <td><button type="button" class="btn-secondary">View</button></td>
            </tr>
            <tr>
                <td>☆</td>
                <td>
                    <strong>Wonderwall</strong><br>
                    <small>Simplified arrangement · chords</small>
                </td>
                <td>Oasis</td>
                <td>Intermediate</td>
                <td>Em7 · G · Dsus4...</td>
                <td>No barre, 90s rock</td>
                <td>PDF ↓</td>
                <td><button type="button" class="btn-secondary">View</button></td>
            </tr>
            <tr>
                <td>☆</td>
                <td>
                    <strong>Zombie</strong><br>
                    <small>Simplified arrangement · saved</small>
                </td>
                <td>The Cranberries</td>
                <td>Beginner</td>
                <td>Em · C · G · D</td>
                <td>No barre, 90s rock</td>
                <td>PDF ↓</td>
                <td><button type="button" class="btn-secondary">View</button></td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="pagination" aria-label="Pagination">
        <span>Showing 1 – 3 of 18 songs</span>
        <div class="page-controls">
            <button type="button" disabled>← Previous</button>
            <button type="button" class="active-page">1</button>
            <button type="button">2</button>
            <button type="button">3</button>
            <button type="button">Next →</button>
        </div>
    </nav>

    <p class="footnote">Showing simplified arrangements, not original recordings. "Saved" = song in favorites.</p>
</section>

<!-- Practice list widget -->
<aside class="practice-widget">
    <div class="widget-info">
        <strong>My practice list · Evening warmup</strong>
        <p>3 songs · Zombie, Wonderwall, Free Fallin' · for registered guitarist</p>
    </div>
    <a href="#" class="open-list">Open list →</a>
</aside>
