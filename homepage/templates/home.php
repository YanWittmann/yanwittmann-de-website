<div class="layout-grid home-variant">
    <div class="home-intro">
        <header class="main-header">
            <h1>Hello, I'm Yan Wittmann</h1>
            <div class="subtitle">SOFTWARE ENGINEER // <?php
                $dob = new DateTime('2000-05-07', new DateTimeZone("Europe/Berlin"));
                $now = new DateTime();
                echo date_diff($dob, $now)->y;
                ?> YEARS // @SKYBALL
            </div>
        </header>
        <p class="intro-text">While you're here, check out some of the projects or posts below!</p>
    </div>

    <?php include __DIR__ . '/partials/sidebar_home.php'; ?>

    <main class="home-content">
        <div class="section-header">
            <a href="/projects" class="label"><span>01</span> // PROJECTS <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="cards-grid">
            <?php foreach ($projects as $project): ?>
                <?php \App\View::partial('project_card', ['project' => $project]); ?>
            <?php endforeach; ?>
        </div>

        <div class="section-header" style="margin-top: 40px;">
            <a href="/blog" class="label"><span>02</span> // LATEST POSTS <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="list-group">
            <?php foreach ($posts as $post): ?>
                <?php include __DIR__ . '/partials/post_row.php'; ?>
            <?php endforeach; ?>
        </div>
    </main>
</div>
