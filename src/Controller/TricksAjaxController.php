<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TricksAjaxController
 *
 * @package \App\Controller
 */
class TricksAjaxController
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
     * @Route(path="/ajax", name="tricks_more", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax(Request $request)
    {
        $offset = $request->request->get('offset');
        $limit = $request->request->get('limit');

        $tricks = $this->trickRepository->findBy(array(), array('id' => 'DESC'), $limit, $offset);

        $tricksArray = [];
        $imagesArray = [];

        foreach ($tricks as $trick)
        {

            $images = $trick->getImages();

            if($images->isEmpty()){
                $tricksArray[] = ['id' => $trick->getId(),
                    'name' => $trick->getName(),
                    'description' => $trick->getDescription(),
                    'category' => $trick->getCategory(),
                    'images' => ['0' => [
                        'webPath' => "/img/default.png"
                    ]],
                ];
            }else {
                foreach ($images as $image)
                {
                    $imagesArray[] = ['webPath' => $image->getWebPath(),];

                    $tricksArray[] = ['id' => $trick->getId(),
                        'name' => $trick->getName(),
                        'description' => $trick->getDescription(),
                        'category' => $trick->getCategory(),
                        'images' => $imagesArray,
                    ];
                }
            }

        }

        return new JsonResponse($tricksArray);

    }
}
