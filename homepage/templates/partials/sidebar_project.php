<aside class="card sidebar">
    <?php if (!empty($project['image'])): ?>
        <img src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['title']) ?> Cover" class="card-image">
    <?php endif; ?>

    <div style="padding: 20px;">
        <?php if (!empty($project['tags'])): ?>
            <div style="margin-bottom: 25px;">
                <?php \App\View::partial('tags_list', ['tags' => $project['tags']]); ?>
            </div>
        <?php endif; ?>

        <?php $links = parse_json_list($project['links'] ?? []); ?>
        <?php if (!empty($links)): ?>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <?php foreach ($links as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>"
                       class="btn <?= ($link['style'] ?? 'primary') === 'primary' ? 'primary' : 'secondary' ?>"
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