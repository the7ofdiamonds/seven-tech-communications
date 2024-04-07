<?php

namespace SEVEN_TECH\Communications\Templates;

class TemplatesCustom
{
    private $pluginDir;

    public function __construct()
    {
        $this->pluginDir = SEVEN_TECH_COMMUNICATIONS;
    }

    function get_resume_page_template($template_include)
    {
        $custom_template = $this->pluginDir . "Pages/page-founder-resume.php";

        return $custom_template;
    }
}
