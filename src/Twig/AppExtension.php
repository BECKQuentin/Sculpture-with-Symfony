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
            new TwigFilter('image', [$this, 'getImages']),
            new TwigFilter('imageArticle', [$this, 'getImagesArticle']),
            new TwigFilter('creation', [$this, 'getCreation']),
            new TwigFilter('phone', [$this, 'addPhone']),
            new TwigFilter('short', [$this, 'setShort']),
            new TwigFilter('weight', [$this, 'setWeight']),
            new TwigFilter('sum', [$this, 'getSum']),
        ];
    }

    public function getImages(object $entity, string $nameProperty = 'image'): string
    {
        $images = $entity->{'get' . ucwords($nameProperty)}();

        if ($images) {
            return $this->publicImagePath
            . '/' . $entity->getImagesDirectory()
            . '/' . $images;
        } else {
            return '';
        }       
    }

    public function getImagesArticle(object $entity, string $nameProperty = 'name'): string
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

    public function getCreation($images): string
    {
        return 'img' . '/' . 'creations' . '/' . $images;        
    }

    public function addPhone(string $string): string
    {
        // fr
        $str1 = substr($string, 0, 1) . '.' . substr($string, 1);
        $str2 = substr($str1, 0, 4). '.' . substr($str1, 4);
        $str3 = substr($str2, 0, 7). '.' . substr($str2, 7);
        $str4 = substr($str3, 0, 10). '.' . substr($str3, 10);
        // $newstr = substr_replace($string, '.', 1, 1);      
        return "0" . $str4;

        // ch
        // return "+41(0) " . $string;
    }

    public function setShort(string $str): string
    {
        return strlen($str) > 50 ? substr($str,0,50)."..." : $str;  
    }

    public function setWeight(string $str): string
    {
        return $str.' Kg';  
    }

    public function getSum(array $array): int
    {
        return array_sum($array);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }
}
