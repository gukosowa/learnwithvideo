<?php

namespace App\GraphQL\Type;

use App\Dialogue;

use App\GraphQL\Type\Scalar\Timestamp;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DialogueType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Dialogue',
        'description'   => 'A type',
        'model'         => Dialogue::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Dialogue ID',
            ],
            'video_id' => [
                'type' => Type::int(),
                'description' => 'The associated video id',
            ],
            'video' => [
                'type' => GraphQL::type('video'),
                'description' => 'The associated video object',
            ],
            'words' => [
                'type' => Type::listOf(GraphQL::type('word')),
                'description' => 'The corresponding definition id to this word',
            ],
            'text' => [
                'type' => Type::string(),
                'description' => 'The actual dialogue text',
            ],
            'translation' => [
                'type' => Type::string(),
                'description' => 'Translation of dialogue',
            ],
            'time' => [
                'type' => Type::float(),
                'description' => 'At which time does this dialogue start',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Datetime when the videolink was created',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Datetime when the videolink was changed',
            ],
        ];
    }
}