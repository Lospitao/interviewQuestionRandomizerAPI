<?php

namespace App\Controller\v1\Questions;


use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class randomizerForQuestionsAndAnswersController extends AbstractController

{
    private $allQuestionAnswerItems;
    private $randomQuestionAnswerItem;
    /**
     * @Route("/v1/Questions/random-question", name="question_randomizer" )
     * @return JsonResponse
     */
    public function questionRandomizer()
    {
        try {
            $this->allQuestionAnswerItems = $this->getAllQuestionsAnswerItems();
            $this->randomQuestionAnswerItem = $this->getRandomQuestionAnswerItem();
            $randomQuestionAnswerUuid = $this-> getrandomQuestionAnswerUuid();
            return $randomQuestionAnswerUuid;

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

    private function getAllQuestionsAnswerItems()
    {
        return $this->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();
    }
    private function getRandomQuestionAnswerItem()
    {
        return array_rand($this->allQuestionAnswerItems, 1);
    }

    private function getrandomQuestionAnswerUuid()
    {
        return new JsonResponse([
            'uuid' => $this->allQuestionAnswerItems[$this->randomQuestionAnswerItem]->getUuid(),
        ]);
    }
}
