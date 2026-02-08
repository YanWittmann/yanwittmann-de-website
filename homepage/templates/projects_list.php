<div class="project-list-grid" style="margin-top: 40px;">
    <?php if (empty($projects)): ?>
        <p>There are no projects to display at this time.</p>
    <?php else: ?>
        <?php foreach ($projects as $project): ?>
            <?php \App\View::partial('project_card', ['project' => $project]); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>