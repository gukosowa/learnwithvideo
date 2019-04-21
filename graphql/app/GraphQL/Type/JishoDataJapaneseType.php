<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JishoDataJapaneseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JishoDataJapaneseType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'reading' => [
                'type' => Type::string(),
                'description' => '',
            ],
            'word' => [
                'type' => Type::string(),
                'description' => '',
            ]
        ];
    }
}