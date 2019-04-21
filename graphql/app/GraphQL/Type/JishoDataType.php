<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JishoDataType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JishoDataType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'attribution' => [
                'type' => GraphQL::type('jishoDataAttributionType'),
                'description' => '',
            ],
            'is_common' => [
                'type' => Type::boolean(),
                'description' => '',
            ],
            'japanese' => [
                'type' => Type::listOf(GraphQL::type('jishoDataJapaneseType')),
                'description' => '',
            ],
            'jlpt' => [
                'type' => Type::listOf(Type::int()),
                'description' => '',
            ],
            'senses' => [
                'type' => Type::listOf(GraphQL::type('jishoDataSensesType')),
                'description' => '',
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => '',
            ],
            'tags' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ]
        ];
    }
}