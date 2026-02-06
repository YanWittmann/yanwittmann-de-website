<?php

if (!function_exists('generate_breadcrumbs')) {
    function generate_breadcrumbs(array $crumbs = []): void {
        echo '<div class="breadcrumbs">';

        $last_key = array_key_last($crumbs);
        foreach ($crumbs as $key => $crumb) {
            if ($key !== $last_key && isset($crumb['url'])) {
                echo '<a href="' . htmlspecialchars($crumb['url']) . '">' . htmlspecialchars($crumb['label']) . '</a>';
                echo '<span class="separator">/</span>';
            } else {
                echo '<span>' . htmlspecialchars($crumb['label']) . '</span>';
            }
        }

        echo '</div>';
    }
}