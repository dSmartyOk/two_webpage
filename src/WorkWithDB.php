<?php


namespace App;

class WorkWithDB
{
    public function paginationPosts(array $posts, $page, $countPostsView): array
    {
        $result = [];
        foreach($posts as $key => $post) {
            if($key >= ($page - 1)*$countPostsView && $key < $page * $countPostsView)
            $result[] = $post;
        }
        return $result;
    }
}