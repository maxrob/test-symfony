<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Food;
use ApiBundle\Service\ResponseService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/foods")
 */
class FoodController extends Controller
{
    /**
     * @var JsonEncoder $encoder
     */
    private $encoder;

    /**
     * @var ObjectNormalizer $normalizer
     */
    private $normalizer;

    /**
     * @var Serializer $serializer
     */
    private $serializer;

    /**
     * @var ResponseService $response
     */
    private $response;

    public function __construct()
    {
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->serializer = new Serializer([$this->normalizer], [$this->encoder]);
        $this->response = new ResponseService();
    }

    /**
     * @Route("/", name="api_food_all")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function allAction()
    {
        $this->normalizer->setIgnoredAttributes(array('nutrients'));
        $this->serializer = new Serializer([$this->normalizer], [$this->encoder]);

        $foods = $this->getDoctrine()->getRepository('ApiBundle:Food')->findAll();

        if(!$foods) {
            return $this->response->error("No foods", 500);
        }

        return $this->response->success($this->serializer->normalize($foods));
    }

    /**
     * @Route("/{id}", name="api_food_get", requirements={"id": "\d+"})
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function getAction($id)
    {
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getNutrients();
        });
        $this->serializer = new Serializer([$this->normalizer], [$this->encoder]);

        $food = $this->getDoctrine()->getRepository('ApiBundle:Food')->find($id);

        if(!$food) {
            return $this->response->error("Not found this food", 404);
        }

        return $this->response->success($this->serializer->normalize($food));
    }

    /**
     * @Route("/search", name="api_food_search")
     * @Method({"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $this->normalizer->setIgnoredAttributes(array('nutrients'));
        $this->serializer = new Serializer([$this->normalizer], [$this->encoder]);

        $foodRepository = $this->getDoctrine()->getRepository('ApiBundle:Food');
        $search = ($request->request->has('search')) ? $request->request->get('search') : "";

        $foods = $foodRepository->getBySearch($search);

        if(!$foods) {
            return $this->response->error("No foods for name ".$search, 500);
        }
        
        return $this->response->success($this->serializer->normalize($foods));
    }
    
}
