<?php

namespace App\Filters;

use App\Filters\vendor\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * RegionFilter Filter
 */
class RegionFilter extends BaseFilter
{
    /**
     * Searchable Field
     * @var array
     */
    protected $searchables = [ 'id', 'name', 'full_name' ];

    /** @var array Array Findable */
    protected $findables = [ 'country_id' ];

    /**
     * Sortables Field
     * @var array
     */
    protected $sortables = [ 'id', 'name', 'province_name', 'regency_name', 'district_name', 'village_name', 'full_name', 'latitude', 'longitude' ];

    /**
     * Default Sort
     * @var string|null
     */
    protected $default_sort = 'id';

    /**
     * Default per page
     * @var int|null
     */
    protected $default_per_page = null;

    public function scope($value)
    {
        $validator = validator([ 'value' => $value ], [ 'value' => 'in:province,regency,district' ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($value) {
            return $query->byScope($value);
        });
    }

    public function scope_only($value)
    {
        $validator = validator([ 'value' => $value ], [ 'value' => 'in:province,regency,district,village' ]);
        return $this->builder->when(!$validator->fails(), function (Builder $query) use($value) {
            return $query->{"to".ucfirst($value)}();
        });
    }

    public function union_doesnt_have_country($value)
    {
        $validator = validator([ 'value' => $value ], [ 'value' => 'boolean' ]);
        return $this->builder->when(!$validator->fails() && $value, function (Builder $query) use($value) {
            return $query->unionDoesntHaveCountry();
        });
    }
}
