<a href="/projects" class="section-anchor">
    <span class="num">01</span>
    <span class="label">// PROJECTS</span>
    <span class="arrow">VIEW ALL <?= icon('arrow-right') ?></span>
</a>

<div class="cards-grid">
    <?php foreach ($projects as $project): ?>
        <?php \App\View::partial('project_card', ['project' => $project]); ?>
    <?php endforeach; ?>
</div>

<div style="margin-top: 40px;"></div>

<a href="/blog" class="section-anchor">
    <span class="num">02</span>
    <span class="label">// LATEST POSTS</span>
    <span class="arrow">VIEW ALL <?= icon('arrow-right') ?></span>
</a>

<div class="blog-list-group">
    <?php foreach ($posts as $row_data): ?>
        <?php include __DIR__ . '/partials/post_row.php'; ?>
    <?php endforeach; ?>
</div>

<div style="margin-top: 30px;"></div>

<span class="section-anchor">
    <span class="num">03</span>
    <span class="label">// MORE PAGES</span>
</span>

<div class="blog-list-group">
    <?php
    $more_pages = [
            [
                    "title" => "Blender Renders",
                    "url" => "/pages/blender/",
                    "image" => "/pages/blender/img/earthwithmoon.webp",
                    "description" => "A couple of renders of projects I made in blender.",
            ]
    ];
    ?>
    <?php foreach ($more_pages as $row_data): ?>
        <?php include __DIR__ . '/partials/post_row.php'; ?>
    <?php endforeach; ?>
</div>