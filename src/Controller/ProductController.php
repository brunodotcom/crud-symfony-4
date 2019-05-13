<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        $em = $this->getDoctrine()
            ->getManager();
        $products = $em->getRepository(Product::class)
            ->findAll();

        return $this->render("product/index.html.twig", [
            "products" => $products
        ]);
    }
}
