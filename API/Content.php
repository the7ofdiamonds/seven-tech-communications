<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

class Content
{
    function get_content(WP_REST_Request $request)
    {
        try {
            $page_slug = $request->get_param('slug');
            $page = get_page_by_path($page_slug);

            if (empty($page) || $page == null) {
                throw new Exception('Page not found', 404);
            }

            $page_id = $page->ID;
            $page = get_post($page_id);
            $page_content = $page->post_content;

            $contentRegex = '/<!-- wp:paragraph -->(.*?)<!-- \/wp:paragraph -->/s';

            preg_match_all($contentRegex, $page_content, $matches);

            $contentArray = [];

            foreach ($matches[1] as $matched_content) {
                $contentArray[] = $matched_content;
            }

            header('Content-Type: text/html; charset=UTF-8');

            $content = [
                'content' => $contentArray,
                'title' => $page->post_title
            ];

            return rest_ensure_response($content);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response_data = [
                'statusCode' => $statusCode,
                'errorMessage' => $e->getMessage(),
            ];
            $response = rest_ensure_response($response_data);
            $response->set_status($statusCode);

            return $response;
        }
    }
}
