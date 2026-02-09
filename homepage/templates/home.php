<div class="layout-grid">
    <div class="intro-area">
        <header class="main-header">
            <h1>Hello, I'm Yan Wittmann</h1>
            <div class="subtitle">SOFTWARE ENGINEER // <?php
                $dob = new DateTime('2000-05-07', new DateTimeZone("Europe/Berlin"));
                $now = new DateTime();
                echo date_diff($dob, $now)->y;
                ?> YEARS // @SKYBALL</div>
        </header>
        <p class="intro-text">While you're here, check out some of the projects or posts below!</p>
    </div>

    <?php include __DIR__ . '/partials/sidebar_home.php'; ?>

    <main class="content-area">
        <div class="section-header">
            <a href="/projects" class="label"><span>01</span> // PROJECTS <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="project-list-grid">
            <?php foreach ($projects as $project): ?>
                <?php \App\View::partial('project_card', ['project' => $project]); ?>
            <?php endforeach; ?>
        </div>

        <div class="section-header" style="margin-top: 40px;">
            <a href="/blog" class="label"><span>02</span> // LATEST POSTS <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <?php foreach ($posts as $post): ?>
            <?php include __DIR__ . '/partials/post_row.php'; ?>
        <?php endforeach; ?>
    </main>
</div>