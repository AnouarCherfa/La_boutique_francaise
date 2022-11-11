<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{


    // Todo : Constructor
    public function add($id, SessionInterface $session)
    {

        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        

        $session->set('cart', $cart);
    }

    public function get(SessionInterface $session) {
        return $session->get('cart');
    }
}
