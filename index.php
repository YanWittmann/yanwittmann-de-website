<?php

require __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\View;
use App\ContentRenderer;
use Bramus\Router\Router;

$config = require __DIR__ . '/config.php';
$db = new Database($config);
$router = new Router();
$renderer = new ContentRenderer();

$router->set404(function() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    View::render('404', ['title' => 'Page Not Found']);
});

// Homepage
$router->get('/', function() use ($db) {
    $stmt = $db->query("SELECT * FROM homepage_projects ORDER BY featured DESC, created_at DESC LIMIT 4");
    $projects = $stmt->fetchAll();

    $stmt = $db->query("SELECT * FROM homepage_posts ORDER BY featured DESC, created_at DESC LIMIT 4");
    $posts = $stmt->fetchAll();

    View::render('home', [
        'projects' => $projects,
        'posts' => $posts
    ]);
});

// Projects
$router->get('/projects', function() use ($db) {
    $stmt = $db->query("SELECT * FROM homepage_projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();
    View::render('projects_list', ['title' => 'My Projects', 'projects' => $projects]);
});

$router->get('/projects/([^/]+)', function($slug) use ($db, $renderer) {
    $sql = "
        SELECT 
            p.*, 
            c.content, 
            c.is_markdown 
        FROM homepage_projects p
        JOIN homepage_content c ON p.content_id = c.id
        WHERE p.slug = ?
    ";
    $stmt = $db->query($sql, [$slug]);
    $project = $stmt->fetch();

    if (!$project) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::render('404', ['title' => 'Project Not Found']);
        return;
    }

    $project['content'] = $renderer->render($project['content'], (bool)$project['is_markdown']);

    View::render('project_detail', [
        'title' => $project['title'],
        'project' => $project
    ]);
});

// Blog
$router->get('/blog', function() use ($db) {
    $stmt = $db->query("SELECT * FROM homepage_posts ORDER BY created_at DESC");
    $posts = $stmt->fetchAll();
    View::render('blog_list', ['title' => 'Blog', 'posts' => $posts]);
});

$router->get('/blog/([^/]+)', function($slug) use ($db, $renderer) {
    $sql = "
        SELECT p.*, c.content, c.is_markdown
        FROM homepage_posts p
        JOIN homepage_content c ON p.content_id = c.id
        WHERE p.slug = ?
    ";
    $stmt = $db->query($sql, [$slug]);
    $post = $stmt->fetch();

    if (!$post) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::render('404', ['title' => 'Post Not Found']);
        return;
    }

    $post['content'] = $renderer->render($post['content'], (bool)$post['is_markdown']);

    View::render('blog_detail', [
        'title' => $post['title'],
        'post' => $post
    ]);
});

$router->run();