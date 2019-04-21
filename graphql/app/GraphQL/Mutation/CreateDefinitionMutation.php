<?php

namespace App\GraphQL\Mutation;

use App\Definition;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateDefinitionMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createDefinition',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('definitionType');
    }

    public function args()
    {
        return [
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
            ]
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $data= [];
        if (isset($args['word'])) $data['word'] = urldecode ($args['word']);
        if (isset($args['furigana'])) $data['furigana'] = urldecode ($args['furigana']);
        if (isset($args['part_of_speech'])) $data['part_of_speech'] = urldecode ($args['part_of_speech']);
        if (isset($args['definition'])) $data['definition'] = urldecode ($args['definition']);
        if (isset($args['image'])) $data['image'] = urldecode ($args['image']);
        if (isset($args['ispeech_id'])) $data['ispeech_id'] = urldecode ($args['ispeech_id']);
        if (isset($args['jlpt'])) $data['jlpt'] = urldecode ($args['jlpt']);
        if (isset($args['tags'])) $data['tags'] = urldecode ($args['tags']);

        $definition = Definition::create($data);

        $definition->save();

        return $definition;
    }
}