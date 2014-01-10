<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 10/01/14
 * Time: 15:03
 * To change this template use File | Settings | File Templates.
 */

namespace Mrogelja\ConnectCompassBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpSassFileCommand extends ContainerAwareCommand{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDescription('Dump SASS variables from the database to files defined in configuration ')
            ->setHelp(<<<EOT
EOT
            )
            ->setName('compass:connect:dump')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->getContainer()->get('connect_compass_project_collection') as $project) {
            $project->dump();
        }
    }
}