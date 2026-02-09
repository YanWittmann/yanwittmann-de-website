<aside class="sidebar-card padded">
    <div class="sidebar-header">
        <h3>Filter Projects</h3>
        <?php if (!empty($resetUrl)): ?>
            <a href="<?= htmlspecialchars($resetUrl) ?>" class="reset-link">Reset</a>
        <?php endif; ?>
    </div>

    <?php if (!empty($categories)): ?>
        <h4 class="filter-group-title">Categories</h4>
        <div class="filter-cloud">
            <?php foreach ($categories as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>"
                   class="filter-pill <?= !empty($link['active']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($link['label']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($tags)): ?>
        <h4 class="filter-group-title">Tags</h4>
        <div class="filter-cloud">
            <?php foreach ($tags as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>"
                   class="filter-pill <?= !empty($link['active']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($link['label']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</aside>