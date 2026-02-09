<?php if (!empty($group['links'])): ?>
    <h4 class="filter-group-title"><?= htmlspecialchars($group['title']) ?></h4>

    <?php if (($group['display'] ?? 'list') === 'cloud'): ?>
        <div class="filter-cloud">
            <?php foreach ($group['links'] as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>"
                   class="filter-pill <?= !empty($link['active']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($link['label']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="filter-menu">
            <?php foreach ($group['links'] as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>"
                   class="filter-link <?= !empty($link['active']) ? 'active' : '' ?>">
                    <span><?= htmlspecialchars($link['label']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>