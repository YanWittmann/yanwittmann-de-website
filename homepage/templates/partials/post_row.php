<?php
$hasImage = !empty($row_data['image']);
$tags = isset($row_data['tags']) ? parse_json_list($row_data['tags']) : [];
?>

<a href="<?= htmlspecialchars(!empty($row_data['url']) ? $row_data['url'] : '/blog/' . $row_data['slug']) ?>" class="blog-row">
    <article class="card shadow-hover">

        <div class="blog-row-img-col">
            <?php if ($hasImage): ?>
                <img src="<?= htmlspecialchars($row_data['image']) ?>"
                     alt="<?= htmlspecialchars($row_data['title']) ?>"
                     loading="lazy">
            <?php else: ?>
                <div class="blog-row-icon-placeholder">
                    <?= icon('code') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="blog-row-content-col">
            <header class="card-header blog-row-header">
                <h3 class="card-title">
                    <span class="card-square"></span>
                    <?= htmlspecialchars($row_data['title']) ?>
                </h3>
                <?php if (isset($row_data['created_at'])): ?>
                    <span class="blog-row-date">
                    <?= date('Y-m-d', strtotime($row_data['created_at'])) ?>
                </span>
                <?php endif ?>
            </header>

            <div class="blog-row-body">
                <p class="blog-row-desc">
                    <?= !empty($row_data['description']) ? htmlspecialchars($row_data['description']) : 'No description available.' ?>
                </p>

                <?php if (!empty($tags)): ?>
                    <div class="blog-row-tags">
                        <?php \App\View::partial('tags_list', ['tags' => $tags, 'style' => 'text']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </article>
</a>