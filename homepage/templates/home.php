<link rel="stylesheet" href="/static/style/home.css">
<link rel="stylesheet" href="/static/style/grid.css">

<?php
$berlinDate = new DateTime("now", new DateTimeZone("Europe/Berlin"));
?>

<div class="home-grid">
    <aside class="sidebar">
        <img src="/static/img/profile-picture-yan.webp" class="profile-pic" alt="Yan Wittmann"/>

        <div class="profile-header">
            <h2 class="profile-name">Yan Wittmann</h2>
            <div class="profile-separator"></div>
            <div class="profile-handle">@skyball</div>
        </div>

        <div class="profile-meta">
            <div class="profile-meta-row">
                <i class="fa-regular fa-building profile-meta-icon"></i>
                <a href="https://metaeffekt.com">{metaeffekt}</a>
            </div>

            <div class="profile-meta-row">
                <i class="fa-solid fa-location-dot profile-meta-icon"></i>
                <span>Heidelberg / Germany</span>
            </div>

            <div class="profile-meta-row">
                <i class="fa-regular fa-clock profile-meta-icon"></i>
                <span><?= $berlinDate->format('g:i A') ?></span>
            </div>

            <i class="fa-brands fa-github profile-meta-icon"></i>
        </div>
    </aside>

    <div class="content-list">
        <div>
            <h1>Hello there!</h1>
            <p>
                I'm Yan Wittmann, I'm <?php
                $dob = new DateTime('2000-05-07');
                $now = new DateTime();
                echo date_diff($dob, $now)->y;
                ?> years old and Software Engineer from Heidelberg, Germany.
                On this page you can find all of my recent projects.
            </p>
        </div>

        <?php if (!empty($projects)): ?>
            <h2>Projects</h2>
            <div class="content-grid">
                <?php foreach ($projects as $project): ?>
                    <a href="/projects/<?= htmlspecialchars($project['slug']) ?>" class="content-card no-link-style">
                        <?php if (!empty($project['image'])): ?>
                            <div class="card-cover">
                                <img src="<?= htmlspecialchars($project['image']) ?>" alt="Cover Image" loading="lazy"/>
                            </div>
                        <?php endif; ?>
                        <div class="card-text">
                            <h3><?= htmlspecialchars($project['title']) ?></h3>
                            <p><?= htmlspecialchars($project['description']) ?></p>
                            <small>Created: <?= date('Y-m-d', strtotime($project['created_at'])) ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($posts)): ?>
            <h2>Latest Blog Posts</h2>
            <div class="content-grid">
                <?php foreach ($posts as $post): ?>
                    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="content-card no-link-style">
                        <?php if (!empty($post['image'])): ?>
                            <div class="card-cover">
                                <img src="<?= htmlspecialchars($post['image']) ?>" alt="Cover Image" loading="lazy"/>
                            </div>
                        <?php endif; ?>
                        <div class="card-text">
                            <h3><?= htmlspecialchars($post['title']) ?></h3>
                            <p><?= htmlspecialchars($post['description']) ?></p>
                            <small>Published: <?= date('Y-m-d', strtotime($post['created_at'])) ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>