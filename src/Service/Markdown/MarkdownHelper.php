<?php

namespace App\Service\Markdown;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    private AdapterInterface $cache;
    private MarkdownInterface $markdown;
    private LoggerInterface $logger;

    public function __construct(
        AdapterInterface $cache,
        MarkdownInterface $markdown,
        LoggerInterface $logger
    ) {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $logger;
    }

    public function parse(string $source)
    {
        if (stripos($source, 'bacon') !== false) {
            $this->logger->info('They are talking about bacon agains!');
        }

        $cacheItem = $this->cache->getItem('markdown_' . md5($source));
        if (!$cacheItem->isHit()){
            $cacheItem->set($this->markdown->transform($source));
            $this->cache->save($cacheItem);
        }
        return $cacheItem->get();
    }
}