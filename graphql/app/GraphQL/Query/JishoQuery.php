<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class JishoQuery extends Query
{
    protected $attributes = [
        'name' => 'Jisho',
        'description' => 'A query'
    ];

    public function type()
    {
        return GraphQL::type('jishoType');
    }

    public function args()
    {
        return [
            'keyword' => ['name' => 'keyword', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if (isset($args['keyword'])) {
            $client = new Client();
            $res = $client->request('GET', 'https://jisho.org/api/v1/search/words?keyword=' . urlencode($args['keyword']));
            $response = json_decode($res->getBody()->getContents());
            $data = [];
            $words = [];
            foreach($response->data as $word) {
                $word->jlpt = str_replace("jlpt-n", "", $word->jlpt);
                $words[] = $word;
            }
            $data["data"] = $words;
            $data["meta"] = (int)$response->meta->status;
            return $data;
        }

        return [];
    }
}