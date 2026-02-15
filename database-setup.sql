CREATE TABLE homepage_content
(
    id          int          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    slug        varchar(255) NOT NULL UNIQUE,
    title       varchar(255) NOT NULL,
    description text     DEFAULT NULL,
    image       text     DEFAULT NULL,
    featured    bool     DEFAULT false,
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
    content_id int NOT NULL PRIMARY KEY,
    category   varchar(50) DEFAULT 'Project',
    links      JSON        DEFAULT NULL,
    FOREIGN KEY (content_id) REFERENCES homepage_content (id) ON DELETE CASCADE
);

CREATE TABLE homepage_guestbook
(
    id         int          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    author     varchar(100) NOT NULL,
    note       varchar(255) DEFAULT NULL,
    image_data LONGTEXT     NOT NULL,
    user_hash  varchar(64)  NOT NULL,
    created_at datetime     DEFAULT CURRENT_TIMESTAMP()
);