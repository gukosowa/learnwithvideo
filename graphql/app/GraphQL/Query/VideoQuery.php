<?php

namespace App\GraphQL\Query;

use App\Video;
use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class VideoQuery extends Query
{
    protected $attributes = [
        'name' => 'Videos',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('video'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            // 'video_link' => ['name' => 'email', 'type' => Type::string()] ,
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['id'])) {
            return Video::where('id' , $args['id'])->get();
        }

        // if (isset($args['video_link'])) {
        //     return Video::where('video_link', $args['video_link'])->get();
        // }

        return Video::all();
    }
}