<a href="/blog/<?= htmlspecialchars($post['slug']) ?>" style="text-decoration: none;">
    <article class="card shadow-hover" style="padding: 20px; height: auto; border-bottom: 1px solid var(--border-color);">
        <div style="display: flex; flex-direction: column; gap: 5px;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 10px;">
                <h3 style="margin: 0; font-family: var(--font-head); font-size: 1.15rem; color: var(--text-main);">
                    <?= htmlspecialchars($post['title']) ?>
                </h3>
                <time style="font-family: var(--font-mono); font-size: 0.85rem; color: var(--accent); font-weight: bold;">
                    <?= date('Y-m-d', strtotime($post['created_at'])) ?>
                </time>
            </div>

            <?php if (!empty($post['description'])): ?>
                <p style="margin: 5px 0 0 0; font-size: 0.95rem; color: var(--text-light); line-height: 1.5;">
                    <?= htmlspecialchars($post['description']) ?>
                </p>
            <?php endif; ?>

            <?php $tags = parse_json_list($post['tags'] ?? []); ?>
            <?php if (!empty($tags)): ?>
                <div style="margin-top: 12px;">
                    <?php \App\View::partial('tags_list', ['tags' => $tags, 'style' => 'text']); ?>
                </div>
            <?php endif; ?>
        </div>
    </article>
</a>