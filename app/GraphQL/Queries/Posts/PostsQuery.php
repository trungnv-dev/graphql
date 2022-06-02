<?php

namespace App\graphql\Queries\Posts;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use App\GraphQL\Middleware\ResolvePage;
use App\Models\Post;

class PostsQuery extends Query
{
    protected $middleware = [
        ResolvePage::class
    ];

    protected $attributes = [
        'name' => 'posts',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Post');
        // return Type::listOf(GraphQL::type('Post'));
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, SelectFields $fields)
    {
        // return Post::select($fields->getSelect())->with($fields->getRelations())->get();

        return Post::with($fields->getRelations())
            ->select($fields->getSelect())
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
