<?php

namespace Blogger\Tags;

class IncludablePosts extends Tag
{
    public array $dataPosts;

    public $htmlTag = 'div';

    function content(callable $callback)
    {
        foreach ($this->dataPosts as $post) {
            parent::content(function() use ($callback, $post) {
                return $callback($post);
            });
        }
    }
}