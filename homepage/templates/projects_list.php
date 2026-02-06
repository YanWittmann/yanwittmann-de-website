<header class="main-header">
    <h1>All Projects</h1>
    <p class="intro-text" style="margin: 0; padding-top: 1rem; border-top: 1px solid #ccc;">
        A complete collection of my work, experiments, and open-source contributions.
    </p>
</header>

<div class="project-list-grid" style="margin-top: 40px;">
    <?php if (empty($projects)): ?>
        <p>There are no projects to display at this time.</p>
    <?php else: ?>
        <?php foreach ($projects as $project): ?>
            <?php include __DIR__ . '/partials/project_card.php'; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>