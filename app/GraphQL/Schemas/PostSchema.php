<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class PostSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                \App\GraphQL\Queries\Posts\PostQuery::class,
                \App\GraphQL\Queries\Posts\PostsQuery::class,
            ],

            'mutation' => [
                \App\GraphQL\Mutations\Posts\CreatePostMutation::class,
                \App\GraphQL\Mutations\Posts\UpdatePostMutation::class,
                \App\GraphQL\Mutations\Posts\DeletePostMutation::class,
            ],

            'middleware' => ['auth:sanctum'],
        ];
    }
}
