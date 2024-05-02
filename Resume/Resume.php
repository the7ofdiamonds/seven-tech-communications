<?php

namespace SEVEN_TECH\Communications\Resume;

use WP_Query;

use SEVEN_TECH\Communications\User\User;
use SEVEN_TECH\Communications\Media\Media;

class Resume
{
    private $user;
    private $media;

    public function __construct()
    {
        $this->user = new User;
        $this->media = new Media;
    }

    function getResume($id)
    {
        $path = 'resume';
        $file = "Resume_{$id}.pdf";

        return $this->media->getURL($path, $file);
    }

    function getResumeInfo($postType, $slug)
    {
        $post_type = str_replace('-', '_', $postType);
        $args = [
            'post_type' => $post_type,
            'post_name' => $slug
        ];

        $query = new WP_Query($args);

        $post = $query->posts[0];

        if (empty($post)) {
            return '';
        }

        $id = $post->post_author;

        $author = $this->user->getUser($id);

        if (!is_array($author)) {
            return '';
        }

        $resumeInfo['full_name'] = $author['full_name'];
        $resumeInfo['resume'] = $this->getResume($id);

        return $resumeInfo;
    }
}
