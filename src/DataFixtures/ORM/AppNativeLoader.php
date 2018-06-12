<?php

namespace App\DataFixtures\ORM;

use Nelmio\Alice\Loader\NativeLoader;
use Faker\Generator as FakerGenerator;

class AppNativeLoader extends NativeLoader
{
    protected function createFakerGenerator(): FakerGenerator
    {
        $generator = parent::createFakerGenerator();
        $generator->addProvider(new CommentProvider($generator));
        $generator->addProvider(new TrickPhotoProvider($generator));
        $generator->addProvider(new VideoProvider($generator));
        return $generator;
    }
}
