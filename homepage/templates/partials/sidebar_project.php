<aside class="sidebar-card">
    <?php if (!empty($project['image'])): ?>
        <div class="sidebar-img-container">
            <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?> Cover" class="sidebar-img">
        </div>
    <?php endif; ?>

    <div class="sidebar-body">
        <ul class="meta-list">
            <li>
                <i class="far fa-calendar"></i>
                <span><?= date('Y-m-d', strtotime($project['created_at'])) ?></span>
            </li>
            <?php if (!empty($project['category'])): ?>
                <li>
                    <i class="fas fa-layer-group"></i>
                    <span><?= htmlspecialchars($project['category']) ?></span>
                </li>
            <?php endif; ?>
        </ul>

        <?php if (!empty($project['tags'])): ?>
            <div class="tech-tags-sidebar">
                <?php foreach ($project['tags'] as $tag): ?>
                    <span class="tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($project['links'])): ?>
            <div class="action-btn-group">
                <?php foreach ($project['links'] as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>"
                       class="action-btn <?= ($link['style'] ?? 'primary') === 'primary' ? 'primary' : 'secondary' ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?php if (!empty($link['icon'])): ?>
                            <i class="<?= htmlspecialchars($link['icon']) ?>"></i>
                        <?php endif; ?>
                        <?= htmlspecialchars($link['label']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</aside>