<aside class="card sidebar">
    <?php if (!empty($project['image'])): ?>
        <img src="<?= htmlspecialchars($project['image']) ?>"
             alt="<?= htmlspecialchars($project['title']) ?> Cover"
             class="card-image">
    <?php endif; ?>

    <div style="padding: 20px; display: flex; flex-direction: column; gap: 20px;">

        <?php $links = parse_json_list($project['links'] ?? []); ?>
        <?php if (!empty($links)): ?>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <?php foreach ($links as $link): ?>
                    <a href="<?= htmlspecialchars($link['url']) ?>"
                       class="btn <?= ($link['style'] ?? 'primary') === 'primary' ? 'primary' : 'secondary' ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?php if (!empty($link['icon'])): ?>
                            <?= icon($link['icon']) ?>
                        <?php endif; ?>
                        <?= htmlspecialchars($link['label']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="display: flex; flex-direction: column;">
            <?php
            $rows = [];

            // Stars
            if (!empty($project['stars'])) {
                $rows[] = ['icon' => 'star', 'label' => 'Stars', 'value' => number_format($project['stars'])];
            }

            // Forks
            if (!empty($project['forks'])) {
                $rows[] = ['icon' => 'code-fork', 'label' => 'Forks', 'value' => number_format($project['forks'])];
            }

            // Watchers
            if (!empty($project['watchers'])) {
                $rows[] = ['icon' => 'eye', 'label' => 'Watchers', 'value' => number_format($project['watchers'])];
            }

            // Language
            if (!empty($project['languages'])) {
                $langs = $project['languages'];
                $topLang = null;

                // Handle [{"name": "Java", ...}] format
                if (isset($langs[0]['name'])) {
                    $topLang = $langs[0]['name'];
                } // Handle {"Java": 1234} format
                elseif (is_array($langs)) {
                    $key = array_key_first($langs);
                    if (!is_numeric($key)) {
                        $topLang = $key;
                    }
                }

                if ($topLang) {
                    $rows[] = ['icon' => 'language', 'label' => 'Language', 'value' => $topLang];
                }
            }

            // Size
            if (!empty($project['size_kb'])) {
                $size = $project['size_kb'];
                $sizeStr = ($size > 1024)
                        ? round($size / 1024, 1) . ' MB'
                        : $size . ' KB';

                $rows[] = ['icon' => 'database', 'label' => 'Size', 'value' => $sizeStr];
            }

            // License
            if (!empty($project['license'])) {
                $lic = $project['license'];
                $licName = is_array($lic) ? ($lic['name'] ?? 'Unknown') : $lic;

                if ($licName && strtolower($licName) !== 'other') {
                    $rows[] = ['icon' => 'file-text', 'label' => 'License', 'value' => $licName];
                }
            }

            // Updated
            if (!empty($project['last_pushed_at'])) {
                $rows[] = ['icon' => 'calendar', 'label' => 'Updated', 'value' => date('Y-m-d', strtotime($project['last_pushed_at']))];
            }
            ?>

            <?php foreach ($rows as $index => $row): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 4px 0; font-size: 0.9rem;">
                    <span style="color: var(--text-light); display: flex; align-items: center; gap: 8px;">
                        <?= icon($row['icon'], 'meta-icon', 'width: 14px;') ?>
                        <?= htmlspecialchars($row['label']) ?>
                    </span>
                    <span style="font-weight: bold; color: var(--text-main);">
                        <?= htmlspecialchars($row['value']) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($project['tags'])): ?>
            <div>
                <?php \App\View::partial('tags_list', ['tags' => $project['tags']]); ?>
            </div>
        <?php endif; ?>
    </div>
</aside>