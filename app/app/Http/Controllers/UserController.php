<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\QueryBuilder\CommentBuildedResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    protected $repository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function users(Request $request)  // 6
    {
        return UserResource::collection($this->repository->getUsers((int)$request->get('post_limit')));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function comments(Request $request, User $user) // 7 by Eloquent
    {
        return CommentResource::collection($this->repository->getComments($user));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function commentsByBuilder(Request $request, User $user) // 7 by QueryBuilder
    {
        return CommentBuildedResource::collection($this->repository->getCommentsByQueryBuilder($user));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function commentsByRawQuery(Request $request, User $user) // 7 by Raw SQL
    {
        return CommentBuildedResource::collection($this->repository->getCommentsRaw($user));
    }
}
