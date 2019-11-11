<?php

namespace App\Repositories;

use App\User;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    /**
     * @param null $post_limit
     * @return mixed
     */
    public function getUsers($post_limit = null) // 6
    {
        $users = User::with('posts', 'posts.comments')
            ->actualPosts()
            ->get();

        if ($post_limit) {  // 6.1
            $users->map(function ($user) use ($post_limit) {
                $user->setRelation('posts', $user->posts->take($post_limit));
                return $user;
            });
        }
        return $users;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getComments(User $user) // 7
    {
        $comments = $user->comments()->with('post') // 7.2*
            ->withTrashed()->imagedPost()
            ->orderBy('created_at', 'desc')
            ->get();
        $comments->load('post.image', 'post.author');  // 7.2*

        return $comments;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getCommentsRaw(User $user) // 7
    {
        //
    }
}