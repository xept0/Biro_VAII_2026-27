<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Song $song */
/** @var array<string, string> $errors */

$formAction = $link->url('song.add');
$submitLabel = 'Create Song';
?>
<div class="page-header">
    <div class="title-group">
        <h1>Add New Song</h1>
        <p>Create a new guitar chord arrangement in the library.</p>
    </div>
    <a href="<?= $link->url('song.index') ?>" class="btn-secondary">← Back to Catalog</a>
</div>

<?php require __DIR__ . '/form.view.php'; ?>
