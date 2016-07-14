<?php

namespace JDecool\Bundle\SecurityRoleCheckerBundle\Twig\Extension;

use JDecool\Bundle\SecurityRoleCheckerBundle\Security\RoleCheckerInterface;

class SecurityExtension extends \Twig_Extension
{
    /** @var RoleCheckerInterface */
    private $roleChecker;

    /**
     * Constructor
     *
     * @param RoleCheckerInterface $roleChecker
     */
    public function __construct(RoleCheckerInterface $roleChecker)
    {
        $this->roleChecker = $roleChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('has_role', [$this->roleChecker, 'hasRole']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'security.role_checker';
    }
}
