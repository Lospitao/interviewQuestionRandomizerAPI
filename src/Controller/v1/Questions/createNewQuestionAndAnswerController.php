<?php

namespace App\Controller\v1\Questions;


use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class createNewQuestionAndAnswerController extends AbstractController

{
    var $uuid;
    var $createdQandA;


    /**
     * @Route("/v1/Questions/create", name="createQuestionAndAnswerController" )
     * @return JsonResponse
     */
    public function createNewQuestionAndAnswer()
    {
        try {

            $this->createNewQuestionAndAnswerService();
            $this->persistToRepository();
            $response = $this->createJsonResponse();
            return $response;

        } catch (Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }
    }

    private function createNewQuestionAndAnswerService()
    {
        $this->createNewQandA();
        $this->setUuid();
    }

    private function createNewQandA()
    {
        $this->createdQandA = new Question();
    }

    private function setUuid()
    {
        $this->uuid = Uuid::v4();
        $this->createdQandA->setUuid($this->uuid);
    }

    private function persistToRepository()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->createdQandA);
        $entity_manager->flush();
    }

    private function createJsonResponseWithError(\Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }

    private function createJsonResponse()
    {
        return new JsonResponse([
            'uuid' => $this->uuid,
        ]);
    }
}
