<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        $categoryData = ['Computers' => null, 'Laptops' => 1, 'PCs' => 1, 'Tablets' => 1, 'Toshiba' => 2, 'ASUS' => 2,
//            'HP' => 3,'HPA' => 4, 'Lenovo' => 2, 'Dell' => 3, 'Casio' => 4, 'Appliances' => null, 'Cameras' => 12,
//            'Cannon' => 13, 'Sony' => 2, 'Acer' => 4, 'Vacuum Cleaners' => 12, 'Hoover' => 18];
        $categoryData['categories'] = ['Computers', 'Laptops', 'PCs', 'Tablets', 'Toshiba', 'ASUS', 'HP', 'HP', 'Lenovo',
            'Dell', 'Casio', 'Appliances', 'Cameras', 'Cannon', 'Sony', 'Acer', 'Vacuum Cleaners', 'Hoover', 'Nikon', 'Samsung'];
        $categoryData['parentid'] = [null, 1, 1, 1, 2, 2, 3, 4, 2, 3, 4, null, 12, 13, 2, 4, 12, 17, 13, 17];

        $productData['model'] = ['L50', 'Satellite', 'AS300', 'Tablet400', 'Inspiron', 'Vostro', 'D90', 'Pavilion',
            'Vaio', 'Casiopea', 'PIXMA', 'Aspire',  'IdeaPad 320', 'VC 2100',  'hc85-p4-me', 'ThinkPad', 'Portege',
            'Tecra Z40-C', 'Legion Y520', 'Yoga 530-14IKB', 'D3400', 'Elite', 'Pro'];
        $productData['categoryid'] = [5, 5, 6, 8, 10, 10, 19, 7, 15, 11, 14, 16, 9, 20, 18, 9, 5, 5, 9, 9, 19, 8, 8];
/*        $productData['manufacturer'] = ['Toshiba', 'Toshiba', 'ASUS', 'HP', 'Dell', 'Dell', 'Nikon', 'HP', 'Sony',
            'Casio', 'Cannon', 'Acer', 'Lenovo', 'Samsung', 'Hoover', 'Lenovo', 'Toshiba', 'Toshiba', 'Lenovo',
            'Lenovo', 'Nikon', 'HP', 'HP'];*/

        if (count($categoryData['categories']) != count($categoryData['parentid']) ||
//            count($productData['manufacturer']) != count($productData['model']) ||
            count($productData['model']) != count($productData['categoryid'])
        ) {
            return;
        }
        $size = count($categoryData['categories']);
        $categories = [];
        for ($i = 0; $i < $size; $i++) {
            $category = new Category();
            $category->setName($categoryData['categories'][$i]); //array_keys($categoryData)[$i]);

            $categories[] = $category;
            if ($categoryData['parentid'][$i]) {  //array_values($categoryData)[$i]){
                $category->setParent($categories[$categoryData['parentid'][$i] - 1]);   //[array_values($categoryData)[$i] -1]);
            }

            $manager->persist($category);
        }

//        $categories = [];
        $size = count($productData['categoryid']);
        for ($i = 0; $i < $size; $i++) {
            $product = new Product();
            $product->setModel($productData['model'][$i]); //array_keys($productData)[$i]);
            $product->setPrice(mt_rand(100, 500));
//            $product->setManufacturer($productData['manufacturer'][$i]);
            $product->setDateAdded(new \DateTime('now'));

//            $category = new Category();
//            $categories[] = $category;

            $product->setCategory($categories[$productData['categoryid'][$i] - 1]);  //array_values($productData)[$i] - 1]);

            $manager->persist($product);
        }

        $manager->flush();
    }
}