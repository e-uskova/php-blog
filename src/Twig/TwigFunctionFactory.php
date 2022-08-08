<?php

declare(strict_types=1);

namespace Blog\Twig;

use Twig\TwigFunction;

class TwigFunctionFactory
{
  /**
   * @param mixed ...$arguments
   * 
   * @return TwigFunction
   */
  public function create(...$arguments): TwigFunction
  {
    return new TwigFunction(...$arguments);
  }
}