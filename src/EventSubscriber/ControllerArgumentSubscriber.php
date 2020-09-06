<?php


namespace Seegurke13\WebSocketBundle\EventSubscriber;


use Seegurke13\WebSocketBundle\Event\ActionControllerEvent;
use Seegurke13\WebSocketBundle\Service\ArgumentResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory;

class ControllerArgumentSubscriber implements EventSubscriberInterface
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

    public static function getSubscribedEvents()
    {
        return [
            ActionControllerEvent::class => 'resolveArguments'
        ];
    }

    public function resolveArguments(ActionControllerEvent $event)
    {
        $metadata = $this->argumentMetadataFactory->createArgumentMetadata($event->getController());
        foreach ($metadata as $data) {
            foreach ($this->argumentResolver as $resolver) {
                if ($resolver->supports($data, $event->getAction())) {
                    $argument = $resolver->resolve($data, $event->getAction());
                    if ($argument !== null) {
                        $event->addArgument($argument);
                    }

                    continue 2;
                }
            }
        }
    }
}