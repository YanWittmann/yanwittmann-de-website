<?php
$tags = isset($tags) ? parse_json_list($tags) : [];
$style = $style ?? 'tag'; // 'tag', 'pill', 'text'
?>
<?php if (!empty($tags)): ?>
    <div class="tag-list">
        <?php foreach ($tags as $tag): ?>
            <?php if ($style === 'pill'): ?>
                <?php
                // Logic to support active state passed via complex array in pills
                $label = is_array($tag) ? $tag['label'] : $tag;
                $url = is_array($tag) ? $tag['url'] : '#';
                $active = is_array($tag) && !empty($tag['active']) ? 'active' : '';
                ?>
                <a href="<?= htmlspecialchars($url) ?>" class="tag pill <?= $active ?>">
                    <?= htmlspecialchars($label) ?>
                </a>
            <?php elseif ($style === 'text'): ?>
                <span class="text-tag"><?= htmlspecialchars($tag) ?></span>
            <?php else: ?>
                <span class="tag"><?= htmlspecialchars($tag) ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
