<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Posts;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeletePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deletePost',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required', 'exists:posts']
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        $post = Post::find($args['id']);
        abort_if($post->user_id != auth()->id(), 403, 'NOT PERMISSION');

        return $post->delete();
    }
}
