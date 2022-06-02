<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Posts;

use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\Post;

class CreatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createPost',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'max:255', 'unique:posts,title']
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'max:3000']
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        $args['user_id'] = auth()->id();

        $post = new Post();
        $post->fill($args);
        $post->save();

        return $post;
    }
}
