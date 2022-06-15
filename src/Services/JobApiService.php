<?php


namespace App\Services;

use App\Entity\Job;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use DOMXPath;

/**
 * Class JobApiService
 * @package App\Services
 */
class JobApiService
{
    private $apiRequestService;
    private $jobRepository;
    private $entityManager;

    /**
     * JobApiService constructor.
     * @param ApiRequestService $apiRequestService
     * @param JobRepository $jobRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ApiRequestService $apiRequestService,
                                JobRepository $jobRepository,
                                EntityManagerInterface $entityManager)
    {
        $this->apiRequestService = $apiRequestService;
        $this->apiRequestService->setApiRequestHelper(new GuzzleHelperService($this->apiRequestService::BASE_URL_REQUEST));
        $this->jobRepository = $jobRepository;
        $this->entityManager = $entityManager;
    }

    /**
     *
     */
    public function getUrlDataAndWriteIntoDatabase()
    {

        if($this->jobRepository->findAll() != null) return;
        $urlData = $this->apiRequestService->getUrlData()->getBody();
        $htmlString = (string)$urlData;
        //add this line to suppress any warnings
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($htmlString);
        $xpath = new DOMXPath($doc);
        $xpathTitles = $xpath->evaluate('//div[@class="col mb-5 js-card-item card-item job-card"]//div//div//div//a/span');
        //title and description the same $descriptions
        $xpathLocations = $xpath->evaluate('//div[@class="card-footer pl-4 pr-4 pb-4 pt-2 border-0 "]//div//div//div[@class="d-flex min-width-3"]//a');
        $xpathCompanies = $xpath->evaluate('//div[@class="card-body p-4"]//div[@class="text-center"]//div[@class="h6 text-muted text-truncate py-2"]//small');

        foreach ($xpathTitles as $key=>$title) {
            $job = new Job();
            $job->setTitle(trim($title->textContent.PHP_EOL));
            $job->setLocation(trim($xpathLocations[$key]->textContent.PHP_EOL));
            $job->setCompany(trim($xpathCompanies[$key]->textContent.PHP_EOL));
            $job->setDescription(trim($title->textContent.PHP_EOL));
            $this->jobRepository->add($job);
        }
        $this->entityManager->flush();//save into the database

    }

}