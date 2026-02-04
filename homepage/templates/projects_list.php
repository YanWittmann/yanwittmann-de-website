<h1>My Projects</h1>
<p>Here is a collection of things I've built.</p>

<div class="grid">
    <?php foreach ($projects as $project): ?>
        <article class="project-card" style="margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
            <h2>
                <a href="/projects/<?= htmlspecialchars($project['slug']) ?>">
                    <?= htmlspecialchars($project['title']) ?>
                </a>
            </h2>
            <?php if(!empty($project['tech_stack'])): ?>
                <small style="color: #666;">Tech: <?= htmlspecialchars($project['tech_stack']) ?></small>
            <?php endif; ?>
            <p><?= htmlspecialchars($project['description']) ?></p>
            <a href="/projects/<?= htmlspecialchars($project['slug']) ?>">View Details &rarr;</a>
        </article>
    <?php endforeach; ?>
</div>