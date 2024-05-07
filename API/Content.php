<?php

namespace SEVEN_TECH\Communications\API;

use Exception;

use WP_REST_Request;

use SEVEN_TECH\Communications\Content\Content as PageContent;

class Content
{
    private $page_content;

    public function __construct()
    {
        $this->page_content = new PageContent;
    }

    function get_content(WP_REST_Request $request)
    {
        try {
            $page_slug = $request->get_param('slug');
            $post_type = !empty($request['post_type']) ? $request['post_type'] : 'page';

            $content = $this->page_content->getPageContent($page_slug, $post_type);

            if (empty($content)) {
                throw new Exception('No content available.', 404);
            }

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
