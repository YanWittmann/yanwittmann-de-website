<?php
$hasImage = !empty($post['image']);
$tags = isset($post['tags']) ? parse_json_list($post['tags']) : [];
?>

<a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="blog-row">
    <article class="card shadow-hover">

        <div class="blog-row-img-col">
            <?php if ($hasImage): ?>
                <img src="<?= htmlspecialchars($post['image']) ?>"
                     alt="<?= htmlspecialchars($post['title']) ?>"
                     loading="lazy">
            <?php else: ?>
                <div class="blog-row-icon-placeholder">
                    <i class="fa-solid fa-code"></i>
                </div>
            <?php endif; ?>
        </div>

        <div class="blog-row-content-col">
            <header class="card-header blog-row-header">
                <h3 class="card-title">
                    <span class="card-square"></span>
                    <?= htmlspecialchars($post['title']) ?>
                </h3>
                <span class="blog-row-date">
                    <?= date('Y-m-d', strtotime($post['created_at'])) ?>
                </span>
            </header>

            <div class="blog-row-body">
                <p class="blog-row-desc">
                    <?= !empty($post['description']) ? htmlspecialchars($post['description']) : 'No description available.' ?>
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