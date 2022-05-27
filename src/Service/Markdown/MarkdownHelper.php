<?php

namespace App\Service\Markdown;

use Michelf\MarkdownInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    private AdapterInterface $cache;
    private MarkdownInterface $markdown;

    public function __construct(
        AdapterInterface $cache,
        MarkdownInterface $markdown
    ) {
        $this->cache = $cache;
        $this->markdown = $markdown;
    }

    public function parse(string $articleContent)
    {
        $cacheItem = $this->cache->getItem('markdown_' . md5($articleContent));
        if (!$cacheItem->isHit()){
            $cacheItem->set($this->markdown->transform($articleContent));
            $this->cache->save($cacheItem);
        }
        return $cacheItem->get();
    }
}