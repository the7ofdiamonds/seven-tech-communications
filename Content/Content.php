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

    function getPageContent($page_slug, $post_type = '')
    {
        try {
            $parts = explode("/", $page_slug);
            $parts = array_filter($parts, function($value) {
                return !empty(trim($value));
            });
            $index_end = count($parts) - 1;
            $page_path = $parts[$index_end];
error_log($page_path);

            $page = get_page_by_path($page_path, '', $post_type);
            // error_log(print_r($page_path, true));
            // error_log(print_r($post_type, true));

            if ($page == null) {
                return '';
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
            throw new Exception($e);
        }
    }
}
