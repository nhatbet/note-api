<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Database\Eloquent\Model;

class ReportService
{
    public function createForModel(Model $model, $attrs): Report
    {
        $report = $model->reports()->create($attrs);

        return $report;
    }
}
