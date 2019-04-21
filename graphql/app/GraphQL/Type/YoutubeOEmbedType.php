<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class YoutubeOEmbedType extends GraphQLType
{
    protected $attributes = [
        'name' => 'YoutubeOEmbedType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'author_name' => [ 'type' =>   Type::string()],
            'author_url' => [ 'type' =>    Type::string()],
            'width' => [ 'type' =>   Type::int()],
            'height' => [ 'type' =>      Type::int()],
            'html' => [ 'type' =>  Type::string()],
            'provider_name' => [ 'type' => Type::string()],
            'provider_url' => [ 'type' =>  Type::string()],
            'thumbnail_width' => [ 'type' =>     Type::int()],
            'thumbnail_height' => [ 'type' =>    Type::int()],
            'thumbnail_url' => [ 'type' => Type::string()],
            'title' => [ 'type' => Type::string()],
            'type' => [ 'type' =>  Type::string()],
            'version' => [ 'type' =>   Type::string()],
        ];
    }
}