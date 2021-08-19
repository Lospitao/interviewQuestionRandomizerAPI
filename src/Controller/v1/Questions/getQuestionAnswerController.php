<?php

namespace App\Controller\v1\Questions;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class getQuestionAnswerController extends AbstractController

{

    var $randomQuestionAndAnswearItem;

    /**
     * @Route("/v1/Questions/play/{uuid}", name="get-parameters" )
     * @return JsonResponse
     * @var $uuid
     */
    public function getQuestionAnswer($uuid)
    {
        try {
            $this->randomQuestionAndAnswearItem = $this->getRandomQuestionAndAnswearItem($uuid);
            $response = $this->getJsonResponse($uuid);
            return $response;

        } catch (Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }


    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }

    private function getRandomQuestionAndAnswearItem($uuid)
    {
        return $this->getDoctrine()
            ->getRepository(Question::class)
            ->findOneBy(['uuid'=>$uuid]);
    }

    private function getJsonResponse($uuid)
    {
        return new JsonResponse([
            'uuid' => $uuid,
            'question' => $this->randomQuestionAndAnswearItem->getQuestion(),
            'answer' => $this->randomQuestionAndAnswearItem->getAnswer(),
            'category' => $this->randomQuestionAndAnswearItem->getCategory(),
        ]);
    }
}
