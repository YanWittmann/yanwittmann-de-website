<?php if (empty($projects)): ?>
    <p>There are no projects to display at this time.</p>
<?php else: ?>
    <div class="cards-grid">
        <?php foreach ($projects as $project): ?>
            <?php \App\View::partial('project_card', ['project' => $project]); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
