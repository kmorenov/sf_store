<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 16/06/18
 * Time: 12:10 PM
 */

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Category;
use App\Repository;

use Doctrine\ORM\EntityRepository;
class CatalogController extends Controller
{
    /**
     * @Route("/cat", name="cat")
     */
    public function cat() //CategoryRepository $categoryRepository)
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('catalog/shop.html.twig', compact('categories'));

    }
}