<a href="/blog">&larr; Back to blog</a>

<article>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <small style="color: #888; display: block; margin-bottom: 1rem;">
        Published on <?= date('F j, Y', strtotime($post['created_at'])) ?>
    </small>

    <div class="content">
        <?= $post['content'] ?>
    </div>
</article>