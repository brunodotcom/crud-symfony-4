<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_list")
     * @Template("product/index.html.twig")
     */
    public function index()
    {
        $em = $this->getDoctrine()
            ->getManager();
        $products = $em->getRepository(Product::class)
            ->findAll();

        return [
            "products" => $products
        ];
    }

    /**     
     *
     * @param Request $request
     * @return void
     * 
     * @Route("/product/register", name="product_register")
     * @Template("product/create.html.twig")
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
            
            $this->addFlash("success", "Product has been saved with success!");

            return $this->redirectToRoute("product_list");
        }

        return [
            "form" => $form->createView()
        ];
    }

    /**     
     *
     * @param Request $request
     * @return void
     * 
     * @Route("product/edit/{id}", name="product_edit")
     * @Template("product/update.html.twig")
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

            $this->addFlash("success", "Product ".$product->getName()." has been updated with success!");

            return $this->redirectToRoute("product_list");
        }

        return [
            "product" => $product,
            "form" => $form->createView()
        ];
    }

    /**     
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     * 
     * @Route("/product/view/{id}", name="product_view")
     * @Template("product/view.html.twig")
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)
            ->find($id);

        return [
            "product" => $product
        ];
    }

    /**     
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     * 
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)
            ->find($id);
        
            if (!$product) {
                $message = "Product not found!";
                $type = "warning";
            } else {
                $em->remove($product);
                $em->flush();

                $message = "Product has been deleted with success!";
                $type = "success";                
            }
            
            $this->addFlash($type, $message);
            return $this->redirectToRoute("product_list");
    }
}
