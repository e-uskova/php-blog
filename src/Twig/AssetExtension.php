<?php

declare(strict_types=1);

namespace Blog\Twig;

use Psr\Http\Message\ServerRequestInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{
  /**
   * @var array
   */
  private array $serverParams;

  /**
   * @var TwigFunctionFactory
   */
  private TwigFunctionFactory $twigFunctionFactory;
  
  /**
   * @param array $serverParams
   * @param TwigFunctionFactory $twigFunctionFactory
   */
  public function __construct(    
    array $serverParams,    
    TwigFunctionFactory $twigFunctionFactory
  )  {
    $this->serverParams = $serverParams;
    $this->twigFunctionFactory = $twigFunctionFactory;
  }

  /**
   * @return [type]
   */
  public function getFunctions()
  {
    return [
      $this->twigFunctionFactory->create('asset_url', [$this, 'getAssetUrl']),
      $this->twigFunctionFactory->create('url', [$this, 'getUrl']),
      $this->twigFunctionFactory->create('base_url', [$this, 'getBaseUrl']),
    ];
  }

  /**
   * @param string $path
   * 
   * @return string
   */
  public function getAssetUrl(string $path): string
  {
    return $this->serverParams . $path;
  }

  /**
   * @return string
   */
  public function getBaseUrl(): string
  {
      $scheme = $this->serverParams['REQUEST_SCHEME'] ?? 'http';
    return $scheme . '://' . $this->serverParams['HTTP_HOST'] . '/';
  }

  /**
   * @param string $path
   * 
   * @return string
   */
  public function getUrl(string $path): string
  {
    return $this->getBaseUrl() . $path;
  }
}
