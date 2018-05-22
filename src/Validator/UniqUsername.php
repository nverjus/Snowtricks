<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqUsername extends Constraint
{
    public $message = 'This username is already taken';

    public function validateBy()
    {
        return 'nv_uniq_username';
    }
}
