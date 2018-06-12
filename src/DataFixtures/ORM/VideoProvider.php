<?php
namespace App\DataFixtures\ORM;

use Faker\Provider\Base as BaseProvider;
use Faker\Generator;

class VideoProvider extends BaseProvider
{
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    public function video()
    {
        $key = array_rand($this->videos);
        return $this->videos[$key];
    }

    private $videos = ['<iframe width="560" height="315" src="https://www.youtube.com/embed/CA5bURVJ5zk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>', '<iframe width="560" height="315" src="https://www.youtube.com/embed/UNItNopAeDU" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'];
}
