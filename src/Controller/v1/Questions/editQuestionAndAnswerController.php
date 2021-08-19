<?php
namespace App\Controller\v1\Questions;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\{Config\Definition\Exception\Exception,
    HttpFoundation\JsonResponse,
    HttpFoundation\Request,
    Routing\Annotation\Route};

class editQuestionAndAnswerController extends AbstractController
{
    var $questionAnswerItem;
    var $category;
    var $question;
    var $answer;

    /**
     * @Route("/v1/Questions/{uuid}/edit", name="editQuestionAndAnswerController" )
     * @param $uuid
     * @param Request $request
     * @return JsonResponse
     */
    public function editNewQuestionAndAnswer(Request $request,$uuid) {
        try {

            $this->questionAnswerItem = $this->getQuestionAnswerItem($uuid);
            $this->category = $this->getCategoryToSave($request);
            $this->question = $this->getQuestionToSave($request);
            $this->answer = $this->getAnswerToSave($request);
            if ($this->questionAnswerItem) {
                if($this->category) {
                    $this->saveCategory();
                }
                if($this->question) {
                    $this->saveQuestion();
                }
                if($this->answer) {
                    $this->saveAnswer();
                }
                $this->persistNewDataToDataBase();
            }
            $response = new JsonResponse();
            $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
            return $response;

        } catch (Exception $exception) {
            $jsonResponseWithError = $this->createJsonResponseWithError($exception);
            return $jsonResponseWithError;
        }

    }

    private function createJsonResponseWithError(Exception $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        return $response;
    }

    private function getQuestionAnswerItem($uuid)
    {
        return $this->getDoctrine()
            ->getRepository(Question::class)
            ->findOneBy(['uuid' => $uuid]);
    }

    private function getCategoryToSave(Request $request)
    {
        return $request->request->get('category');
    }

    private function getQuestionToSave(Request $request)
    {
        return $request->request->get('question');
    }

    private function getAnswerToSave(Request $request)
    {
        return $request->request->get('answer');
    }

    private function saveCategory()
    {
        $this->questionAnswerItem->setCategory($this->category);
    }

    private function saveQuestion()
    {
        $this->questionAnswerItem->setQuestion($this->question);
    }

    private function saveAnswer()
    {
        $this->questionAnswerItem->setAnswer($this->answer);
    }

    private function persistNewDataToDataBase()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->questionAnswerItem);
        $entity_manager->flush();
    }
}