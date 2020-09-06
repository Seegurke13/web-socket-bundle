<?php


namespace Seegurke13\WebSocketBundle\DependencyInjection;


use Seegurke13\WebSocketBundle\Annotation\Action;
use Seegurke13\WebSocketBundle\EventSubscriber\ControllerArgumentSubscriber;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\VarExporter\VarExporter;

class WebsocketCompilerPass implements CompilerPassInterface
{
    /**
     * @var Reader
     */
    private Reader $reader;

    /**
     * WebsocketCompilerPass constructor.
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function process(ContainerBuilder $container)
    {
        $controller = $container->findTaggedServiceIds('controller.service_arguments');

        $actions = [];
        foreach ($controller as $class=>$item) {
            try {
                $refClass = new \ReflectionClass($class);
                $methods = $refClass->getMethods();
                foreach ($methods as $method) {
                    $annotation = $this->reader->getMethodAnnotation($method, Action::class);
                    if ($annotation instanceof Action) {
                        $actions[$annotation->value] = [$refClass->getName(), $method->getName()];
                    }
                }
            } catch (\Exception $exception) {
            }
        }
        $cacheDir = $container->getParameter('kernel.cache_dir');
        if (is_dir($cacheDir . '/websocket') === false) {
            mkdir($cacheDir . '/websocket');
        }
        file_put_contents($cacheDir . '/websocket/actions.php', '<?php return ' . VarExporter::export($actions) . ' ?>');

        $resolvers = $container->findTaggedServiceIds('websocket.argument_resolver');
        $tmp = [];
        foreach ($resolvers as $class=>$definition) {
            $tmp[] = new Reference($class);
        }
        $container->getDefinition(ControllerArgumentSubscriber::class)->setArgument(0, new IteratorArgument($tmp));
    }
}