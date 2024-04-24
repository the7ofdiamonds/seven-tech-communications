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

    function getPageContent($page_slug)
    {
        try {
            $pos = strpos($page_slug, "/");
            $post_type = 'page';
            $page = $page_slug;

            if ($pos !== false) {
                $parts = explode("/", $page_slug, 2);
                $post_type = $parts[0];
                $page = $parts[1];
            }

            $page = get_page_by_path($page, '', $post_type);

            if (empty($page) || $page == null) {
                throw new Exception('Page not found', 404);
            }

            $page_id = $page->ID;
            $page = get_post($page_id);
            $page_content = $page->post_content;

            header('Content-Type: text/html; charset=UTF-8');

            $content = [
                'content' => $this->filter($page_content),
                'title' => $page->post_title
            ];

            return $content;
        } catch (Exception $e) {
            error_log($e->getMessage(), $e->getCode());
        }
    }
}
