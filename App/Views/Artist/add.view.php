<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Artist $artist */
/** @var \App\Models\Song[] $allSongs */
/** @var int[] $selectedSongIds */
/** @var array<string, string> $errors */

$formAction = $link->url('artist.add');
$submitLabel = 'Create Artist';
?>
<div class="page-header">
    <div class="title-group">
        <h1>Add New Artist</h1>
        <p>Create a new artist or band profile and optionally assign songs from the catalog.</p>
    </div>
    <a href="<?= $link->url('artist.index') ?>" class="btn-secondary">← Back to Artists</a>
</div>

<?php require __DIR__ . '/form.view.php'; ?>
