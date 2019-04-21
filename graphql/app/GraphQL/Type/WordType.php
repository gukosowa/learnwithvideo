<?php

namespace App\GraphQL\Type;

use App\Word;

use App\GraphQL\Type\Scalar\Timestamp;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class WordType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Word',
        'description' => 'This Word Type represents every possible word of an dialogue',
        'model'         => Word::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Word ID',
            ],
            'definition_id' => [
                'type' => Type::int(),
                'description' => 'The corresponding definition id to this word',
            ],
            'definition' => [
                'type' => GraphQL::type('definitionType'),
                'description' => 'The corresponding definition object to this word',
            ],
            'custom_definition' => [
                'type' => Type::string(),
                'description' => 'If something is different to the main definition, it comes here',
            ],
            'custom_word' => [
                'type' => Type::string(),
                'description' => 'For example another form or dialect',
            ],
            'custom_furigana' => [
                'type' => Type::string(),
                'description' => 'The furigana of the custom word',
            ],
            'ispeech_id' => [
                'type' => Type::int(),
                'description' => 'iSpeech ID from database',
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