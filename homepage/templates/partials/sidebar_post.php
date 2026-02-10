<aside class="card sidebar">
    <?php if (!empty($post['image'])): ?>
        <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?> Cover" class="card-image">
    <?php endif; ?>

    <div style="padding: 20px;">
        <ul class="meta-list">
            <li>
                <i class="far fa-calendar"></i>
                <span><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
            </li>
        </ul>

        <?php if (!empty($post['tags'])): ?>
            <div style="margin-bottom: 25px;">
                <?php \App\View::partial('tags_list', ['tags' => $post['tags']]); ?>
            </div>
        <?php endif; ?>
    </div>
</aside>
