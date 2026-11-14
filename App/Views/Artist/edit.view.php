<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Artist $artist */
/** @var \App\Models\Song[] $allSongs */
/** @var int[] $selectedSongIds */
/** @var array<string, string> $errors */

$formAction = $link->url('artist.edit', ['id' => $artist->getId()]);
$submitLabel = 'Save Changes';
?>
<div class="page-header">
    <div class="title-group">
        <h1>Edit Artist: <?= e($artist->getName()) ?></h1>
        <p>Update artist details and manage which songs are linked to this artist.</p>
    </div>
    <a href="<?= $link->url('artist.index') ?>" class="btn-secondary">← Back to Artists</a>
</div>

<?php require __DIR__ . '/form.view.php'; ?>
