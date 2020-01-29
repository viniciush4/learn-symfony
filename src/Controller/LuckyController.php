<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class LuckyController extends AbstractController
{

     /**
      * Mostra uma lista com todos os numeros da sorte
      * @Route({
      *     "pt": "/sorte/{page}",
      *     "en": "/lucky/{page}"
      * }, requirements={"page"="\d"})
      */
    public function list($page = 20)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $array = [];
        for($i=0; $i<10; $i++){
            array_push($array, random_int(0, 100));
        }

        return $this->render('lucky/list.html.twig', [
            'array_serializado' =>  $serializer->serialize($array, 'json'),
            'array' => $array,
            'page' => $page
        ]);
    }

    /**
     * Mostra um número da sorte
     * @Route({
     *     "pt": "/sorte/{number}",
     *     "en": "/lucky/{number}"
     * }, name="show_number" , requirements={"number"="\d+"})
     */
    public function show($number)
    {
        $array = [];
        for($i=0; $i<10; $i++){
            array_push($array, random_int(0, 100));
        }

        return $this->render('lucky/show.html.twig', [
            'number' => $number,
            'array' => $array
        ]);
    }

    /**
     * Exemplo avançado de rota
     * @Route(
     *     "/articles/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     name="articles",
     *     requirements={
     *         "_locale": "en|fr|pt",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function articles($_locale, $year, $slug)
    {
        return new Response('<h1>'.$_locale.'/'.$year.'/'.$slug.'</h1>', 200, [
            'header_personalisado'=>'meu-header'
        ]);
    }

    /**
     * Redireciona
     * Anotação de rota simples
     * @Route("/lucky/redirecionar")
     */
    public function redirecionar()
    {
        return $this->redirectToRoute('show_number', ['number'=>200]);

        //return $this->redirect('http://symfony.com/doc');
    }

}