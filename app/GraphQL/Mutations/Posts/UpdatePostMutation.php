<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Posts;

use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\Post;

class UpdatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updatePost',
        'description' => 'A mutation'
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
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required', 'exists:posts']
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string()),
                'rules' => function($args) {
                    return ['required', 'max:255', 'unique:posts,title,'.$args['id']];
                },
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
        $post = Post::find($args['id']);
        abort_if($post->user_id != auth()->id(), 403, 'NOT PERMISSION');
        $post->fill($args);
        $post->save();

        return $post;
    }
}
