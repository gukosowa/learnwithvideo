<?php

namespace App\GraphQL\Type\Scalar;

use Carbon\Carbon;
use GraphQL\Type\Definition\IntType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Utils\Utils;

class Timestamp extends IntType
{
    private static $_instance = null;
    const MIN_INT = 0;
    /**
     * @var string
     */
    public $name = "Timestamp";

    /**
     * @var string
     */
    public $description = "A UNIX timestamp represented as an integer";

    protected function __clone() {}

    static public function type() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    protected function __construct()
    {
        Utils::invariant($this->name, 'Type must be named.');
    }

    public function serialize($value)
    {
        return $this->toTimestamp($value);
    }

    public function parseValue($value)
    {
        return $this->toTimestamp($value);
    }

    protected function toTimestamp($value)
    {
        if (is_int($value)) {
            return $value;
        }
        return (new Carbon($value))->getTimestamp();
    }
}