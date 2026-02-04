INSERT INTO homepage_content (id, content, is_markdown) VALUES
    (101, '# Welcome to My Blog\n\nThis is the content for the first blog post.', 1),
    (102, '<h2>Project Alpha Overview</h2>\n\nProject Alpha uses advanced data mining techniques.', 0),
    (103, 'A shorter project description focusing on performance metrics.', 1),
    (104, '# Latest News: Deployment Successful\n\nWe successfully deployed the new feature set.', 1);

INSERT INTO homepage_posts (id, slug, title, description, created_at, content_id) VALUES
    (1, 'first-blog-post', 'My First Official Post', 'A quick introduction to what this blog will cover.', '2023-10-25 08:00:00', 101),
    (2, 'deployment-success', 'Successful Q4 Deployment', 'Details about the latest software release and deployment.', '2023-11-01 14:30:00', 104);

INSERT INTO homepage_projects (id, slug, title, description, created_at, content_id) VALUES
    (51, 'project-alpha', 'Project Alpha: Data Miner', 'A complex data analysis tool built using Python.', '2023-09-15 10:00:00', 102),
    (52, 'project-zeta', 'Project Zeta: Performance Dashboard', 'A real-time dashboard for monitoring system performance.', '2023-10-10 16:00:00', 103);
