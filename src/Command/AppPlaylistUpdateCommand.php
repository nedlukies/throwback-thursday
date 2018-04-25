<?php

namespace App\Command;

use GuzzleHttp\Client;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppPlaylistUpdateCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:playlist:update';

    protected function configure()
    {
        $this
            ->setDescription('Download the throwback thursday playlist')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);


		$tracks = $this->getContainer()->get('App\Service\Playlist')->getTracks();


        dump($tracks);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
