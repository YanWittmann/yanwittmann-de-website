<?php

namespace App;

use Parsedown;

class CustomParsedown extends Parsedown
{
    protected function inlineLink($Excerpt)
    {
        $link = parent::inlineLink($Excerpt);

        if (!isset($link)) { return null; }

        $href = $link['element']['attributes']['href'];

        if (strpos($href, 'http') === 0) {
            $link['element']['attributes']['rel'] = 'noopener noreferrer';
        }

        return $link;
    }
}