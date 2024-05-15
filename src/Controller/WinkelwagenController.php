<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\PurchaseLine;
use App\Form\AmountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WinkelwagenController extends AbstractController
{

    #[Route('/products', name: 'products')]
    public function index(EntityManagerInterface $em,): Response
    {
        $product = $em->getRepository(Product::class)->findAll();
        return $this->render('main/product.html.twig', [
            'products' => $product,
        ]);
    }


    #[Route('/product/{id}', name: 'app_product')]
    public function product(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $sesssion = $request->getSession();
//         dd($sesssion->get('order'));
        $product = $em->getRepository(Product::class)->find($id);


        $form = $this->createForm(AmountType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$sesssion->get('order')) {
                $sesssion->set('order', []);
            }

            $amount = $form->get('amount')->getData();
            $sesssion->get('order');

            $order[] = [$id, $amount];
            $sesssion->set('order', $order);
            return $this->redirectToRoute("products");

        }
//        $this->addFlash('success','Het product is toegevoegd');


        return $this->render('main/products.html.twig', [
            'form' => $form,
            'products' => $product,
        ]);
    }

//    #[Route('/winkelwagen', name: 'winkelwagen')]
//    public function Winkelwagen(Request $request, EntityManagerInterface $em, int $id): Response
//    {
//        $order = $request->getSession()->get('order');
//        if (!$order) {
//            $this->addFlash('danger', 'je hebt geen producten!');
//            return $this->redirectToRoute('products');
//        }
//        $purchaseLine = [];
//        foreach ($order as $orderLine){
//            $purchaseLine = new PurchaseLine();
//            $product = $em->getRepository(Product::class)->find($orderLine[0]);
//            $purchaseLine->
//        }
//    }
}
