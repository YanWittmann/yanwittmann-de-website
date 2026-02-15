INSERT INTO `homepage_content` (`id`, `content`, `is_markdown`) VALUES
    (101, 'It\'s been a while, but I finally reworked my website.', 1),
    (102, 'A search bar for anything you need!\n\nUse this application to launch a variety of processes on your system.', 1),
    (103, '<div class="layout-wide">\n<img src="/static/img/open_doors_thumb.webp" alt="Wide view">\n<figcaption>Figure 1: The hidden canyon entrance.</figcaption>\n</div>\n\nA shorter project description focusing on performance metrics.', 1);

INSERT INTO `homepage_projects` (`id`, `slug`, `category`, `title`, `description`, `created_at`, `content_id`, `image`, `featured`, `tags`, `links`) VALUES
     (23, 'test-2', 'Windows Utility', 'LaunchAnything', 'A search bar available from anywhere with only two keystrokes.', '2023-09-15 10:00:00', 102, NULL, 0, NULL, NULL),
     (51, 'project-alpha', 'Windows Utility', 'LaunchAnything', 'A search bar available from anywhere with only two keystrokes.', '2023-09-15 10:00:00', 102, '/static/img/launch_anything_logo.webp', 1, '["Java", "JNA"]', '[{"label": "Download", "url": "#", "style": "primary", "icon": "fas fa-download"}, {"label": "Source", "url": "#", "style": "secondary", "icon": "fab fa-github"}]'),
     (52, 'project-zeta', 'Game Mod', 'OW Mod: Open Doors', 'A mod for the game Outer Wilds.', '2023-10-10 16:00:00', 103, '/static/img/open_doors_thumb.webp', 0, '["C#", "Unity"]', '[{"label": "NexusMods", "url": "#", "style": "primary", "icon": "fas fa-cube"}]');

INSERT INTO `homepage_posts` (`id`, `slug`, `title`, `description`, `created_at`, `content_id`, `image`, `featured`, `tags`) VALUES
    (1, 'first-blog-post', 'New Website Design', 'It\'s been a while, but I finally reworked my website.', '2023-10-25 08:00:00', 101, '/static/img/profile-picture-yan-1.webp', 0, '[]');
