<a href="/projects">&larr; Back to projects</a>

<article>
    <h1><?= htmlspecialchars($project['title']) ?></h1>

    <small style="color: #888; display: block; margin-bottom: 1rem;">
        Published on <?= date('F j, Y', strtotime($project['created_at'])) ?>
    </small>

    <div class="content">
        <?= $project['content'] ?>
    </div>
</article>