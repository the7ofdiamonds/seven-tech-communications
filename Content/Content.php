<?php

namespace SEVEN_TECH\Communications\Content;

use Exception;

class Content
{
    private $contentRegexs;

    public function __construct()
    {
        $paragraphRegex = '/<!-- wp:paragraph -->(.*?)<!-- \/wp:paragraph -->/s';
        $codeRegex = '/<!-- wp:code -->(.*?)<!-- \/wp:code -->/s';
        $galleryRegex = '/<!-- wp:gallery -->(.*?)<!-- \/wp:gallery -->/s';
        $orderedListRegex = '/<!-- wp:list {"ordered":true} -->(.*?)<!-- \/wp:list -->/s';
        $headingRegex = '/<!-- wp:heading -->(.*?)<!-- \/wp:heading -->/s';
        $imageRegex = '/<!-- wp:image {"id":149,"sizeSlug":"full","linkDestination":"none"} -->(.*?)<!-- \/wp:image -->/s';

        $this->contentRegexs = [
            $headingRegex,
            $paragraphRegex,
            $codeRegex,
            $galleryRegex,
            $orderedListRegex,
            $imageRegex
        ];
    }

    function filter($page_content)
    {
        $contentArray = [];

        foreach ($this->contentRegexs as $contentRegex) {
            preg_match_all($contentRegex, $page_content, $matches);

            foreach ($matches[1] as $matched_content) {
                $contentArray[] = $matched_content;
            }
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
            
            $html = preg_split('/<!-- wp:.* -->(.*?)<!-- \/wp:.* -->/', $page_content);

            error_log(print_r($html, true));

            $contentArray = $this->filter($page_content);

            header('Content-Type: text/html; charset=UTF-8');

            $content = [
                'content' => $contentArray,
                'title' => $page->post_title
            ];

            return $content;
        } catch (Exception $e) {
            error_log($e->getMessage(), $e->getCode());
        }
    }
}
