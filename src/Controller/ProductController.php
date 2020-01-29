<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        // look for *all* Product objects
        $products = $this->getDoctrine()
            ->getRepository(Product::class)->findAll();

        //$product = $repository->find($id);

        //$product = $repository->findOneBy(['name' => 'Keyboard']);

        //$product = $repository->findOneBy([
        //    'name' => 'Keyboard',
        //    'price' => 1999,
        //]);

        //$products = $repository->findBy(
        //    ['name' => 'Keyboard'],
        //    ['price' => 'ASC']
        //);

        //$products = $repository->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No products'
            );
        }

        return new Response(json_encode($products));
    }

    /**
     * @Route("/product/{id}", name="product_show", requirements={"id"="\d+"})
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/product/nome/{id}", name="product_name")
     */
    public function showNome(Product $product)
    {
        return new Response('O nome do produto é '.$product->getName());
    }

    /**
     * @Route("/product/update/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return new Response('O produto foi alterado com sucesso '.$product->getId());
    }

    /**
     * @Route("/product/delete/{id}")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return new Response('O produto foi removido com sucesso');
    }

    /**
     * @Route("/product/busca-preco")
     */
    public function buscaPreco()
    {
        $minPrice = 1000;

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllGreaterThanPrice2($minPrice);


        if (!$products) {
            throw $this->createNotFoundException(
                'No product found for id'
            );
        }

        return new Response(json_encode($products));
    }
}
