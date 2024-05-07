<?php

namespace SEVEN_TECH\Communications\Content;

use Exception;

class Content
{
    public function __construct()
    {
    }

    function filter($page_content)
    {
        $contentArray = [];

        $parsed_blocks = parse_blocks($page_content);

        foreach ($parsed_blocks as $parsed_block) {
            $content = '';

            if (empty($parsed_block['innerBlocks']) && trim($parsed_block['innerHTML']) !== '') {
                $content .=  $parsed_block['innerHTML'];
            }

            if (!empty($parsed_block['innerBlocks']) && is_array($parsed_block['innerBlocks'])) {

                if (count($parsed_block['innerContent']) > 1) {
                    $content .= $parsed_block['innerContent'][0];

                    foreach ($parsed_block['innerBlocks'] as $block) {
                        $content .= $block['innerHTML'];
                    }

                    $last_item = count($parsed_block['innerContent']) - 1;

                    $content .= $parsed_block['innerContent'][$last_item];
                }

                if (count($parsed_block['innerContent']) == 1) {

                    foreach ($parsed_block['innerBlocks'] as $block) {
                        $content .= $block['innerHTML'];
                    }
                }
            }

            if (trim($content) === '') {
                continue;
            }

            $contentArray[] = $content;
        }

        return $contentArray;
    }

    function getPageContent($page_slug, $post_type = 'page')
    {
        try {
            $parts = explode("/", $page_slug);
            $parts = array_filter($parts, function($value) {
                return !empty(trim($value));
            });
            $parts = array_values($parts);
            $index_end = count($parts) >= 2 ? count($parts) - 1 : 0;
            $page_path = $parts[$index_end];

            $page = get_page_by_path($page_path, OBJECT, $post_type);

            if ($page == null) {
                return '';
            }

            $post = get_post($page->ID);

            header('Content-Type: text/html; charset=UTF-8');

            $content = [
                'content' => $this->filter($post->post_content),
                'title' => $page->post_title
            ];

            return $content;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
