<?php

namespace JDecool\Bundle\SecurityRoleCheckerBundle\Security;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RoleChecker implements RoleCheckerInterface
{
    /** @var AuthorizationCheckerInterface */
    private $authorizationChecker;

    /** @var RoleHierarchyInterface */
    private $roleHierarchy;

    /**
     * Constructor
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param RoleHierarchyInterface        $roleHierarchy
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker, RoleHierarchyInterface $roleHierarchy)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->roleHierarchy        = $roleHierarchy;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role, UserInterface $user = null)
    {
        if (null === $user) {
            return $this->authorizationChecker->isGranted($role);
        }

        $roles = $this->roleHierarchy->getReachableRoles(array_map(function ($role) {
            if (is_string($role)) {
                return new Role($role);
            } elseif (!$role instanceof RoleInterface) {
                throw new \InvalidArgumentException(sprintf('$roles must be an array of strings, or RoleInterface instances, but got %s.', gettype($role)));
            }

            return $role;
        }, $user->getRoles()));

        return in_array(new Role($role), $roles);
    }
}
