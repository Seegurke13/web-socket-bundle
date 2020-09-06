<?php


namespace Seegurke13\WebSocketBundle\Service;


use Seegurke13\WebSocketBundle\Model\Action;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

interface ArgumentResolverInterface
{
    public function supports(ArgumentMetadata $metadata, Action $action): bool;
    public function resolve(ArgumentMetadata $metadata, Action $action);
}