<?php
namespace src\Factory;


use src\Renderer\TemplateRenderer;


final class AjaxActionFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private WriterFactory $writerFactory,
        private TemplateRenderer $renderer,
        private PresenterFactory $presenterFactory,
    ) {}


    public function make(string $className): object
    {
        $reflection = new \ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $className();
        }

        $arguments = [];

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if (! $type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                throw new \LogicException(
                    sprintf(
                        'Impossible de résoudre la dépendance $%s de %s.',
                        $parameter->getName(),
                        $className
                    )
                );
            }

            $arguments[] = $this->resolve($type->getName());
        }

        return $reflection->newInstanceArgs($arguments);
    }


    private function resolve(string $className): object
    {
        return match ($className) {
            ReaderFactory::class => $this->readerFactory,
            ServiceFactory::class => $this->serviceFactory,
            WriterFactory::class => $this->writerFactory,
            TemplateRenderer::class => $this->renderer,
            PresenterFactory::class => $this->presenterFactory,

            default => $this->serviceFactory->get($className),
        };
    }
}
