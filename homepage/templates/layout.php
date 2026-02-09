<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Yan Wittmann - Software Engineer') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;600;800&family=Roboto+Slab:wght@400;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="/static/style/main.css">
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css_file): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($css_file) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <style>
        .page-wrapper {
            max-width: <?= ($page_size ?? "1200") . "px" ?>;
        }
    </style>
</head>
<body>
<header class="top-nav-bar">
    <?php generate_breadcrumbs($breadcrumbs ?? []); ?>
    <nav>
        <a href="/">Home</a>
        <a href="/projects">Projects</a>
        <a href="/blog">Posts</a>
    </nav>
</header>

<div class="page-wrapper">
    <?php if (isset($sidebar)): ?>
        <!-- Two-Column Grid Layout -->
        <div class="content-grid">
            <div class="sidebar-column">
                <?= $sidebar ?>
            </div>

            <main class="main-column">
                <?php if (isset($title)): ?>
                    <header class="main-header">
                        <h1 style="margin: 0; padding-bottom: 1rem; border-bottom: 1px solid #ccc;">
                            <?= $title ?>
                        </h1>
                        <?php if (isset($subtitle)): ?>
                            <p class="intro-text">
                                <?= $subtitle ?>
                            </p>
                        <?php endif; ?>
                    </header>
                <?php endif; ?>
                <?= $content ?>
            </main>
        </div>
    <?php else: ?>
        <!-- Default Full-Width Layout -->
        <?php if (isset($title)): ?>
            <header class="main-header">
                <h1 style="margin: 0; padding-bottom: 1rem; border-bottom: 1px solid #ccc;">
                    <?= $title ?>
                    <?php if (!empty($tags)): ?>
                        <span class="content-tags" style="margin-left: 10px; font-size: 1rem;">
                        <?php foreach ($tags as $tag): ?>
                            <span class="content-tags-item"><?= htmlspecialchars($tag) ?></span>
                        <?php endforeach; ?>
                    </span>
                    <?php endif; ?>
                </h1>
                <?php if (isset($subtitle)): ?>
                    <p class="intro-text">
                        <?= $subtitle ?>
                    </p>
                <?php endif; ?>
            </header>
        <?php endif; ?>
        <?= $content ?>
    <?php endif; ?>
</div>

<footer>
    &copy; <?= date('Y') ?> Yan Wittmann
</footer>
</body>
</html>