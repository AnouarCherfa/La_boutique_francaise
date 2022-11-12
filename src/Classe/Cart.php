<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{


    // Todo : Constructor
    public function add($id, SessionInterface $session)
    {
        // j'appel le cart qui est dans ma session 
        $cart = $session->get('cart', []); 

        // Si mon panier contient déja un $id on ajout 1, sinon l'$id égale à 1
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        
        // Récupérer la cart mis à jour
        $session->set('cart', $cart);
    }

    public function get(SessionInterface $session) {
        return $session->get('cart');
    }
}
