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

class ImportFromSassFileCommand extends ContainerAwareCommand{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDescription('Import SASS variables from files defined in configuration to the database')
            ->setHelp(<<<EOT
EOT
            )
            ->setName('compass:connect:import')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->getContainer()->get('connect_compass_project_collection') as $project) {
            $project->import();
        }
    }
}