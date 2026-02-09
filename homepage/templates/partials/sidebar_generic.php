<aside class="sidebar-card padded">
    <?php if (!empty($title)): ?>
        <h3 style="margin-top: 0; font-family: var(--font-heading);"><?= htmlspecialchars($title) ?></h3>
    <?php endif; ?>

    <?php if (!empty($description)): ?>
        <p style="font-size: 0.95rem; color: var(--text-light); line-height: 1.5; margin-bottom: 20px;">
            <?= htmlspecialchars($description) ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($groups)): ?>
        <?php foreach ($groups as $group): ?>
            <?php if (!empty($group['links'])): ?>
                <h4 style="margin-top: 0"><?= htmlspecialchars($group['title']) ?></h4>
                <div class="filter-menu">
                    <?php foreach ($group['links'] as $link): ?>
                        <a href="<?= htmlspecialchars($link['url']) ?>"
                           class="filter-link <?= !empty($link['active']) ? 'active' : '' ?>">
                            <span><?= htmlspecialchars($link['label']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</aside>
