<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/homepage/src/helpers.php';

use App\Database;
use App\View;
use App\ContentRenderer;
use Bramus\Router\Router;

$config = require __DIR__ . '/config.php';
$db = new Database($config);
$router = new Router();
$renderer = new ContentRenderer();

$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    View::render('404', [
        'title' => 'Page Not Found',
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => '404']
        ]
    ]);
});

// Homepage
$router->get('/', function () use ($db) {
    $projects = $db->query("SELECT * FROM homepage_projects ORDER BY featured DESC, created_at DESC LIMIT 4")->fetchAll();
    $posts = $db->query("SELECT * FROM homepage_posts ORDER BY created_at DESC LIMIT 3")->fetchAll();

    View::render('home', [
        'projects' => $projects,
        'posts' => $posts,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/']
        ],
        'extra_css' => ['/static/style/home.css', '/static/style/content.css']
    ]);
});

// Projects List
$router->get('/projects', function () use ($db) {
    $activeCategory = $_GET['category'] ?? null;
    $activeTag = $_GET['tag'] ?? null;

    $params = [];
    $sql = "SELECT * FROM homepage_projects";
    if ($activeCategory) {
        $sql .= " WHERE category = ?";
        $params[] = $activeCategory;
    } elseif ($activeTag) {
        $sql .= " WHERE JSON_CONTAINS(tags, ?)";
        $params[] = '"' . $activeTag . '"';
    }
    $sql .= " ORDER BY created_at DESC";
    $projects = $db->query($sql, $params)->fetchAll();

    $categories = $db->query("SELECT DISTINCT category FROM homepage_projects WHERE category IS NOT NULL AND category != '' ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN);
    $categoryLinks = [];
    $categoryLinks[] = [
        'label' => 'No Filter',
        'url' => '/projects',
        'active' => !$activeCategory && !$activeTag
    ];
    foreach ($categories as $cat) {
        $categoryLinks[] = [
            'label' => $cat,
            'url' => '/projects?category=' . urlencode($cat),
            'active' => $activeCategory === $cat
        ];
    }

    $allTagsJson = $db->query("SELECT tags FROM homepage_projects WHERE tags IS NOT NULL AND JSON_VALID(tags) AND JSON_LENGTH(tags) > 0")->fetchAll(PDO::FETCH_COLUMN);
    $allTags = [];
    foreach ($allTagsJson as $jsonString) {
        $decodedTags = json_decode($jsonString, true);
        if (is_array($decodedTags)) {
            $allTags = array_merge($allTags, $decodedTags);
        }
    }
    $uniqueTags = array_unique($allTags);
    sort($uniqueTags);
    $tagLinks = [];
    foreach ($uniqueTags as $tag) {
        $tagLinks[] = [
            'label' => $tag,
            'url' => '/projects?tag=' . urlencode($tag),
            'active' => $activeTag === $tag
        ];
    }

    $sidebarData = [
        'groups' => [
            ['title' => 'Categories', 'links' => $categoryLinks],
            ['title' => 'Tags', 'links' => $tagLinks]
        ]
    ];
    $sidebar = View::getOutput('partials/sidebar_generic', $sidebarData);

    $pageTitle = 'All Projects';
    if ($activeCategory) {
        $pageTitle = $activeCategory;
    } elseif ($activeTag) {
        $pageTitle = 'Tagged: ' . $activeTag;
    }

    View::render('projects_list', [
        'title' => $pageTitle,
        'subtitle' => 'A complete collection of my work, experiments, and open-source contributions.',
        'projects' => $projects,
        'sidebar' => $sidebar,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'projects']
        ],
        'extra_css' => ['/static/style/content.css', '/static/style/prose.css']
    ]);
});

// Single Project
$router->get('/projects/([^/]+)', function ($slug) use ($db, $renderer) {
    $stmt = $db->query("SELECT p.*, c.content, c.is_markdown FROM homepage_projects p JOIN homepage_content c ON p.content_id = c.id WHERE p.slug = ?", [$slug]);
    $project = $stmt->fetch();

    if (!$project) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::render('404', [
            'title' => 'Project Not Found',
            'breadcrumbs' => [
                ['label' => 'yanwittmann.de', 'url' => '/'],
                ['label' => '404 Not Found']
            ]]);
        return;
    }

    $project['tags'] = json_decode($project['tags'] ?? '[]', true);
    $project['links'] = json_decode($project['links'] ?? '[]', true);
    $project['content'] = $renderer->render($project['content'], (bool)$project['is_markdown']);

    $sidebar = View::getOutput('partials/sidebar_project', [
        'project' => $project
    ]);

    View::render('project_detail', [
        'title' => $project['title'],
        'subtitle' => $project['description'],
        'project' => $project,
        'sidebar' => $sidebar,
        "page_size" => "1200",
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'projects', 'url' => '/projects'],
            ['label' => $project['title']]
        ],
        'extra_css' => ['/static/style/content.css', '/static/style/prose.css']
    ]);
});

// Blog List
$router->get('/blog', function () use ($db) {
    $posts = $db->query("SELECT * FROM homepage_posts ORDER BY created_at DESC")->fetchAll();

    View::render('blog_list', [
        'title' => 'Latest Posts',
        'subtitle' => 'Read my latest thoughts and updates.',
        'posts' => $posts,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'blog']
        ],
        'extra_css' => ['/static/style/content.css', '/static/style/prose.css']
    ]);
});

// Single Post
$router->get('/blog/([^/]+)', function ($slug) use ($db, $renderer) {
    $stmt = $db->query("SELECT p.*, c.content, c.is_markdown FROM homepage_posts p JOIN homepage_content c ON p.content_id = c.id WHERE p.slug = ?", [$slug]);
    $post = $stmt->fetch();

    if (!$post) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::render('404', [
            'title' => 'Post Not Found',
            'breadcrumbs' => [
                ['label' => 'yanwittmann.de', 'url' => '/'],
                ['label' => '404 Not Found']
            ]
        ]);
        return;
    }

    $post['tags'] = json_decode($post['tags'] ?? '[]', true);
    $post['content'] = $renderer->render($post['content'], (bool)$post['is_markdown']);

    $sidebar = View::getOutput('partials/sidebar_post', [
        'post' => $post
    ]);

    View::render('blog_detail', [
        'title' => $post['title'],
        'subtitle' => $post['description'],
        'post' => $post,
        'sidebar' => $sidebar,
        "page_size" => "1100",
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'blog', 'url' => '/blog'],
            ['label' => $post['title']]
        ],
        'extra_css' => ['/static/style/content.css', '/static/style/prose.css']
    ]);
});

$router->run();