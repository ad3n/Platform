<?php

/*
 * This file is part of the Platform package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ihsan\AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use SymfonyId\AdminBundle\User\AdvancedUser as BaseUser;

/**
 * @MongoDB\Document
 *
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}
