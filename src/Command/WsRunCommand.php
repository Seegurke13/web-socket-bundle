<?php

namespace Seegurke13\WebSocketBundle\Command;

use GuzzleHttp\Psr7\Uri;
use React\EventLoop\LoopInterface;
use React\Socket\Server;
use Seegurke13\WebSocketBundle\Service\WsKernel;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WsRunCommand extends Command
{
    protected static $defaultName = 'ws:run';
//    /**
//     * @var WsKernel
//     */
//    private WsKernel $wsKernel;
//    /**
//     * @var LoopInterface
//     */
//    private LoopInterface $loop;
    /**
     * @var IoServer
     */
    private IoServer $ioServer;

    public function __construct(IoServer $ioServer)
    {
        parent::__construct(self::$defaultName);
        $this->ioServer = $ioServer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Start WebSocket Server')
            ->addOption('port', 'p', InputOption::VALUE_OPTIONAL, 'Port to listen', 8080)
            ->addOption('host', 'i', InputOption::VALUE_OPTIONAL, 'Port to listen', '127.0.0.1')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('WebSocket Server');
        $this->ioServer->run();

//        $socket = new Server('127.0.0.1:' . $input->getOption('port'), $this->loop);
//
//        $server = new IoServer(
//            new HttpServer(
//                new WsServer($this->wsKernel)
//            ),
//            $socket,
//            $this->loop
//        );
//
        $io->writeln('start server on ' . $input->getOption('host') . ':' . $input->getOption('port'));
//
//        $server->run();

        return Command::SUCCESS;
    }
}
