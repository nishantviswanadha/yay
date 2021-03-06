<?php

namespace Component\HttpFoundation\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class HeaderFieldConverter implements ParamConverterInterface
{
    public function supports(ParamConverter $configuration): bool
    {
        return 'HeaderField' === $configuration->getConverter();
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $options = $configuration->getOptions();
        $target = $configuration->getName();
        $source = isset($options['field']) ? $options['field'] : $target;

        if (!$request->headers->has($source)) {
            return;
        }

        $value = $request->headers->get($source);
        $request->attributes->set($target, $value);
    }
}
