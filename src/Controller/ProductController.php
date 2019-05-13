<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_list")
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

    /**     
     *
     * @param Request $request
     * @return void
     * 
     * @Route("/product/register", name="product_register")
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->set('success', 'Product has been saved with success!');

            return $this->redirectToRoute("product_list");
        }

        return $this->render("product/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**     
     *
     * @param Request $request
     * @return void
     * 
     * @Route("product/edit/{id}", name="product_edit")
     */
    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)
            ->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->get("session")->getFlashBag()->set(
                "success", 
                "Product ".$product->getName()." has been updated with success!"
            );

            return $this->redirectToRoute("product_list");
        }

        return $this->render("product/update.html.twig", [
            "product" => $product,
            "form" => $form->createView()
        ]);
    }

    /**     
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     * 
     * @Route("/product/view/{id}", name="product_view")
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)
            ->find($id);

        return $this->render("product/view.html.twig", [
            "product" => $product
        ]);
    }
}
