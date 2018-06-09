<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqEmail extends Constraint
{
    public $message = 'This email adress is already taken';

    public function validateBy()
    {
        return 'nv_uniq_email';
    }
}
