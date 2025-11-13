<?php

namespace holoo\modules\Visits\Repositories;

use App\Modules\Visits\src\Models\Visits;
use holoo\modules\Bases\Http\Contracts\BaseRepository;
use holoo\modules\Bases\Http\Contracts\BaseRepositoryInterface;

class VisitsRepositories extends BaseRepository  implements VisitInteface
{
    public function model(): mixed
    {
        return visits::class;
    }
  public function filterSalesReport(array $data)
    {
        $search= isset($data['type']) && trim($data['type']) !== '' ? trim($data['type']) : null;

        return Visits::query()
             ->where()
            ->latest('id')
            ->paginate(50);
    }
}
