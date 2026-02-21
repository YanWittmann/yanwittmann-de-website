<?php

if (!function_exists('generate_breadcrumbs')) {
    function generate_breadcrumbs(array $crumbs = []): void
    {
        echo '<div class="breadcrumbs">';

        $last_key = array_key_last($crumbs);
        foreach ($crumbs as $key => $crumb) {
            # $label = htmlspecialchars(preg_replace('/\s+/', '-', preg_replace('/[^a-z0-9.\s]/', '', strtolower($crumb['label']))));
            $label = $crumb['label'];

            if (isset($crumb['url'])) {
                echo '<a href="' . htmlspecialchars($crumb['url']) . '">' . $label . '</a>';
            } else {
                echo '<span>' . $label . '</span>';
            }

            if ($key !== $last_key) {
                echo '<span class="separator">/</span>';
            }
        }

        echo '</div>';
    }
}

if (!function_exists('parse_json_list')) {
    function parse_json_list($data): array
    {
        if (is_array($data)) {
            return $data;
        }
        if (empty($data)) {
            return [];
        }
        $decoded = json_decode($data, true);
        return is_array($decoded) ? $decoded : [];
    }
}

if (!function_exists('icon')) {
    function icon(string $name, string $class = '', string $style = ''): string
    {
        $classAttr = htmlspecialchars(trim("icon icon-" . $name . " " . $class));
        $styleAttr = $style ? ' style="' . htmlspecialchars($style) . '"' : '';

        return '<svg class="' . $classAttr . '"' . $styleAttr . ' width="1em" height="1em"><use href="/homepage/static/img/sprite.svg#icon-' . htmlspecialchars($name) . '"></use></svg>';
    }
}

if (!function_exists('isMobileClient')) {
    // Case-insensitive check for "Mobi".
    // This catches iPhone, Android Mobile, WebOS, etc.
    // It intentionally excludes iPad/Tablets, which usually handle desktop layouts fine.
    function isMobileClient(): bool
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return stripos($userAgent, 'Mobi') !== false;
    }

    // Checks for 'Mobi' OR specific tablet identifiers (Android without Mobi, iPad, Kindle)
    /*function isMobileClient(): bool {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return preg_match("/(Mobi|Android|iPad|Kindle|Silk\/|PlayBook)/i", $userAgent);
    }*/
}