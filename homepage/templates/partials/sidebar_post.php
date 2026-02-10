<aside class="card sidebar">
    <?php if (!empty($post['image'])): ?>
        <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?> Cover" class="card-image">
    <?php endif; ?>

    <?php if (!empty($post['tags'])): ?>
        <div style="padding: 20px;">
            <?php \App\View::partial('tags_list', ['tags' => $post['tags']]); ?>
        </div>
    <?php endif; ?>
</aside>