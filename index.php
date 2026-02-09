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
    $projects = $db->query("SELECT * FROM homepage_projects ORDER BY created_at DESC")->fetchAll();
    View::render('projects_list', [
        'title' => 'All Projects',
        'subtitle' => ' A complete collection of my work, experiments, and open-source contributions.',
        'projects' => $projects,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'projects']
        ],
        'extra_css' => ['/static/style/content.css']
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

    View::render('project_detail', [
        'title' => $project['title'],
        'tags' => $project['tags'],
        'project' => $project,
        "page_size" => "900",
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'projects', 'url' => '/projects'],
            ['label' => $project['title']]
        ],
        'extra_css' => ['/static/style/content.css']
    ]);
});

// Blog List
$router->get('/blog', function () use ($db) {
    $posts = $db->query("SELECT * FROM homepage_posts ORDER BY created_at DESC")->fetchAll();
    View::render('blog_list', [
        'title' => 'Blog',
        'posts' => $posts,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'blog']
        ],
        'extra_css' => ['/static/style/content.css']
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

    View::render('blog_detail', [
        'title' => $post['title'],
        'post' => $post,
        'tags' => $post['tags'],
        "page_size" => "850",
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'blog', 'url' => '/blog'],
            ['label' => $post['title']]
        ],
        'extra_css' => ['/static/style/content.css']
    ]);
});

$router->run();