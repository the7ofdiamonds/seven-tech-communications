<?php

namespace SEVEN_TECH\Communications\CSS;

use Exception;

use SEVEN_TECH\Communications\CSS\Customizer\BorderRadius;
use SEVEN_TECH\Communications\CSS\Customizer\Color;
use SEVEN_TECH\Communications\CSS\Customizer\Shadow;

class CSS
{
    private $handle_prefix;
    private $dir;
    private $dirURL;
    private $cssFolderPath;
    private $cssFolderPathURL;

    public function __construct()
    {
        $this->handle_prefix = 'seven_tech_communications_';
        $this->dir = SEVEN_TECH_COMMUNICATIONS;
        $this->dirURL = SEVEN_TECH_COMMUNICATIONS_URL;

        $this->cssFolderPath = $this->dir . 'dist/css/';
        $this->cssFolderPathURL = $this->dirURL . 'dist/css/';
    }

    function load_customization_css()
    {
        (new BorderRadius)->load_css();
        (new Color)->load_css();
        (new Shadow)->load_css();
    }

    function load_index_css()
    {
        try {
            $filename = 'index.css';
            $indexPath = $this->cssFolderPath . $filename;
            $indexPathURL = $this->cssFolderPathURL . $filename;

            if (file_exists($indexPath)) {
                wp_register_style($this->handle_prefix . $filename,  $indexPathURL, array(), false, 'all');
                wp_enqueue_style($this->handle_prefix . $filename);
            } else {
                throw new Exception('CSS file ' . $filename . ' is missing at :' . $this->cssFolderPath, 404);
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at load_index_css');

            return $response;
        }
    }

    function load_front_page_css($section)
    {
        try {
            $this->load_customization_css();
            $this->load_index_css();

            if (!empty($section)) {

                $filename = $section . '.css';
                $cssFilePath = $this->cssFolderPath . $filename;
                $cssFilePathURL = $this->cssFolderPathURL . $filename;

                if ($cssFilePath) {
                    wp_register_style($this->handle_prefix . $filename,  $cssFilePathURL, array(), false, 'all');
                    wp_enqueue_style($this->handle_prefix . $filename);
                } else {
                    throw new Exception('CSS file ' . $filename . ' is missing at :' . $this->cssFolderPath, 404);
                }
            }

            $frontPageFile = 'Front-Page.css';
            $frontPageFilePath = $this->cssFolderPath . $frontPageFile;
            $frontPageFilePathURL = $this->cssFolderPathURL . $frontPageFile;

            if ($frontPageFilePath) {
                wp_register_style($this->handle_prefix . $frontPageFile,  $frontPageFilePathURL, array(), false, 'all');
                wp_enqueue_style($this->handle_prefix . $frontPageFile);
            } else {
                throw new Exception('CSS file ' . $filename . ' is missing at :' . $this->cssFolderPath, 404);
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at load_front_page_css');

            return $response;
        }
    }

    function load_pages_css($page)
    {
        try {
            if (!empty($page)) {
                $this->load_customization_css();
                $this->load_index_css();

                $filename = $page . '.css';
                $cssFilePath = $this->cssFolderPath . $filename;
                $cssFilePathURL = $this->cssFolderPathURL . $filename;

                if (file_exists($cssFilePath)) {
                    wp_register_style($this->handle_prefix . 'css',  $cssFilePathURL, array(), false, 'all');
                    wp_enqueue_style($this->handle_prefix . 'css');
                } else {
                    throw new Exception('CSS file ' . $filename . ' is missing at :' . $this->cssFolderPath, 404);
                }
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at load_pages_css');

            return $response;
        }
    }

    function load_social_bar_css()
    {
        try {
            $filename = 'social-bar.css';
            $cssFilePath = $this->cssFolderPath . $filename;
            $cssFilePathURL = $this->cssFolderPathURL . $filename;

            if (file_exists($cssFilePath)) {
                wp_register_style($this->handle_prefix . 'social_bar_css',  $cssFilePathURL, array(), false, 'all');
                wp_enqueue_style($this->handle_prefix . 'social_bar_css');
            } else {
                throw new Exception('CSS file ' . $filename . ' is missing at :' . $this->cssFolderPath, 404);
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at load_social_bar_css');

            return $response;
        }
    }
}
