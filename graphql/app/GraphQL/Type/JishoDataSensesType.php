<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JishoDataSensesType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JishoDataSensesType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'antonyms' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'english_definitions' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'info' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'links' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'parts_of_speech' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'restrictions' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'see_also' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'source' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ],
            'tags' => [
                'type' => Type::listOf(Type::string()),
                'description' => '',
            ]
        ];
    }
}