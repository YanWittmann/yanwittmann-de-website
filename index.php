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
    View::renderLayout('404', [
        'page_title' => 'Page Not Found',
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => '404']
        ]
    ]);
});

// Homepage
$router->get('/', function () use ($db) {
    $projects = $db->query("SELECT c.*, p.category, p.links FROM homepage_content c JOIN homepage_projects p ON c.id = p.content_id ORDER BY c.featured DESC, c.created_at DESC LIMIT 4")->fetchAll();

    $posts = $db->query("SELECT c.* FROM homepage_content c JOIN homepage_posts p ON c.id = p.content_id ORDER BY c.created_at DESC LIMIT 4")->fetchAll();

    $sidebar = View::getOutput('partials/sidebar_home', []);
    $sidebar .= View::getOutput('partials/sidebar_draw', []);
    $age = (new DateTime("2000-05-07"))->diff(new DateTime())->y;

    View::renderLayout('home', [
        'page_title' => "Hi, I'm Yan!",
        'page_subtitle' => 'SOFTWARE ENGINEER // ' . $age . ' YEARS // @SKYBALL',
        'page_intro' => "I build tools, websites, and games. While you're here, check out some of my projects below.",
        'projects' => $projects,
        'posts' => $posts,
        'sidebar' => $sidebar,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/']
        ]
    ]);
});

// Projects List
$router->get('/projects', function () use ($db) {
    $activeCategory = $_GET['category'] ?? null;
    $activeTag = $_GET['tag'] ?? null;
    $hasActiveFilter = $activeCategory !== null || $activeTag !== null;

    $params = [];
    $sql = "SELECT c.*, p.category, p.links FROM homepage_content c JOIN homepage_projects p ON c.id = p.content_id";

    if ($activeCategory) {
        $sql .= " WHERE p.category = ?";
        $params[] = $activeCategory;
    } elseif ($activeTag) {
        $sql .= " WHERE JSON_CONTAINS(c.tags, ?)";
        $params[] = '"' . $activeTag . '"';
    }

    $sql .= " ORDER BY c.created_at DESC";
    $projects = $db->query($sql, $params)->fetchAll();

    $categories = $db->query("SELECT DISTINCT category FROM homepage_projects WHERE category IS NOT NULL AND category != '' ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN);
    $categoryLinks = [];
    foreach ($categories as $cat) {
        $categoryLinks[] = [
            'label' => $cat,
            'url' => '/projects?category=' . urlencode($cat),
            'active' => $activeCategory === $cat
        ];
    }

    $allTagsJson = $db->query("SELECT c.tags FROM homepage_content c JOIN homepage_projects p ON c.id = p.content_id WHERE c.tags IS NOT NULL AND JSON_VALID(c.tags) AND JSON_LENGTH(c.tags) > 0")->fetchAll(PDO::FETCH_COLUMN);

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

    $sidebar = View::getOutput('partials/sidebar_project_list', [
        'resetUrl' => $hasActiveFilter ? '/projects' : null,
        'categories' => $categoryLinks,
        'tags' => $tagLinks
    ]);

    $pageTitle = 'All Projects';

    if ($activeCategory) {
        $pageTitle = $activeCategory;
    } elseif ($activeTag) {
        $pageTitle = $activeTag;
    }

    View::renderLayout('projects_list', [
        'page_title' => $pageTitle,
        'page_intro' => 'A complete collection of my work, experiments, and open-source contributions.',
        'projects' => $projects,
        'sidebar' => $sidebar,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'projects']
        ],
        'extra_css' => ['/static/style/prose.css']
    ]);
});

// Single Project
$router->get('/projects/([^/]+)', function ($slug) use ($db, $renderer) {
    $stmt = $db->query("SELECT c.*, p.category, p.links FROM homepage_content c JOIN homepage_projects p ON c.id = p.content_id WHERE c.slug = ?", [$slug]);
    $project = $stmt->fetch();

    if (!$project) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::renderLayout('404', [
            'page_title' => 'Project Not Found',
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

    View::renderLayout('project_detail', [
        'page_title' => $project['title'],
        'page_subtitle' => date('Y-m-d', strtotime($project['created_at'])) . ' // ' . ($project['category'] ?? 'Project'),
        'page_intro' => $project['description'],
        'project' => $project,
        'sidebar' => $sidebar,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'projects', 'url' => '/projects'],
            ['label' => $project['title']]
        ],
        'extra_css' => ['/static/style/prose.css']
    ]);
});

// Blog List
$router->get('/blog', function () use ($db) {
    $posts = $db->query("SELECT c.* FROM homepage_content c JOIN homepage_posts p ON c.id = p.content_id ORDER BY c.created_at DESC")->fetchAll();

    View::renderLayout('blog_list', [
        'page_title' => 'Latest Posts',
        'page_intro' => 'Read my latest thoughts and updates.',
        'posts' => $posts,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'blog']
        ],
        'extra_css' => ['/static/style/prose.css']
    ]);
});

// Single Post
$router->get('/blog/([^/]+)', function ($slug) use ($db, $renderer) {
    $stmt = $db->query("SELECT c.* FROM homepage_content c JOIN homepage_posts p ON c.id = p.content_id WHERE c.slug = ?", [$slug]);
    $post = $stmt->fetch();

    if (!$post) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::renderLayout('404', [
            'page_title' => 'Post Not Found',
            'breadcrumbs' => [
                ['label' => 'yanwittmann.de', 'url' => '/'],
                ['label' => '404 Not Found']
            ]
        ]);
        return;
    }

    $post['tags'] = json_decode($post['tags'] ?? '[]', true);
    $post['content'] = $renderer->render($post['content'], (bool)$post['is_markdown']);

    $props = [
        'page_title' => $post['title'],
        'page_subtitle' => date('Y-m-d', strtotime($post['created_at'])),
        'page_intro' => $post['description'],
        'page_header_order' => "intro",
        'post' => $post,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'blog', 'url' => '/blog'],
            ['label' => $post['title']]
        ],
        'extra_css' => ['/static/style/prose.css']
    ];

    if (isset($post['image'])) {
        $sidebar = View::getOutput('partials/sidebar_post', [
            'post' => $post
        ]);
        $props['sidebar'] = $sidebar;
    }

    View::renderLayout('blog_detail', $props);
});

$router->get('/pages(/.*)?', function ($path = '/') use ($db) {
    $path = trim($path, '/');
    $baseDir = __DIR__ . '/homepage/pages/';
    $targetPath = realpath($baseDir . $path);

    if (!$targetPath || strpos($targetPath, realpath($baseDir)) !== 0) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::renderLayout('404', [
            'page_title' => 'Page Not Found',
            'breadcrumbs' => [
                ['label' => 'yanwittmann.de', 'url' => '/'],
                ['label' => '404 Not Found']
            ]
        ]);
        return;
    }

    if (is_dir($targetPath)) {
        $targetPath = rtrim($targetPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'index.html';
    }

    if (file_exists($targetPath) && pathinfo($targetPath, PATHINFO_EXTENSION) === 'html') {
        $content = file_get_contents($targetPath);

        $pageTitle = 'Page';
        if (preg_match('/<title>(.*?)<\/title>/is', $content, $matches)) {
            $pageTitle = trim($matches[1]);
        }

        View::renderSparseLayout('noop', [
            'page_title' => $pageTitle,
            'content' => $content,
            'breadcrumbs' => [
                ['label' => 'yanwittmann.de', 'url' => '/'],
                ['label' => 'pages'],
                ['label' => $pageTitle]
            ],
            'extra_css' => ['/static/style/prose.css', '/static/style/components.css']
        ]);
    } else {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        View::renderLayout('404', [
            'page_title' => 'Page Not Found',
            'breadcrumbs' => [
                ['label' => 'yanwittmann.de', 'url' => '/'],
                ['label' => '404 Not Found']
            ]
        ]);
    }
});

// API: Guestbook Submission
$router->post('/api/guestbook', function () use ($db, $config) {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $salt = $config['rate_limit_salt'];
    $user_hash = hash('sha256', $ip . $salt);

    $stmt = $db->query("SELECT created_at FROM homepage_guestbook WHERE user_hash = ? ORDER BY created_at DESC LIMIT 1", [$user_hash]);
    $lastPost = $stmt->fetch();

    if ($lastPost) {
        $lastTime = strtotime($lastPost['created_at']);
        if (time() - $lastTime < 300) { // 5 minutes
            http_response_code(429);
            echo json_encode(['success' => false, 'message' => 'Please wait before posting again.']);
            return;
        }
    }

    $author = isset($input['author']) ? substr(strip_tags(trim($input['author'])), 0, 100) : 'Anonymous';
    $note = isset($input['note']) ? substr(strip_tags(trim($input['note'])), 0, 255) : '';
    $image = $input['image'] ?? '';

    if (empty($author)) {
        $author = 'Anonymous';
    }

    // Basic validation for image data
    if (strpos($image, 'data:image/png;base64') === 0) {
        if (strlen($image) > 700000) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Drawing is too complex.']);
            return;
        }
        $db->query(
            "INSERT INTO homepage_guestbook (author, note, image_data, user_hash) VALUES (?, ?, ?, ?)",
            [$author, $note, $image, $user_hash]
        );
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid image data.']);
    }
});

// Guestbook Preview
$router->get('/api/guestbook/view', function () use ($db) {
    if (!isset($_GET['auth']) || $_GET['auth'] !== 'yan') {
        die("What are you doing here?");
    }

    $messages = $db->query("SELECT * FROM homepage_guestbook ORDER BY created_at DESC")->fetchAll();
    View::renderLayout('view_submissions', [
        'page_title' => 'Submissions',
        'page_intro' => 'Showing ' . count($messages) . ' entries below',
        'messages' => $messages,
        'breadcrumbs' => [
            ['label' => 'yanwittmann.de', 'url' => '/'],
            ['label' => 'guestbook'],
            ['label' => "Submissions"]
        ],
        'extra_css' => ['/static/style/prose.css', '/static/style/components.css']
    ]);
});

$router->run();