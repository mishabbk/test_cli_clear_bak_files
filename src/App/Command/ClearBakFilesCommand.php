<?php

namespace App\Command;

use App\Classes\ClearBakFiles;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearBakFilesCommand
 */
class ClearBakFilesCommand extends Command
{
    /**
     * Set Configure
     */
    protected function configure()
    {
        $this
            ->setName('clear:bak:files')
            ->setDescription('Clear .bak files')
            ->setHelp('This command allows you to clear useless .bak files')
            ->addArgument(
                'rootDir',
                InputArgument::REQUIRED,
                'Root dir'
            )
            ->addArgument(
                'isRemove',
                InputArgument::OPTIONAL,
                'If need to remove = true or 1 or yes or on, If don\'t need to remove - other or empty',
                false
            )
        ;
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (is_dir($input->getArgument('rootDir'))) {
            $clearBakFiles = new ClearBakFiles(
                filter_var($input->getArgument('isRemove'), FILTER_VALIDATE_BOOLEAN)
            );
            $clearBakFiles->clear($input->getArgument('rootDir'));

            $output->writeln('<info>.bak files has been removed</info>');
        } else {
            $output->writeln('<error>Dir not found OR not a folder</error>');
        }

        return 0;
    }
}
