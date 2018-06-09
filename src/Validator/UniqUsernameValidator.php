<?php
// src/OC/PlatformBundle/Validator/AntifloodValidator.php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UniqUsernameValidator extends ConstraintValidator
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null !== $this->manager->getRepository(User::class)->findOneBy(['username' => $value])) {
            $this->context->addViolation($constraint->message);
        }
    }
}
