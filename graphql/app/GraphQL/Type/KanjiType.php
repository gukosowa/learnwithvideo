<?php

namespace App\GraphQL\Type;

use App\Kanji;

use App\GraphQL\Type\Scalar\Timestamp;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class KanjiType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Kanji',
        'description' => 'This Kanji Type represents all possible Kanjis',
        'model'         => Kanji::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Kanji ID',
            ],
            'kanji' => [
                'type' => Type::string(),
                'description' => 'The actual kanji',
            ],
            'strokes' => [
                'type' => Type::int(),
                'description' => 'How many strokes the kanji has',
            ],
            'readings' => [
                'type' => Type::string(),
                'description' => 'The readings split into Katakana for ON and Hiragana for KUN reading',
            ],
            'grade' => [
                'type' => Type::int(),
                'description' => 'The grade of the kanji',
            ],
            'jlpt' => [
                'type' => Type::int(),
                'description' => 'The japanese proficiency test grade',
            ],
            'freq' => [
                'type' => Type::int(),
                'description' => 'How frequently the kanji is used',
            ],
            'translation_on' => [
                'type' => Type::string(),
                'description' => 'The meaning from ON reading',
            ],
            'translation_kun' => [
                'type' => Type::string(),
                'description' => 'The meaning from KUN reading',
            ],
            'created_at' => [
                'type' => Timestamp::type(),
                'description' => 'Datetime when the this was created',
            ],
            'updated_at' => [
                'type' => Timestamp::type(),
                'description' => 'Datetime when the this was changed',
            ],
        ];
    }
}