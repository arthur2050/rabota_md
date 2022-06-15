<?php


namespace App\Services;

/**
 * Class JobHelperService
 * @package App\Services
 */
class JobHelperService
{
    private $jobApiService;

    /**
     * JobHelperService constructor.
     * @param JobApiService $jobApiService
     */
    public function __construct(JobApiService $jobApiService)
    {
        $this->jobApiService = $jobApiService;
    }

    public function setData()
    {
        $this->jobApiService->getUrlDataAndWriteIntoDatabase();
    }
}