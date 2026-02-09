<aside class="sidebar-card">
    <?php if (!empty($post['image'])): ?>
        <div class="sidebar-img-container">
            <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?> Cover" class="sidebar-img">
        </div>
    <?php endif; ?>

    <div class="sidebar-body">
        <ul class="meta-list">
            <li>
                <i class="far fa-calendar"></i>
                <span><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
            </li>
        </ul>

        <?php if (!empty($post['tags'])): ?>
            <div class="tech-tags-sidebar">
                <?php foreach ($post['tags'] as $tag): ?>
                    <span class="tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</aside>