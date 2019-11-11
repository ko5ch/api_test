<?php

namespace App\Repositories;

use App\User;
use App\Post;
use App\Comment;
use Illuminate\Support\Collection;
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
    public function getComments(User $user) // 7 by Eloquent
    {
        $comments = $user->comments()->with('post')->withTrashed()->imagedPost() // 7.2*
            ->orderBy('created_at', 'desc')
            ->get();
        $comments->load('post.image', 'post.author');  // 7.2*

        return $comments;
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getCommentsByQueryBuilder(User $user) // 7 by QueryBuilder
    {
        $comments = DB::table('comments')
            ->where('comments.commentator_id', '=', $user->id)
            ->orderBy('comments.created_at', 'desc')
            ->get(['comments.id','content', 'post_id', 'created_at']);

        $posts_ids = $comments->pluck('post_id');

        $posts = DB::table('posts')
            ->whereIn('posts.id', $posts_ids)
            ->join('images', 'posts.image_id', '=', 'images.id')
            ->whereNotNull('posts.image_id')
            ->get();
        $post_authors_ids = $posts->pluck('author_id');

        $authors = DB::table('users')
            ->whereIn('users.id', $post_authors_ids)
            ->get(['id', 'name', 'email', 'active', 'created_at']);

        $comments = $comments->map(function($comment) use ($posts, $authors) {
            $post = $posts->each(function($post) use ($comment, $authors) {
                $author = $authors->each(function($author) use ($post) {

                    if ($post->author_id == $author->id) {
                        return $author;
                    }
                });
                $post->author = $author;

                if ($post->id  == $comment->post_id) {
                    return $post;
                }
            });
            $comment->post = $post;

            return $comment;
        });

        return $comments;
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getCommentsRaw(User $user) // 7 Raw
    {
        $comments = collect(DB::select( DB::raw(
            "SELECT comments.id, comments.content FROM comments, posts 
                          WHERE comments.post_id = posts.id  
                          AND comments.commentator_id = :user_id
                          AND posts.image_id IS NOT NULL 
                          ORDER BY comments.created_at DESC "),
            [ 'user_id' => $user->id, ]));

        return $comments;
    }

}