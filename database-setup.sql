CREATE TABLE homepage_content
(
    id          int          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    slug        varchar(255) NOT NULL UNIQUE,
    title       varchar(255) NOT NULL,
    description text     DEFAULT NULL,
    image       text     DEFAULT NULL,
    tags        JSON     DEFAULT NULL,
    created_at  datetime DEFAULT CURRENT_TIMESTAMP(),
    content     longtext DEFAULT NULL,
    is_markdown tinyint(1) DEFAULT 1
);

CREATE TABLE homepage_posts
(
    content_id int NOT NULL PRIMARY KEY,
    FOREIGN KEY (content_id) REFERENCES homepage_content (id) ON DELETE CASCADE
);

CREATE TABLE homepage_projects
(
    content_id    int NOT NULL PRIMARY KEY,
    category      varchar(50)  DEFAULT 'Project',
    links         JSON         DEFAULT NULL,
    github_repo   varchar(100) DEFAULT NULL,
    feature_order int          DEFAULT 0,
    FOREIGN KEY (content_id) REFERENCES homepage_content (id) ON DELETE CASCADE,
    FOREIGN KEY (github_repo) REFERENCES homepage_github_stats (repo_id) ON DELETE SET NULL
);

CREATE TABLE homepage_github_stats
(
    repo_id               varchar(100) NOT NULL PRIMARY KEY,
    homepage_github_stats text,
    stars                 int          DEFAULT 0,
    forks                 int          DEFAULT 0,
    watchers              int          DEFAULT 0,
    open_issues           int          DEFAULT 0,
    size_kb               int          DEFAULT 0,
    homepage              varchar(255) DEFAULT NULL,
    license               varchar(50),
    is_archived           bool         DEFAULT false,
    topics                JSON,
    languages             JSON,
    last_pushed_at        datetime,
    last_synced_at        datetime     DEFAULT CURRENT_TIMESTAMP()
);

CREATE
OR REPLACE VIEW homepage_view_projects AS
SELECT c.*, p.*, s.*
FROM homepage_content c
         JOIN homepage_projects p ON c.id = p.content_id
         LEFT JOIN homepage_github_stats s ON p.github_repo = s.repo_id;

CREATE
OR REPLACE VIEW homepage_view_posts AS
SELECT c.*, p.*
FROM homepage_content c
         JOIN homepage_posts p ON c.id = p.content_id;
