<?php

namespace App\Services;

use App\Repositories\Interfaces\IAutorReportRepository;
use App\Services\Interfaces\IAutorReportService;

class AutorReportService implements IAutorReportService
{
    private $autorReportRepository;

    public function __construct(
        IAutorReportRepository $autorReportRepository
    ) {
        $this->autorReportRepository = $autorReportRepository;
    }

    public function getAll(): iterable
    {
        return $this->autorReportRepository->getAll();
    }
}
