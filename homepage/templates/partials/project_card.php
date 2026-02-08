<a href="/projects/<?= htmlspecialchars($project['slug']) ?>" class="project-card-link">
    <article class="project-card">
        <header class="card-header">
            <div class="card-title-group">
                <span class="card-square"></span>
                <h3 class="card-title"><?= htmlspecialchars($project['title']) ?></h3>
            </div>
            <span class="card-date"><?= date('Y-m-d', strtotime($project['created_at'])) ?></span>
        </header>

        <?php if (isset($project['image'])): ?>
            <div class="card-image-container">
                <img src="<?= htmlspecialchars($project['image']) ?>"
                     alt="<?= htmlspecialchars($project['title']) ?> cover image" loading="lazy">
            </div>
        <?php endif; ?>

        <div class="card-content">
            <p class="card-description">
                <?= htmlspecialchars($project['description']) ?>
            </p>

            <?php $tags = isset($project['tags']) ? (is_array($project['tags']) ? $project['tags'] : json_decode($project['tags'], true)) : []; ?>
            <?php if (!empty($tags)): ?>
                <div class="content-tags">
                    <?php foreach ($tags as $tag): ?>
                        <span class="content-tags-item"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </article>
</a>