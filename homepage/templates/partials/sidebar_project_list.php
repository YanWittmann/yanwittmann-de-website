<aside class="card sidebar padded">
    <div class="card-header" style="padding: 0 0 20px 0; border: none;">
        <h3 style="margin: 0; font-family: var(--font-heading);">Filter Projects</h3>
        <?php if (!empty($resetUrl)): ?>
            <a href="<?= htmlspecialchars($resetUrl) ?>" class="reset-link">Reset</a>
        <?php endif; ?>
    </div>

    <?php if (!empty($categories)): ?>
        <h4 style="font-family: var(--font-mono); font-size: 0.8rem; text-transform: uppercase; color: var(--text-light); border-bottom: 1px solid #eee; padding-bottom: 5px;">Categories</h4>
        <div style="margin-bottom: 20px;">
            <?php \App\View::partial('tags_list', ['tags' => $categories, 'style' => 'pill']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($tags)): ?>
        <h4 style="font-family: var(--font-mono); font-size: 0.8rem; text-transform: uppercase; color: var(--text-light); border-bottom: 1px solid #eee; padding-bottom: 5px;">Tags</h4>
        <div>
            <?php \App\View::partial('tags_list', ['tags' => $tags, 'style' => 'pill']); ?>
        </div>
    <?php endif; ?>
</aside>
