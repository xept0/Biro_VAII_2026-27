<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Song $song */
/** @var array<string, string> $errors */

$formAction = $link->url('song.edit', ['id' => $song->getId()]);
$submitLabel = 'Save Changes';
?>
<div class="page-header">
    <div class="title-group">
        <h1>Edit Song: <?= e($song->getTitle()) ?></h1>
        <p>Update arrangement details, chords, tags, or chord sheet.</p>
    </div>
    <a href="<?= $link->url('song.index') ?>" class="btn-secondary">← Back to Catalog</a>
</div>

<?php require __DIR__ . '/form.view.php'; ?>
