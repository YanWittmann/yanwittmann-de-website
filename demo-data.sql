
INSERT INTO `homepage_content` (`id`, `content`, `is_markdown`) VALUES
    (101, 'It\'s been a while, but I finally reworked my website. I can now easily create new blog posts or showcase projects I\'ve been working on. Let\'s see what the future holds!', 1),
    (102, 'A search bar for anything you need!\n\nUse this application to launch a variety of processes on your system.\nCurrently only supports Windows, but might be expanded to support other platforms. This is because the global key detector is based on the Windows API.', 1),
    (103, 'A shorter project description focusing on performance metrics.', 1);

INSERT INTO `homepage_projects` (`id`, `slug`, `title`, `description`, `created_at`, `content_id`, `image`, `featured`, `tags`) VALUES
    (23, 'test-2', 'LaunchAnything', 'A search bar available from anywhere with only two keystrokes. It can open local files, websites, copy text, has a powerful expression evaluator and so much more.', '2023-09-15 10:00:00', 102, NULL, 0, NULL),
    (51, 'project-alpha', 'LaunchAnything', 'A search bar available from anywhere with only two keystrokes. It can open local files, websites, copy text, has a powerful expression evaluator and so much more.', '2023-09-15 10:00:00', 102, '/static/img/launch_anything_logo.webp', 1, '[\"Java\", \"JNA\"]'),
    (52, 'project-zeta', 'OW Mod: Open Doors', 'A mod for the game Outer Wilds, written in C# that allows for opening hidden pathways in the game.', '2023-10-10 16:00:00', 103, '/static/img/open_doors_thumb.webp', 0, NULL);


INSERT INTO `homepage_posts` (`id`, `slug`, `title`, `description`, `created_at`, `content_id`, `image`, `featured`, `tags`) VALUES
    (1, 'first-blog-post', 'New Website Design', 'It\'s been a while, but I finally reworked my website. I can now easily create new blog posts or showcase projects I\'ve been working on. Let\'s see what the future holds!', '2023-10-25 08:00:00', 101, '/static/img/profile-picture-yan.webp', 0, '[]');
