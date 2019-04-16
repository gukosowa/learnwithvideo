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
            'id' => ['name' => 'id', 'type' => Type::int()],
            'word' => ['name' => 'word', 'type' => Type::string()],
            'furigana' => ['name' => 'furigana', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['id'])) {
            return Definition::where('id' , $args['id'])->get();
        }

        if (isset($args['word']) & isset($args['furigana'])) {
            return Definition::where('word', "like", "%" . $args['word'] . "%")
                                ->orWhere('furigana', "like", "%" . $args['furigana'] . "%")->get();
        }

        if (isset($args['word'])) {
            return Definition::where('word', "like", "%" . $args['word'] . "%")->get();
        }

        if (isset($args['furigana'])) {
            return Definition::where('word', "like", "%" . $args['furigana'] . "%")->get();
        }

        return Definition::all();
    }
}