<?php


namespace App\Controller;


use App\Repository\CVRepository;
use App\Repository\JobRepository;
use App\Services\JobHelperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class JobController
 * @package App\Controller
 * @Route("/job")
 */
class JobController extends AbstractController
{
    private $jobHelperService;
    private $jobRepository;
    private $cvRepository;

    /**
     * JobController constructor.
     * @param JobHelperService $jobHelperService
     * @param JobRepository $jobRepository
     * @param CVRepository $cvRepository
     */
    public function __construct(JobHelperService $jobHelperService,
                                JobRepository $jobRepository,
                                CVRepository $cvRepository)
    {
        $this->jobHelperService = $jobHelperService;
        $this->jobRepository = $jobRepository;
        $this->cvRepository = $cvRepository;
    }

    /**
     * @Route("/form_find", methods={"GET"})
     * @return Response
     */
    public function formFind()
    {
        $this->jobHelperService->setData();
        return $this->render('job.find.html.twig');
    }

    /**
     * @Route("/find_by_keyword", methods={"GET"}, name="find_by_keyword")
     * @param Request $request
     * @return JsonResponse
     */
    public function findByKeyword(Request $request)
    {
        $keyword = $request->query->get('keyword');
        return $this->json(
            [
                "jobs" => $this->jobRepository->findByKeyword($keyword),
                "cvs" => $this->cvRepository->findByKeyword($keyword)
            ]
        );
    }

    /**
     * @Route("/detail_page", name="detail_page")
     * @param Request $request
     * @return Response
     */
    public function detailPage(Request $request)
    {
        return $this->render('suitable.candidates.html.twig', [
            'cvs' => $request->request->get('cvs')
        ]);
    }

}