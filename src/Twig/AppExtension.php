<?php

namespace App\Twig;

use App\Entity\Article;
use App\Repository\CategorieRepository;
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
            new TwigFilter('image', [$this, 'getImages'])
        ];
    }

    public function getImages(object $entity, string $nameProperty = 'name'): string
    {
        $images = $entity->{'get' . ucwords($nameProperty)}();

        if ($images) {
            return $this->publicImagePath
                . '/' . $entity->getArticle()->getImagesDirectory()
                . '/' . $images;
        } else {
            return '';
        }
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }
}
