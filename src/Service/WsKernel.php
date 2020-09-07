<?php


namespace Seegurke13\WebSocketBundle\Service;


use React\EventLoop\LoopInterface;
use Seegurke13\WebSocketBundle\Event\ActionControllerEvent;
use Seegurke13\WebSocketBundle\Event\ConnectionCloseEvent;
use Seegurke13\WebSocketBundle\Event\ConnectionDataEvent;
use Seegurke13\WebSocketBundle\Event\ConnectionOpenEvent;
use Seegurke13\WebSocketBundle\Model\Action;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class WsKernel implements MessageComponentInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var ControllerResolver
     */
    private ControllerResolver $controllerResolver;

    private LoopInterface $loop;

    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $logger, ControllerResolver $controllerResolver, LoopInterface $loop)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
        $this->controllerResolver = $controllerResolver;
        $this->loop = $loop;
    }

    function onOpen(ConnectionInterface $conn)
    {
        $openEvent = new ConnectionOpenEvent();
        $openEvent->setConnection($conn);
        $this->eventDispatcher->dispatch($openEvent);

        $this->logger->info('new connection');
    }

    function onClose(ConnectionInterface $conn)
    {
        $closeEvent = new ConnectionCloseEvent();
        $closeEvent->setConnection($conn);
        $this->eventDispatcher->dispatch($closeEvent);

        $this->logger->info('close connection');

    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        var_dump([
            $e->getMessage(),
            $e->getCode(),
            $e->getFile() . '::' . $e->getLine()
        ]);
        throw $e;
        $this->logger->error($e->getMessage(), (array)$conn);
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        $this->logger->debug($msg);

        $dataEvent = new ConnectionDataEvent();
        $dataEvent->setConnection($from);
        $dataEvent->setMessage($msg);
        $this->eventDispatcher->dispatch($dataEvent);

        $controller = $this->controllerResolver->resolve($dataEvent->getAction());

        $controllerEvent = new ActionControllerEvent();
        $controllerEvent->setController($controller);

        $action = new Action();
        $action->setConnection($from);
        $action->setAction($dataEvent->getAction()['action']);
        $action->setData($dataEvent->getAction());

        $controllerEvent->setAction($action);
        $this->eventDispatcher->dispatch($controllerEvent);

        $controller(...$controllerEvent->getArguments());
    }

    /**
     * @return LoopInterface
     */
    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    /**
     * @param LoopInterface $loop
     */
    public function setLoop(LoopInterface $loop): void
    {
        $this->loop = $loop;
    }
}