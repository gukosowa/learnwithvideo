<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class JishoDataAttributionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'JishoDataAttributionType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'dbpedia' => [
                'type' => Type::boolean(),
                'description' => '',
            ],
            'jmdict' => [
                'type' => Type::boolean(),
                'description' => '',
            ],
            'jmnedict' => [
                'type' => Type::boolean(),
                'description' => '',
            ],
        ];
    }
}