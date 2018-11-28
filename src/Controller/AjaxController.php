<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 24/11/2018
 * Time: 20:00
 */

namespace App\Controller;


use App\Repository\TrickRepository;
use http\Env\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * AjaxController constructor.
     * @param TrickRepository $trickRepository
     */
    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }


    /**
     * @Route(path="/ajax", name="ajax", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax(Request $request)
    {
        $offset = $request->request->get('offset');
        $limit = $request->request->get('limit');

        $tricks = $this->trickRepository->findBy(array(), array('id' => 'DESC'), $limit, $offset);

        $array = [];

        foreach ($tricks as $trick)
        {
            $array[] = ['id' => $trick->getId(),
                        'name' => $trick->getName(),
                        'description' => $trick->getDescription(),
                        'category' => $trick->getCategory(),
                        ];

        }

        return new JsonResponse($array);

    }

}