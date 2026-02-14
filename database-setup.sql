CREATE TABLE homepage_content
(
    id          int NOT NULL PRIMARY KEY,
    content     longtext DEFAULT NULL,
    is_markdown tinyint(1) DEFAULT 1
);

CREATE TABLE homepage_posts
(
    id          int          NOT NULL PRIMARY KEY,
    slug        varchar(255) NOT NULL,
    title       varchar(255) NOT NULL,
    description text     DEFAULT NULL,
    image       text     DEFAULT NULL,
    featured    bool     DEFAULT false,
    tags        JSON     DEFAULT NULL,
    created_at  datetime DEFAULT CURRENT_TIMESTAMP(),
    content_id  int,
    FOREIGN KEY (content_id) REFERENCES homepage_content (id)
);

CREATE TABLE homepage_projects
(
    id          int          NOT NULL PRIMARY KEY,
    slug        varchar(255) NOT NULL,
    category    varchar(50) DEFAULT 'Project',
    title       varchar(255) NOT NULL,
    description text        DEFAULT NULL,
    image       text        DEFAULT NULL,
    featured    bool        DEFAULT false,
    tags        JSON        DEFAULT NULL,
    links       JSON        DEFAULT NULL,
    created_at  datetime    DEFAULT CURRENT_TIMESTAMP(),
    content_id  int,
    FOREIGN KEY (content_id) REFERENCES homepage_content (id)
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
