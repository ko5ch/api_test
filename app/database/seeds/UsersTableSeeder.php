<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected const FAKE_USERS_COUNT = 10;

    protected $list = [
        [
            'email'     => 'user@site.com',
            'active'    => true,
        ],
    ];

    public function __construct()
    {
        //
    }

    public function run()
    {
        Model::unguard();

        $start = now();
        $this->command->info('Users Seeder Started...(with Posts, Comments)');
        $this->command->info('Time completed:   ' .$start->diffForHumans(null, true));

        /*
        * SEED CUSTOM USERS
        */
        foreach ($this->list as $item) {
            $item = collect($item);
            /**
             * @var User $user
             */
            $user = factory(User::class)->create($item->only([
                'email', 'active'
            ])->toArray());
            $this->addRelations($user);
            factory(User::class, self::FAKE_USERS_COUNT)->create()->each(function (User $user) {
                $this->addRelations($user);
        });

        }
    }

    /**
     * @param User $user
     */
    private function addRelations(User $user)
    {
        $this->createPost($user, rand(1, 3));
        $this->createComment($user, rand(1,3));
    }

    /**
     * @param User $user
     * @param $count
     */
    private function createPost(User $user, $count)
    {
        factory(Post::class, $count)->create([
            'author_id' => $user->id,
        ]);
    }

    /**
     * @param User $user
     * @param $count
     */
    private function createComment(User $user, $count)
    {
        factory(Comment::class, $count)->create([
            'commentator_id'    => $user->id,
            'post_id'           => Post::inRandomOrder()->first()->id,
        ]);
    }

}