<?php

namespace JDecool\Bundle\SecurityRoleCheckerBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface RoleCheckerInterface
{
    /**
     * Checks if the given user (or current user if not specified) has the role given in parameter.
     *
     * @param string             $role Role to check
     * @param UserInterface|null $user A user instance
     *
     * @return bool
     */
    public function hasRole($role, UserInterface $user = null);
}
