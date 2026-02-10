<a href="/blog/<?= htmlspecialchars($post['slug']) ?>">
    <article class="card shadow-hover post-row">
        <time class="date" datetime="<?= $post['created_at'] ?>">
            <?= date('Y-m-d', strtotime($post['created_at'])) ?>
        </time>
        <div style="flex-grow: 1;">
            <h3 class="title">
                <?= htmlspecialchars($post['title']) ?>
            </h3>
            <?php if (!empty($post['description'])): ?>
                <p class="desc"><?= htmlspecialchars($post['description']) ?></p>
            <?php endif; ?>

            <?php $tags = parse_json_list($post['tags'] ?? []); ?>
            <?php if (!empty($tags)): ?>
                <div style="margin-top: 8px;">
                    <?php \App\View::partial('tags_list', ['tags' => $tags, 'style' => 'text']); ?>
                </div>
            <?php endif; ?>
        </div>
    </article>
</a>
