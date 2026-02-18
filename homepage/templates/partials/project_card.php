<a href="/projects/<?= htmlspecialchars($project['slug']) ?>">
    <article class="card shadow-hover">
        <header class="card-header">
            <h3 class="card-title">
                <span class="card-square"></span>
                <?= htmlspecialchars($project['title']) ?>
            </h3>

            <div class="card-header-meta">
                <?php
                $statsHtml = '';

                if (!empty($project['forks']) && $project['forks'] > 0) {
                    $statsHtml .= '<span class="card-header-meta-stat" title="' . number_format($project['forks']) . ' Forks">';
                    $statsHtml .= number_format($project['forks']) . ' ' . icon('code-fork', 'card-header-meta-icon');
                    $statsHtml .= '</span>';
                }

                if (!empty($project['stars'])) {
                    $statsHtml .= '<span class="card-header-meta-stat" title="' . number_format($project['stars']) . ' GitHub Stars">';
                    $statsHtml .= number_format($project['stars']) . ' ' . icon('star', 'card-header-meta-icon');
                    $statsHtml .= '</span>';
                }

                if ($statsHtml) {
                    echo $statsHtml;
                } else {
                    echo '<span class="card-header-meta-date">' . date('Y-m-d', strtotime($project['created_at'])) . '</span>';
                }
                ?>
            </div>
        </header>

        <?php if (isset($project['image'])): ?>
            <img src="<?= htmlspecialchars($project['image']) ?>"
                 alt="<?= htmlspecialchars($project['title']) ?>"
                 class="card-image cover-ar-169 small" loading="lazy">
        <?php endif; ?>

        <div class="card-content flex">
            <p style="margin: 0 0 15px 0; line-height: 1.4; color: var(--text-main); flex-grow: 1; font-size: 0.95rem;">
                <?= htmlspecialchars($project['description']) ?>
            </p>

            <?php
            $tags = array_slice(parse_json_list($project['tags'] ?? []), 0, 3);
            if (isset($project['category'])) $tags[] = $project['category'];
            ?>
            <?php \App\View::partial('tags_list', ['tags' => $tags, 'style' => 'text']); ?>
        </div>
    </article>
</a>