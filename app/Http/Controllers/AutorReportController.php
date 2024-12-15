<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IAutorReportService;

class AutorReportController extends Controller
{
    private $autorReportService;

    public function __construct(
        IAutorReportService $autorReportService
    ) {
        $this->autorReportService = $autorReportService;
    }

    public function index()
    {
        return view('autor_report.index', [
            'data' => $this->autorReportService->getAll()
        ]);
    }
}
