<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Yan Wittmann') ?></title>
    <meta name="description" content="Explore the portfolio of Yan Wittmann, a software engineer with a passion for game and web development.">
    <meta name="author" content="Yan Wittmann">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;600&family=Roboto+Slab:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/static/style/main.css">
    <link rel="stylesheet" href="/static/style/layout.css">
    <link rel="stylesheet" href="/static/style/components.css">

    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css_file): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($css_file) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
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

<?= $content ?>

<footer>&copy; <?= date('Y') ?> Yan Wittmann</footer>
</body>
</html>