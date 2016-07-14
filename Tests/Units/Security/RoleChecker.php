<?php

namespace JDecool\Bundle\SecurityRoleCheckerBundle\Tests\Units\Security;

use atoum;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

class RoleChecker extends atoum
{
    /**
     * @dataProvider getHasRoleTests
     */
    public function testHasRole($role, $user, $expected)
    {
        $this
            ->given(
                $authorizationChecker = $this->getAuthorizationChecker(),
                $roleHierarchy = new RoleHierarchy(['ROLE_FOO' => ['ROLE_FOOBAR']])
            )
            ->if($this->newTestedInstance($authorizationChecker, $roleHierarchy))
            ->then
                ->boolean($this->testedInstance->hasRole($role, $user))
                    ->isIdenticalTo($expected)
        ;
    }

    public function getHasRoleTests()
    {
        return [
            ['', $this->getUser(array()), false],
            ['ROLE_FOO', $this->getUser(array()), false],
            ['ROLE_FOO', $this->getUser(array('ROLE_FOOBAR')), false],
            ['ROLE_FOO', $this->getUser(array('ROLE_FOO')), true],
            ['ROLE_FOOBAR', $this->getUser(array('ROLE_FOO')), true],

            ['ROLE_FOO', null, true],
            ['ROLE_BAR', null, false],
        ];
    }

    private function getAuthorizationChecker()
    {
        $authorizationChecker = new \mock\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
        $authorizationChecker->getMockController()->isGranted = function($attributes, $object) {
            return 'ROLE_FOO' === $attributes;
        };

        return $authorizationChecker;
    }

    private function getUser(array $roles)
    {
        $user = new \mock\Symfony\Component\Security\Core\User\UserInterface;
        $user->getMockController()->getRoles = function() use ($roles) {
            return $roles;
        };

        return $user;
    }
}
