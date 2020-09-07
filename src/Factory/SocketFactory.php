<?php


namespace Seegurke13\WebSocketBundle\Factory;


use React\EventLoop\LoopInterface;
use React\Socket\Server;

class SocketFactory
{
    public static function create(string $host, int $port, LoopInterface $loop)
    {
        return new Server(sprintf('%s:%d', $host, $port), $loop);
    }
}