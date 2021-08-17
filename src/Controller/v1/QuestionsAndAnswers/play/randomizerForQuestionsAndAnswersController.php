<?php

namespace App\Controller\v1\QuestionsAndAnswers\play;


use App\Entity\InterviewItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class randomizerForQuestionsAndAnswersController extends AbstractController

{


    /**
     * @Route("/v1/QuestionsAndAnswers/play/random-question", name="randomizer" )
     * @return JsonResponse
     */
    public function playNewQuestionAndAnswer()
    {
        try {
            $allQuestionAnswerItems =$this->getDoctrine()
                ->getRepository(InterviewItem::class)
                ->findAll();

            $randomQuestionAnswerItem = array_rand($allQuestionAnswerItems, 1);
            $response = new JsonResponse([
                'uuid' => $allQuestionAnswerItems[$randomQuestionAnswerItem]->getUuid(),
            ]);
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
}
