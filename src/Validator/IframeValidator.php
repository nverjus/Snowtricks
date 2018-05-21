<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IframeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('#^<iframe .* src=.*><\/iframe>$#', $value)) {
            if (!empty($value)) {
                $this->context->addViolation($constraint->message);
            }
        }
    }
}
