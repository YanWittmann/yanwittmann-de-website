<?php

namespace App;

class View
{
    public static function render(string $viewName, array $data = [])
    {
        // populate local variables with keys from the array
        extract($data);

        ob_start();

        $viewFile = __DIR__ . '/../templates/' . $viewName . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View file not found: $viewName";
        }

        $content = ob_get_clean();

        require __DIR__ . '/../templates/layout.php';
    }
}