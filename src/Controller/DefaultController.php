<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 26/11/18
 * Time: 4:31 AM
 */
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Repository\ProductRepository;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function viewOrder(ProductRepository $productRepository)
    {
//         $this->denyAccessUnlessGranted('ORDER_VIEW', $orders);
        $orders = $this->getDoctrine()->getRepository('App:Orders')->findAll();
        $products = $productRepository->findAll();

        dump($role = $this->getUser()->getRoles()[0]);



        switch ($role) {
            case 'ROLE_SUPER_ADMIN':
                return $this->redirectToRoute('admin_app_orderposition_list');
            // logic to determine if the user can EDIT
            // return true or false
            case 'ROLE_ADMIN':
                return $this->render('order/index.html.twig', compact('orders'));
            // logic to determine if the user can VIEW
            // return true or false
            case 'ROLE_USER':
                return $this->redirectToRoute('cart');
            default:
                return false;
        }

        return false;



//        $this->denyAccessUnlessGranted($role, $orders);

//        return $this->redirectToRoute('category');


/*        if ($this->denyAccessUnlessGranted($role, $orders)){  //isGranted($role, $orders)) {
//        if ($this->isGranted($role, $orders)) {
            dump('controller in RSA');
            return $this->render('order/index.html.twig', compact('orders'));
        }
        elseif ($this->denyAccessUnlessGranted($role, $products)) {
            dump('controller in RA');
            return $this->render('product/index.html.twig', ['products' => $products]);
        }

        dump('before return');
        return $this->redirectToRoute('category');*/
    }
}