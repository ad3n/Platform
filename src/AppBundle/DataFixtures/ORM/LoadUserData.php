<?php

/*
 * This file is part of the Platform package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ihsan\AppBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ihsan\AppBundle\Entity\User;

/**
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
final class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    const DEFAULT_USER = 'siab';

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        if ($userManager->findUserByUsername(self::DEFAULT_USER)) {
            return;
        }

        $date = new \DateTime();

        $user = new User();
        $user->setUsername(self::DEFAULT_USER);
        $user->setEmail('admin@mail.com');
        $user->setFullName('super administrator');
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setPlainPassword(self::DEFAULT_USER);
        $user->setEnabled(true);
        $user->setCreatedAt($date);
        $user->setUpdatedAt($date);
        $user->setCreatedBy('SYSTEM');
        $user->setUpdatedBy('SYSTEM');

        $userManager->updateUser($user);
    }
}
