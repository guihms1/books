<?php

namespace App\Repositories;

use App\Models\AutorReport;
use App\Repositories\Interfaces\IAutorReportRepository;

class AutorReportRepository extends AbstractBaseRepository implements IAutorReportRepository
{
    protected $model;

    public function __construct(
        AutorReport $autorReport
    ) {
        $this->model = $autorReport;
    }
}
