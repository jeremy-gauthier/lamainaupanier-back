<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;


/**
 * @Route("/api")
 */
class ProductController extends AbstractController
{
    //Find all Products with all datas:
    /**
     * @Route("/products", name="products_list", methods={"GET"})
     */
    public function index(ProductRepository $productRepository)
    {
        return $this->json($productRepository->findAll(), 200, [], ['groups' => 'products:list']);
    }

    //Find one Product by id with all datas:
    /**
     * @Route("/product/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product)
    {
        return $this->json($product, 200, [], ['groups' => 'product:show']);
    }

    //Add new product:
    /**
     * @Route("/product", name="product_add", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, ClassMetadataFactoryInterface $classMetadataFactory, ObjectNormalizer $normalizer)
    {
   
        $jsonRecieved = $request->getContent();
        
        try {
            $product = $serializer->deserialize($jsonRecieved, Product::class, 'json');
            $product->setCreatedAt(new \DateTime());

            $em->persist($product);
            $em->flush();
            $em->refresh($product->getProductType());
            $em->refresh($product->getMeasure());
            $em->refresh($product->getProducer());

            return $this->json($product, 201, [], ['groups' => 'product:add']);
        }catch(NotEncodableValueException $e)
        {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * @Route("/product/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
