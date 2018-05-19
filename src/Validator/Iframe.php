<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Iframe extends Constraint
{
    public $message = "Format not valid, only iframe blocs are accepted";
}
