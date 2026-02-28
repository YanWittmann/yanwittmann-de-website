<?php

namespace App;

use HTMLPurifier;
use HTMLPurifier_Config;

class ContentRenderer
{
    private $purifier;
    private $parsedown;

    private array $pathMappings =[
        'img' => '/content/img',
    ];

    public function __construct()
    {
        $this->parsedown = new CustomParsedown();

        $config = HTMLPurifier_Config::createDefault();

        $config->set('Attr.EnableID', true);
        $config->set('HTML.TargetBlank', true);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('Attr.AllowedRel', ['noopener', 'noreferrer']);
        $config->set('HTML.Allowed', 'p,b,strong,i,em,u,a[href|title|target|rel],ul,ol,li,br,img[src|alt|height|width],h1,h2,h3,h4,h5,h6,blockquote,code[class],pre[class],table,thead,tbody,tr,th,td,div[class],span[class]');

        $config->set('Cache.SerializerPath', sys_get_temp_dir());

        $this->purifier = new HTMLPurifier($config);
    }

    public function render(string $content, bool $isMarkdown): string
    {
        if ($isMarkdown) {
            $content = $this->parsedown->text($content);
        }

        foreach ($this->pathMappings as $type => $basePath) {
            $pattern = '/(src|href)=["\']@' . preg_quote($type, '/') . ':([^"\']+)["\']/i';
            $content = preg_replace_callback($pattern, function ($matches) use ($basePath) {
                $attr = $matches[1];
                $path = ltrim($matches[2], '/');
                $resolved = rtrim($basePath, '/') . '/' . $path;
                return $attr . '="' . $resolved . '"';
            }, $content);
        }

        return $this->purifier->purify($content);
    }
}