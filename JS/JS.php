<?php

namespace SEVEN_TECH\Communications\JS;

use Exception;

class JS
{
    private $dir;
    private $dirURL;
    private $buildDir;
    private $buildDirURL;
    private $includes_url;

    public function __construct()
    {
        $this->dir = SEVEN_TECH_COMMUNICATIONS;
        $this->dirURL = SEVEN_TECH_COMMUNICATIONS_URL;

        $this->buildDir = $this->dir . 'dist/js/';
        $this->buildDirURL = $this->dirURL . 'dist/js/';

        $this->includes_url = includes_url();
    }

    function load_react_index()
    {
        $indexPath = $this->buildDir . 'index.js';
        $indexPathURL = $this->buildDirURL . 'index.js';

        if (file_exists($indexPath)) {
            echo '<script type="module" src="' . esc_url($indexPathURL) . '"></script>';
        } else {
            throw new Exception('Index page has not been created in react JSX.', 404);
        }
    }

    function load_front_page_react($section)
    {
        try {
            $this->load_react_index();

            if (!empty($section)) {
                wp_enqueue_script('wp-element', $this->includes_url . 'js/dist/element.min.js', [], null, true);

                $filePath = $this->buildDir . $section . '.js';
                $filePathURL = $this->buildDirURL . $section . '.js';

                if (file_exists($filePath)) {
                    echo '<script type="module" src="' . esc_url($filePathURL) . '"></script>';
                } else {
                    throw new Exception($section . ' page has not been created in react JSX.', 404);
                }
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at load_front_page_react');

            return $response;
        }
    }

    function load_pages_react($page)
    {
        try {
            $this->load_react_index();

            if (!empty($page)) {
                $filePath = $this->buildDir . $page . '.js';
                $filePathURL = $this->buildDirURL . $page . '.js';

                wp_enqueue_script('wp-element', $this->includes_url . 'js/dist/element.min.js', [], null, true);

                if (file_exists($filePath)) {
                    echo '<script type="module" src="' . esc_url($filePathURL) . '"></script>';
                } else {
                    throw new Exception($page . ' page has not been created in react JSX.');
                }
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at load_pages_react');

            return $response;
        }
    }
}
