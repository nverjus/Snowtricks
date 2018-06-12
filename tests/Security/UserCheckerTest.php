<?php
namespace App\Tests\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\LockedException;
use App\Security\UserChecker;
use PHPUnit\Framework\TestCase;

class UserCheckerTest extends TestCase
{
    public function testUserIsNotActive()
    {
        $user = new User();
        $user->setIsActive(false);

        $checker = new UserChecker();
        $this->expectException(LockedException::class);
        $checker->checkPreAuth($user);
    }
}
