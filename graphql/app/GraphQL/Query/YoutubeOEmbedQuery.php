<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use Symfony\Component\VarDumper\VarDumper;
use PhpParser\JsonDecoder;

class YoutubeOEmbedQuery extends Query
{
    protected $attributes = [
        'name' => 'YoutubeOEmbedQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return GraphQL::type('youtubeoembedtype');
    }

    public function args()
    {
        return [
            'url' => ['name' => 'url', 'type' => Type::string()] ,
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        if (isset($args['url'])) {
            $client = new Client();
            $res = $client->request('GET', 'https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=' . urlencode($args['url']) . '&format=json');
            return json_decode($res->getBody()->getContents());
        }

        return [];
    }
}