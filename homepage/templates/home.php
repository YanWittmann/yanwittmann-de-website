<div class="layout-grid">
    <div class="intro-area">
        <header class="main-header">
            <h1>Yan Wittmann</h1>
            <div class="subtitle">SOFTWARE ENGINEER // @skyball</div>
        </header>
        <p class="intro-text">
            I'm a <?php
            $dob = new DateTime('2000-05-07', new DateTimeZone("Europe/Berlin"));
            $now = new DateTime();
            echo date_diff($dob, $now)->y;
            ?> years old Software Engineer.
            On this page you can find all of my recent projects.
        </p>
    </div>

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="content-area">
        <div class="section-header">
            <a href="/projects" class="label"><span>01</span> // PROJECTS <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="project-list-grid">
            <?php foreach ($projects as $project): ?>
                <?php include __DIR__ . '/partials/project_card.php'; ?>
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