<div class="post-row">
    <span class="post-date"><?= date('Y-m-d', strtotime($post['created_at'])) ?></span>
    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="post-title"><?= htmlspecialchars($post['title']) ?></a>
</div>