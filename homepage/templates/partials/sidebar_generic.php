<aside class="sidebar-card padded">
    <div class="sidebar-header">
        <h3><?= htmlspecialchars($title ?? 'Filters') ?></h3>
        <?php if (!empty($resetUrl)): ?>
            <a href="<?= htmlspecialchars($resetUrl) ?>" class="reset-link">Reset</a>
        <?php endif; ?>
    </div>

    <?php if (!empty($description)): ?>
        <p style="font-size: 0.95rem; color: var(--text-light); line-height: 1.5; margin-bottom: 20px;">
            <?= htmlspecialchars($description) ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($groups)): ?>
        <?php foreach ($groups as $group): ?>
            <?php \App\View::partial('filter_group', ['group' => $group]); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</aside>
