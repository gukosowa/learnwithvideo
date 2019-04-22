<?php

namespace App\GraphQL\Query;

use App\Dialogue;
use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class DialogueQuery extends Query
{
    protected $attributes = [
        'name' => 'DialogueQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('dialogue'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'videoId' => ['name' => 'videoId', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        // $dialogue = Dialogue::select($select)->with($with);

        // return $dialogue->get();

        if (isset($args['id'])) {
            return Dialogue::where('id' , $args['id'])->get();
        }

        if (isset($args['videoId'])) {
            return Dialogue::where('video_id' , $args['videoId'])->get();
        }

        // if (isset($args['video_id'])) {
        //     return Dialogue::where('video_id', $args['video_id'])->get();
        // }

        // if (isset($args['video'])) {
        //     return Video::where('id', $args['video_id'])->get();
        // }

        return Dialogue::all();
    }
}