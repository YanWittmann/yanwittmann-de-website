<header class="main-header">
    <h1><?= htmlspecialchars($project['title']) ?></h1>
    <?php if (!empty($project['tags'])): ?>
        <div class="p-tags" style="margin-top: 1rem;">
            <?php foreach ($project['tags'] as $tag): ?>
                <span class="pt-tag"><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</header>

<div class="prose" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #ccc;">
    <?= $project['content'] ?>
</div>