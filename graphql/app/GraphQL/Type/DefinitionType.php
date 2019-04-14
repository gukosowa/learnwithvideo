<?php

namespace App\GraphQL\Type;

use App\Definition;

use App\GraphQL\Type\Scalar\Timestamp;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DefinitionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Definition',
        'description' => 'This Definition of the Words',
        'model'         => Definition::class,
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Definition ID',
            ],
            'word' => [
                'type' => Type::string(),
                'description' => 'Japanese word',
            ],
            'furigana' => [
                'type' => Type::string(),
                'description' => 'Japanese word written in furigana',
            ],
            'part_of_speech' => [
                'type' => Type::string(),
                'description' => 'Word type',
            ],
            'definition' => [
                'type' => Type::string(),
                'description' => 'The grade of the kanji. n = noun, v = verb, a = Adj, i = iAdj, in = interjection na = naAdj, c = conjunction, adv = adverb, pA = prenounAdjective, p = particle, su = suffix, pr = prefix, pp = preposition, mw = measure word,',
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'Image link holding representing image to the word',
            ],
            'ispeech_id' => [
                'type' => Type::int(),
                'description' => 'iSpeech ID from database',
            ],
            'jlpt' => [
                'type' => Type::int(),
                'description' => 'The japanese proficiency test grade',
            ],
            'tags' => [
                'type' => Type::string(),
                'description' => 'Tags or hints for the word',
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