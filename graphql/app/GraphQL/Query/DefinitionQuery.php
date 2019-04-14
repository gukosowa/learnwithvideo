<?php

namespace App\GraphQL\Query;

use App\Definition;
use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class DefinitionQuery extends Query
{
    protected $attributes = [
        'name' => 'DefinitionQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('definition'));
    }

    public function args()
    {
        return [

        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['id'])) {
            return Definition::where('id' , $args['id'])->get();
        }

        return Definition::all();
    }
}