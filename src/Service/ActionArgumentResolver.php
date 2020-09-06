<?php


namespace Seegurke13\WebSocketBundle\Service;


use Seegurke13\WebSocketBundle\Model\Action;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ActionArgumentResolver implements ArgumentResolverInterface
{
    public function supports(ArgumentMetadata $metadata, Action $action): bool
    {
        if ($metadata->getType() === 'string'
            && array_key_exists($metadata->getName(), $action->getData()) === true
        ) {
            return true;
        }

        return false;
    }

    public function resolve(ArgumentMetadata $metadata, Action $action)
    {
        if ($this->supports($metadata, $action)) {
            return $action->getData()[$metadata->getName()];
        }

        return null;
    }
}