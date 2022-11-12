<?php

namespace App\Controller;


use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart, SessionInterface $session): Response
    {
        // Récupérer le panier
        $cart = $session->get('cart', []); 

        $cartComplete = [];

        foreach ($cart as $id => $quantity) {
            $cartComplete[] = [
                'product'   => $this->entityManager->getRepository(Product::class)->findOneById($id),
                'quantity'  => $quantity
            ];
        }


        return $this->render('cart/index.html.twig', [
            'cart'  => $cartComplete

        ]);
    }

    #[Route("/cart/add/{id}", name: "add")]
    public function add(Cart $cart, $id, SessionInterface $session)
    {

        $cart->add($id, $session);

        return $this->redirectToRoute('cart');
    }

    #[Route("/cart/remove", name: "remove_my_cart")]
    public function remove(Cart $cart, SessionInterface $session)
    {

        $session->remove('cart');

        return $this->redirectToRoute('products');
    }
}
