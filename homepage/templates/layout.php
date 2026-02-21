<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Yan Wittmann') ?></title>
    <meta name="description" content="Explore the portfolio of Yan Wittmann, a software engineer with a passion for game and web development.">
    <meta name="author" content="Yan Wittmann">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;600&family=Roboto+Slab:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/homepage/static/style/main.css">
    <link rel="stylesheet" href="/homepage/static/style/layout.css">
    <link rel="stylesheet" href="/homepage/static/style/components.css">

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

<div class="page-wrapper">

    <?php
    $allow_toggle = $allow_sidebar_toggle ?? false;
    $default_state = $sidebar_default_state ?? 'visible';
    ?>

    <?php if (isset($page_title)): ?>
        <header class="page-header">
            <h1 class="page-title"><?= $page_title ?></h1>
            <?php
            $has_subtitle = isset($page_subtitle);
            $has_intro = isset($page_intro);

            if ($has_subtitle && $has_intro) {
                $order = $page_header_order ?? 'subtitle';

                if ($order === 'subtitle') {
                    echo '<div class="page-subtitle">' . $page_subtitle . '</div>';
                    echo '<p class="intro-text">' . $page_intro . '</p>';
                } else {
                    echo '<p class="intro-text">' . $page_intro . '</p>';
                    echo '<div class="page-subtitle">' . $page_subtitle . '</div>';
                }
            } elseif ($has_subtitle) {
                echo '<div class="page-subtitle">' . $page_subtitle . '</div>';
            } elseif ($has_intro) {
                echo '<p class="intro-text">' . $page_intro . '</p>';
            }
            ?>
        </header>

        <!-- Separator + Toggle Button -->
        <div class="layout-separator-container">
            <hr class="layout-separator-line">
            <?php if (!empty($sidebar) && $allow_toggle): ?>
                <button id="sidebar-toggle" class="layout-toggle-btn" type="button" aria-label="Toggle Sidebar">
                    &raquo; Hide Sidebar
                </button>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="layout-grid">
        <main class="main-column">
            <?= $content ?>
        </main>

        <?php if (!empty($sidebar)): ?>
            <div class="sidebar-column" id="sidebar-col">
                <?= $sidebar ?>
            </div>

        <?php if ($allow_toggle): ?>
            <script>
                (function() {
                    const sidebar = document.getElementById('sidebar-col');
                    const toggleBtn = document.getElementById('sidebar-toggle');
                    const STATE_KEY = 'yanwittmann_sidebar_state';

                    if (!sidebar || !toggleBtn) return;

                    function setSidebarState(state) {
                        if (state === 'hidden') {
                            sidebar.classList.add('collapsed');
                            toggleBtn.innerHTML = '&laquo; Show Sidebar';
                        } else {
                            sidebar.classList.remove('collapsed');
                            toggleBtn.innerHTML = '&raquo; Hide Sidebar';
                        }
                    }

                    // LocalStorage overrides page default
                    const storedState = localStorage.getItem(STATE_KEY);
                    const initialState = storedState || '<?= $default_state ?>';

                    setSidebarState(initialState);

                    toggleBtn.addEventListener('click', function() {
                        const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
                        const newState = isCurrentlyCollapsed ? 'visible' : 'hidden';

                        setSidebarState(newState);
                        localStorage.setItem(STATE_KEY, newState);
                    });
                })();
            </script>
        <?php endif; ?>
        <?php endif; ?>
    </div>

</div>

<footer>&copy; <?= date('Y') ?> Yan Wittmann</footer>
</body>
</html>