<?php


namespace Seegurke13\WebSocketBundle\Service;


use Seegurke13\WebSocketBundle\Model\Action;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory;

class ArgumentResolver implements ArgumentResolverInterface
{
    /**
     * @var ArgumentResolverInterface[]
     */
    private iterable $argumentResolver;

    /**
     * @var mixed|ArgumentMetadataFactory
     */
    private $argumentMetadataFactory;

    public function __construct(iterable $argumentResolver = [], ?ArgumentMetadataFactory $argumentMetadataFactory = null)
    {
        $this->argumentResolver = $argumentResolver ?: [];
        $this->argumentMetadataFactory = $argumentMetadataFactory ?: new ArgumentMetadataFactory();
    }

    public function supports(ArgumentMetadata $metadata, Action $action): bool
    {
        // TODO: Implement supports() method.
    }

    public function resolve(ArgumentMetadata $metadata, Action $action)
    {
        // TODO: Implement resolve() method.
    }
}