<?php
namespace App\Tests\Security;

use PHPUnit\Framework\TestCase;
use App\Validator\IframeValidator;
use App\Validator\Iframe;

class IframeValidatorTest extends TestCase
{
    public function testInvalidValue()
    {
        $validator = new IframeValidator();
        $constraint = new Iframe();
        $context = $this->createMock('Symfony\Component\Validator\Context\ExecutionContext');

        $context->expects($this->once())->method('addViolation')->with($this->equalTo('Format not valid, only iframe blocs are accepted'));

        $validator->initialize($context);

        $validator->validate('<iframe width="560" height="315" sr="https://www.youtube.com/embed/CA5bURVJ5zk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>', $constraint);
    }

    public function testValidValue()
    {
        $validator = new IframeValidator();
        $constraint = new Iframe();
        $context = $this->createMock('Symfony\Component\Validator\Context\ExecutionContext');

        $context->expects($this->exactly(0))->method('addViolation')->with($this->equalTo('Format not valid, only iframe blocs are accepted'));

        $validator->initialize($context);

        $validator->validate('<iframe width="560" height="315" src="https://www.youtube.com/embed/CA5bURVJ5zk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>', $constraint);
    }
}
