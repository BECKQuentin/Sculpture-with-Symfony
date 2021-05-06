<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $publicImagePath;

    public function __construct(string $publicImagePath)
    {
        $this->publicImagePath = $publicImagePath;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('image', [$this, 'getImage'])
        ];
    }
    
    public function getImage(object $entity, string $nameProperty = 'image'): string
    {
        $image = $entity->{'get' . ucwords($nameProperty)}();

        if($image) {
            return $this->publicImagePath.'/'.$entity->getImageDirectory().'/'.$image;
        } else {
            return '';
        }
    }   

    // public function getFunctions(): array
    // {
    //     return [
    //         new TwigFunction('function_name', [$this, 'doSomething']),
    //     ];
    // }

    
}
