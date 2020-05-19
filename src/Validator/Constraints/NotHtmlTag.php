<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotHtmlTag extends Constraint
{
    public $message = 'Input "%string%" is invalid, possible security risk';
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}