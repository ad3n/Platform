<?php

/*
 * This file is part of the Platform package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ihsan\AppBundle\Command;

use Ihsan\AppBundle\DataFixtures\ORM\LoadUserData as Fixtures;
use Ihsan\AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
class SkeletonSetupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('platform:setup')
            ->setDescription('Ihsan Platform Setup')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $createSchema = $this->getApplication()->find('doctrine:schema:update');
        $loadFixtures = $this->getApplication()->find('doctrine:fixtures:load');
        $installAssets = $this->getApplication()->find('assets:install');
        $dumpJsRouting = $this->getApplication()->find('fos:js-routing:dump');

        $createSchema->run(new ArrayInput(array('--force' => true)), $output);

        $userManager = $this->getContainer()->get('fos_user.user_manager');
        if (!$userManager->findUserByUsername(Fixtures::DEFAULT_USER) && User::class === $this->getContainer()->getParameter('user_class')) {
            $loadFixtures->run($input, $output);
        }

        $installAssets->run(new ArrayInput(array('--relative' => true)), $output);
        $dumpJsRouting->run($input, $output);

        $output->writeln('<info>Platform sudah siap digunakan...</info>');
        $output->writeln('<info>Jalankan: php bin/console server:run</info>');
        $output->writeln('<info>Username dan password: siab</info>');
        $output->writeln('<info>localhost:8000/admin</info>');
    }
}
