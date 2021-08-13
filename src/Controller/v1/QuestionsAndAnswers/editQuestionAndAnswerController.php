<?php
namespace App\Controller\v1\QuestionsAndAnswers;

use App\Entity\InterviewItem;
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
    var $answear;

    /**
     * @Route("/v1/QuestionsAndAnswers/{uuid}", name="editQuestionAndAnswerController" )
     * @param $uuid
     * @param Request $request
     * @return JsonResponse
     */
    public function editNewQuestionAndAnswer(Request $request,$uuid) {
        try {

            $this->getQuestionAnswearItem($uuid);
            $this->category = $this->getCategoryToSave($request);
            $this->question = $this->getQuestionToSave($request);
            $this->answear = $this->getAnswearToSave($request);
            if ($this->questionAnswerItem) {
                if($this->category) {
                    $this->saveCategory();
                }
                if($this->question) {
                    $this->saveQuestion();
                }
                if($this->answear) {
                    $this->saveAnswear();
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

    private function getQuestionAnswearItem($uuid)
    {
        $this->questionAnswerItem =$this->getDoctrine()
            ->getRepository(InterviewItem::class)
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

    private function getAnswearToSave(Request $request)
    {
        return $request->request->get('answear');
    }

    private function saveCategory()
    {
        $this->questionAnswerItem->setCategory($this->category);
    }

    private function saveQuestion()
    {
        $this->questionAnswerItem->setQuestion($this->question);
    }

    private function saveAnswear()
    {
        $this->questionAnswerItem->setAnswear($this->answear);
    }

    private function persistNewDataToDataBase()
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($this->questionAnswerItem);
        $entity_manager->flush();
    }
}