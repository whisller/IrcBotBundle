<?php
namespace Whisnet\IrcBotBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * @author Daniel Ancuta <whsiller@gmail.com>
 */
class HelpReadPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $reader = new AnnotationReader();
 
        $help = $container->get('whisnet_irc_bot.help');

        foreach ($container->findTaggedServiceIds('whisnet_irc_bot.bot_command') as $id => $attr) {
            $annotations = $reader->getClassAnnotations(new \ReflectionClass($container->get($id)));

            if (is_array($annotations) && isset($annotations[0]) && is_object($annotations[0])) {
                $help->add($annotations[0]->name, $annotations[0]->help, $annotations[0]->arguments);
            }
        }
    }
}