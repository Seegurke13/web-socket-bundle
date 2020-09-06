<?php


namespace Seegurke13\WebSocketBundle\Service;


use Seegurke13\WebSocketBundle\Model\Action;
use Ratchet\ConnectionInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ConnectionArgumentResolver implements ArgumentResolverInterface
{
    public function supports(ArgumentMetadata $metadata, Action $action): bool
    {
        if ($metadata->getType() === ConnectionInterface::class) {
            return true;
        }

        return false;
    }

    public function resolve(ArgumentMetadata $metadata, Action $action)
    {
        return $action->getConnection();
    }
}