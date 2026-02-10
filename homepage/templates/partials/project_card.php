<a href="/projects/<?= htmlspecialchars($project['slug']) ?>">
    <article class="card shadow-hover" style="height: 100%;">
        <header class="card-header">
            <h3 class="card-title">
                <span class="card-square"></span>
                <?= htmlspecialchars($project['title']) ?>
            </h3>
            <span style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-light);">
                <?= date('Y-m-d', strtotime($project['created_at'])) ?>
            </span>
        </header>

        <?php if (isset($project['image'])): ?>
            <img src="<?= htmlspecialchars($project['image']) ?>"
                 alt="<?= htmlspecialchars($project['title']) ?>"
                 class="card-image small" loading="lazy">
        <?php endif; ?>

        <div class="card-content">
            <p style="margin: 0 0 15px 0; line-height: 1.4; color: var(--text-main); flex-grow: 1;">
                <?= htmlspecialchars($project['description']) ?>
            </p>

            <?php
            $tags = [];
            if (isset($project['category'])) $tags[] = $project['category'];
            $tags = array_merge($tags, parse_json_list($project['tags'] ?? []));
            ?>
            <?php \App\View::partial('tags_list', ['tags' => $tags, 'style' => 'text']); ?>
        </div>
    </article>
</a>
