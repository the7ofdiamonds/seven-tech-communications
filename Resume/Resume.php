<?php

namespace SEVEN_TECH\Communications\Resume;

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
        $post = get_page_by_path($slug, OBJECT, $postType);

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
