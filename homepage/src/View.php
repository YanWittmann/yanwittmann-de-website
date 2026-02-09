<?php

namespace App;

class View
{
    public static function getOutput(string $viewName, array $data): string
    {
        $viewFile = __DIR__ . '/../templates/' . $viewName . '.php';

        ob_start();

        (function($viewFile, $data) {
            // populate local variables with keys from the array
            extract($data);
            if (file_exists($viewFile)) {
                require $viewFile;
            } else {
                echo "View file not found: " . basename($viewFile, '.php');
            }
        })($viewFile, $data);

        return ob_get_clean();
    }

    public static function render(string $viewName, array $data = []): void
    {
        $content = self::getOutput($viewName, $data);

        extract($data);
        require __DIR__ . '/../templates/layout.php';
    }

    public static function partial(string $viewName, array $data = []): void
    {
        echo self::getOutput('partials/' . $viewName, $data);
    }
}