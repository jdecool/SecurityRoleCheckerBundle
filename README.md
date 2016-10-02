# Symfony security role checker

[![Build Status](https://travis-ci.org/jdecool/SecurityRoleCheckerBundle.svg?branch=master)](https://travis-ci.org/jdecool/SecurityRoleCheckerBundle)
[![Build status](https://ci.appveyor.com/api/projects/status/github/jdecool/securityrolecheckerbundle?svg=true)](https://ci.appveyor.com/project/jdecool/securityrolecheckerbundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jdecool/SecurityRoleCheckerBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jdecool/SecurityRoleCheckerBundle/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/jdecool/security-role-checker-bundle/v/stable.png)](https://packagist.org/packages/jdecool/security-role-checker-bundle)


This bundle provides Symfony services for checking user security roles.

## Compatibility

This bundle is tested with Symfony 2.7+, but it should be compatible with Symfony 2.3+

### Warning

The RoleChecker service doesn't emulate an user authentication. It mean that if 
the authentication process modify user rights, the service can detect roles 
updates.

## Documentation

### Install it

Install extension using [composer](https://getcomposer.org):

```json
{
    "require": {
        "jdecool/security-role-checker-bundle": "~1.0"
    }
}
```

Enable the extension in your application `AppKernel`:

```php
<?php

public function registerBundles()
{
    $bundles = [
        // ...
        new JDecool\Bundle\SecurityRoleCheckerBundle\JDecoolSecurityRoleCheckerBundle(),
    ];

    // ...

    return $bundles;
}
```

### Use it

You can check role by accessing `jdecool.security.role_checker` service :

```php
class MyController
{
    public function myAction()
    {
        $roleChecker = $this->get('jdecool.security.role_checker');
        
        var_dump($role->hasRole('ROLE_USER')); // checking role for current user
        
        $userWithRole = $this->getDoctrine()->getRepository(/* ... */)->find(1);
        var_dump($role->hasRole('ROLE_USER', $userWithRole)); // true
        
        $userWithoutRole = $this->getDoctrine()->getRepository(/* ... */)->find(2);
        var_dump($role->hasRole('ROLE_USER', $userWithoutRole)); // false
        
        // ... 
    }
}
```

You can also check role in a Twig template (even if it's not a best practice) :

```twig
{{ has_role('ROLE_USER') ]} # Check role for current user
{{ has_role('ROLE_USER', other_user) ]}
```

## License

This library is published under [MIT license](LICENSE)
