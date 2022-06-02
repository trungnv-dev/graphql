<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use App\Models\User;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A type',
        'model' => User::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a particular user',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email of user',
            ],
        ];
    }
}
