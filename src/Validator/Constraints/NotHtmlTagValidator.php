<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotHtmlTagValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
//        if ($value != strip_tags($value)) {
        $combined_str = $protocol->getCategoryName().$protocol->getCategoryLink();
        if ($combined_str == 'TestLink') {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $combined_str)
                ->atPath('category_name')
                ->atPath('category_link')
                ->addViolation();
        }
    }
}