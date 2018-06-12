<?php
namespace App\DataFixtures\ORM;

use Faker\Provider\Base as BaseProvider;
use Faker\Generator;

class CommentProvider extends BaseProvider
{
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    public function comment()
    {
        $key = array_rand($this->comments);
        return $this->comments[$key];
    }

    private $comments = [
        "This one is really hard",
        "So easy...",
        "First !",
        "I don't think this is a real trick",
        "Je comprend rien à votre anglais moi..",
        "There is no spoon",
        "What the hell is that ?",
        "It's been two years and I still fail with this trick, any tip ?",
        "You noob",
        "What do you think of it",
        "Should I try this as a begginer ?",
        "This one is tricky, be carefull",
        "I don't understand this trick",
        "Can someone help me in taking derivatives of inverse trigonometric functions ?",
        "Anyone know a good lasagna recipe ?"
    ];
}
