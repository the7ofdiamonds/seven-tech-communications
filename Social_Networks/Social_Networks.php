<?php

namespace SEVEN_TECH\Communications\Social_Networks;

class Social_Networks
{

    function getSocialNetworks($post_id)
    {
        $github_link = get_post_meta($post_id, 'github_link', true);
        $linkedin_link = get_post_meta($post_id, 'linkedin_link', true);
        $facebook_link = get_post_meta($post_id, 'facebook_link', true);
        $instagram_link = get_post_meta($post_id, 'instagram_link', true);
        $x_link = get_post_meta($post_id, 'x_link', true);
        $hacker_rank_link = get_post_meta($post_id, 'hacker_rank_link', true);

        $social_networks = [
            [
                'name' => 'GitHub',
                'icon' => 'github',
                'link' => $github_link
            ],
            [
                'name' => 'LinkedIn',
                'icon' => 'linkedin',
                'link' => $linkedin_link
            ],
            [
                'name' => 'Facebook',
                'icon' => 'facebook',
                'link' => $facebook_link
            ],
            [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'link' => $instagram_link
            ],
            [
                'name' => 'X',
                'icon' => 'x-twitter',
                'link' => $x_link
            ],
            [
                'name' => 'Hacker Rank',
                'icon' => 'hackerrank',
                'link' => $hacker_rank_link
            ],
        ];

        return $social_networks;
    }
}
