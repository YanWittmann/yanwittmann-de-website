<h1>Blog</h1>

<?php foreach ($posts as $post): ?>
    <article style="margin-bottom: 2rem;">
        <h2>
            <a href="/blog/<?= htmlspecialchars($post['slug']) ?>">
                <?= htmlspecialchars($post['title']) ?>
            </a>
        </h2>
        <small><?= date('F j, Y', strtotime($post['created_at'])) ?></small>
        <br>
        <a href="/blog/<?= htmlspecialchars($post['slug']) ?>">Read Article &rarr;</a>
    </article>
<?php endforeach; ?>