<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JishoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JishoType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'data' => [
                'type' => Type::listOf(GraphQL::type('jishoDataType')),
                'description' => 'Data',
            ],
            'meta' => [
                'type' => Type::int(),
                'description' => 'Meta',
            ]
        ];
    }
}