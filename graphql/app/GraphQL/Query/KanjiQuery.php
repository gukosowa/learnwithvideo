<?php

namespace App\GraphQL\Query;

use App\Kanji;
use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class KanjiQuery extends Query
{
    protected $attributes = [
        'name' => 'KanjiQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('kanji'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['id'])) {
            return Kanji::where('id' , $args['id'])->get();
        }

        return Kanji::all();
    }
}