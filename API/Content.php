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

            if ($page === null) {
                throw new Exception('Page not found', 404);
            }

            $page_id = $page->ID;
            $page = get_post($page_id);
            $page_content = $page->post_content;

            if (empty($page_content)) {
                throw new Exception('Page content not found', 404);
            }

            // Create a DOMDocument to parse the content with UTF-8 encoding
            $doc = new \DOMDocument('1.0', 'UTF-8');
            $doc->loadHTML($page_content);

            // Use DOMXPath to query for paragraphs
            $xpath = new \DOMXPath($doc);
            $paragraphs = $xpath->query('//p');

            $paragraphArray = [];

            // Function to normalize text and remove non-breaking spaces and unwanted characters
            function normalizeText($text)
            {
                // Replace non-breaking spaces with regular spaces
                $text = str_replace("\xc2\xa0", ' ', $text);
                // Remove other unwanted characters or non-printable characters
                $text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);
                return $text;
            }

            // Loop through the paragraphs and add their HTML content to the array
            foreach ($paragraphs as $paragraph) {
                // Extract the HTML content of the paragraph, normalize it, and remove unwanted characters
                $htmlContent = $doc->saveHTML($paragraph);
                $normalizedContent = normalizeText($htmlContent);
                $paragraphArray[] = $normalizedContent;
            }

            // Set the character encoding in the Content-Type header
            header('Content-Type: text/html; charset=UTF-8');

            return rest_ensure_response($paragraphArray);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $response_data = [
                'errorMessage' => $e->getMessage(),
                'statusCode' => $statusCode
            ];
            $response = rest_ensure_response($response_data);
            $response->set_status($statusCode);

            return $response;
        }
    }
}
