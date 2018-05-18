<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IframeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('#^<iframe .* src=.*><\/iframe>$#', $value)) {
            // C'est cette ligne qui déclenche l'erreur pour le formulaire, avec en argument le message de la contrainte
            $this->context->addViolation($constraint->message);
        }
    }
}
