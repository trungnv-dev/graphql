<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Posts;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\Post;

class PostQuery extends Query
{
    protected $attributes = [
        'name' => 'post',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required', 'exists:posts']
            ],
        ];
    }

    public function resolve($root, array $args, $context, SelectFields $fields)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Post::select($select)->with($with)->where('id', $args['id'])->first();
    }
}
