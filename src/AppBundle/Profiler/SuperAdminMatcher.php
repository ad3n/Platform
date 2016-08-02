<?php

/*
 * This file is part of the Platform package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ihsan\AppBundle\Profiler;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

/**
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
class SuperAdminMatcher implements RequestMatcherInterface
{
    private $authorizationChecker;

    private $kernel;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param KernelInterface $kernel
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker, KernelInterface $kernel)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->kernel = $kernel;
    }

    /**
     * Decides whether the rule(s) implemented by the strategy matches the supplied request.
     *
     * @param Request $request The request to check for a match
     *
     * @return bool true if the request matches, false otherwise
     */
    public function matches(Request $request)
    {
        if ('dev' === strtolower($this->kernel->getEnvironment())) {
            return true;
        }

        return $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN');
    }
}
