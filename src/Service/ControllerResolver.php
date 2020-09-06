<?php


namespace Seegurke13\WebSocketBundle\Service;


use Seegurke13\WebSocketBundle\Exception\ActionNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerResolver
{
    private array $actionList = [];

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container, ActionStore $actionStore)
    {
        $this->container = $container;
        $this->actionList = $actionStore->getActions();
    }

    public function resolve($action): callable
    {
        if (array_key_exists($action['action'], $this->actionList) === true) {
            return [
                $this->container->get($this->actionList[$action['action']][0]),
                $this->actionList[$action['action']][1]
            ];
        }

        throw new ActionNotFoundException($action['action']);
    }

    public function addAction($actionName, $controllerName, $methodName): void
    {
        $this->actionList[$actionName] = [
            $controllerName,
            $methodName
        ];
    }

    public function setActions(array $actions)
    {
        $this->actionList = $actions;
    }
}