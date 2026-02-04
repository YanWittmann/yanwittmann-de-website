<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My Personal Site' ?></title>
    <link rel="stylesheet" href="/static/style/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header class="site-header">
    <div class="header-content">
        <a href="/" class="no-link-style">Yan Wittmann</a>
        <nav>
            <a href="/projects" class="no-link-style">Projects</a>
            <a href="/blog" class="no-link-style">Blog</a>
        </nav>
    </div>
</header>

<main class="main-layout">
    <?= $content ?>
</main>

<footer>
    &copy; <?= date('Y') ?> Yan Wittmann
</footer>

</body>
</html>