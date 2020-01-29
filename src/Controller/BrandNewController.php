<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BrandNewController extends AbstractController
{
    /**
     * @Route("/brand/new", name="brand_new")
     */
    public function index()
    {
        return $this->render('brand_new/index.html.twig', [
            'controller_name' => 'BrandNewController',
        ]);
    }

    /**
     * @Route("/brand/exception", name="brand_exception")
     */
    public function exception()
    {
        //throw $this->createNotFoundException('O produto não existe'); // 404 error
        throw new \Exception('Something went wrong!'); // 500 error
    }

    /**
     * @Route("/brand/query/{firstName}/{lastName}", name="brand_query")
     */
    public function query(Request $request, SessionInterface $session, $firstName, $lastName)
    {
        $page = $request->query->get( 'page', 1);

        return new Response('<h1>'.$page.' - '.$lastName.' - '.$firstName.'</h1>', 200);
    }

    /**
     * @Route("/brand/sessao/{nome}", name="brand_sessao")
     */
    public function sessao(SessionInterface $session, $nome=null)
    {
        if(empty($nome)) {
            $nome = $session->get('nome');
            return new Response('<h1>'.$nome.'</h1>', 200);
        }
        else
        {
            $session->set('nome', $nome);
            return new Response('<h1>Nome salvo com sucesso</h1>', 200);
        }
    }

    /**
     * @Route("/brand/flash/{nome}", name="brand_flash")
     */
    public function flash(SessionInterface $session, $nome=null)
    {
        if(empty($nome)) {
            return $this->render('brand_new/flashes.html.twig');
        }
        else
        {
            $this->addFlash(
                'notice',
                $nome
            );
            return new Response('<h1>Flash salvo com sucesso</h1>', 200);
        }
    }

}
