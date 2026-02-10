<a href="/projects" class="section-anchor">
    <span class="num">01</span>
    <span class="label">// PROJECTS</span>
    <span class="arrow">VIEW ALL <i class="fa-solid fa-arrow-right"></i></span>
</a>

<div class="cards-grid">
    <?php foreach ($projects as $project): ?>
        <?php \App\View::partial('project_card', ['project' => $project]); ?>
    <?php endforeach; ?>
</div>

<div style="margin-top: 60px;"></div>

<a href="/blog" class="section-anchor">
    <span class="num">02</span>
    <span class="label">// LATEST POSTS</span>
    <span class="arrow">VIEW ALL <i class="fa-solid fa-arrow-right"></i></span>
</a>

<div class="list-group">
    <?php foreach ($posts as $post): ?>
        <?php include __DIR__ . '/partials/post_row.php'; ?>
    <?php endforeach; ?>
</div>