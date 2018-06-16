<?php
namespace App\DataFixtures\ORM;

use Faker\Provider\Base as BaseProvider;
use Faker\Generator;

class TrickPhotoProvider extends BaseProvider
{
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    public function trickPhoto()
    {
        $key = array_rand($this->photos);
        return $this->photos[$key];
    }

    private $photos = [
        "grab1.jpg",
        "grab2.jpg",
        "flip1.jpg",
        "flip2.jpg",
        "flip3.jpg",
    ];
}
