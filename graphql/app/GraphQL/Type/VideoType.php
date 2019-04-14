<?php

namespace App\GraphQL\Type;

use App\Video;

use App\GraphQL\Type\Scalar\Timestamp;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class VideoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Video',
        'description' => 'A type',
        'model'         => Video::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Video ID',
            ],
            'video_link' => [
                'type' => Type::string(),
                'description' => 'The link to the video. Depending on video_plattform',
            ],
            'video_plattform' => [
                'type' => Type::string(),
                'description' => 'Plattform who is hosting the video. e.g Youtube',
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The video title',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Short description about the video',
            ],
            'dialogues' => [
                'type' => Type::listOf(GraphQL::type('dialogue')),
                'description' => 'List of dialogues associated with this video',
            ],
            'views' => [
                'type' => Type::int(),
                'description' => 'How many views this video already has',
            ],
            'difficulty' => [
                'type' => Type::int(),
                'description' => 'Difficulty from 1 to 10, easy to hard',
            ],
            'created_at' => [
                'type' => Timestamp::type(),
                'description' => 'Datetime when the videolink was created',
            ],
            'updated_at' => [
                'type' => Timestamp::type(),
                'description' => 'Datetime when the videolink was changed',
            ],
        ];
    }
}