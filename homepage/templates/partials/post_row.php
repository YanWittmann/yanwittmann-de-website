<a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="post-row-link">
    <article class="post-row-card">
        <time class="post-row-date" datetime="<?= $post['created_at'] ?>">
            <?= date('Y-m-d', strtotime($post['created_at'])) ?>
        </time>
        <div class="post-row-content">
            <h3 class="post-row-title">
                <?= htmlspecialchars($post['title']) ?>
            </h3>
            <?php if (!empty($post['description'])): ?>
                <p class="post-row-desc"><?= htmlspecialchars($post['description']) ?></p>
            <?php endif; ?>

            <?php
            $tags = isset($post['tags']) ? (is_array($post['tags']) ? $post['tags'] : json_decode($post['tags'], true)) : [];
            ?>
            <?php if (!empty($tags)): ?>
                <div class="content-tags" style="margin-top: 8px; font-size: 0.75rem;">
                    <?php foreach ($tags as $tag): ?>
                        <span class="content-tags-item"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </article>
</a>
