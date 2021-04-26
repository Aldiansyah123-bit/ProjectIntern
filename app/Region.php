<?php

namespace App;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Region extends Model
{
    use Filterable;
//    protected $fillable =[
//        'name', 'type', 'latitude', 'longitude', 'country_id',
//    ];

    /** @var string Filter Class */
    protected $filters = 'App\Filters\RegionFilter';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('global', function (Builder $query) {
            if (empty($query->getQuery()->columns)) {
                $query->select([ '*' => $query->qualifyColumn('*') ]);
            }
        });

        static::addGlobalScope('full_name', function (Builder $query) {
            foreach ([ 'provinces', 'regencies', 'districts', 'villages' ] as $key => $table) {
                $region = (new Region)->setTable($table);
                $query->leftJoin((new Region)->getTable()." as {$region->getTable()}", function (JoinClause $q) use($query, $region, $table) {
                    $length = ($table == 'villages' ? 10 : ($table == 'districts' ? 7 : ($table == 'regencies' ? 4 : 2)));
                    $q->whereColumn($region->getQualifiedKeyName(), DB::raw("SUBSTR({$query->getModel()->getQualifiedKeyName()}, 1, $length)"))
                        ->whereRaw("LENGTH({$region->getQualifiedKeyName()}) = ${length}");
                });
            }
        });
    }

    public function qualifyColumn($column)
    {
        $province = (new static)->setTable('provinces');
        $regency = (new static)->setTable('regencies');
        $district = (new static)->setTable('districts');
        $village = (new static)->setTable('villages');
        if ($column == '*') {
            return DB::raw(
                "{$this->qualifyColumn('id')}, ".
                "{$this->qualifyColumn('name')}, ".
                "{$this->qualifyColumn('type')}, ".
                "{$this->qualifyColumn('latitude')}, ".
                "{$this->qualifyColumn('longitude')}, ".
                "{$this->qualifyColumn('country_id')}, ".
                DB::raw($this->qualifyColumn('province_id')) . ' as province_id, ' . DB::raw($this->qualifyColumn('province_name')) . ' as province_name, '.
                DB::raw($this->qualifyColumn('regency_id')) . ' as regency_id, ' . DB::raw($this->qualifyColumn('regency_name')) . ' as regency_name, '.
                DB::raw($this->qualifyColumn('district_id')) . ' as district_id, ' . DB::raw($this->qualifyColumn('district_name')) . ' as district_name, '.
                DB::raw($this->qualifyColumn('village_id')) . ' as village_id, ' . DB::raw($this->qualifyColumn('village_name')) . ' as village_name, '.
                DB::raw($this->qualifyColumn('full_name')).' as full_name'
            );
        } elseif ($column == 'full_name'/* || $column == 'full_name_inverse'*/) {
            return ($this->getConnection()->getDriverName() == 'sqlite') ? DB::raw(
                '('.
                collect($column == 'full_name_inverse' ? [ $village, $district, $regency, $province ] : [ $province, $regency, $district, $village ])->map(function (Region $region, $key) use($column) {
                    return "(CASE ".
                        "WHEN ".
                        "{$this->qualifyColumn(Str::singular($region->getTable()).'_name')} IS NOT NULL ".
                        ($column == 'full_name_inverse' ?
                            ($key == 3 ? "THEN {$region->getTable()}.name " : "THEN ({$region->getTable()}.name || ', ') ") :
                            ($key == 0 ? "THEN {$region->getTable()}.name " : "THEN (', ' || {$region->getTable()}.name) ")
                        ).
                        "ELSE '' END".
                        ")";
                })->implode(' || ').
                ')'
            ) :  DB::raw(
                'CONCAT('.
                collect($column == 'full_name_inverse' ? [ $village, $district, $regency, $province ] : [ $province, $regency, $district, $village ])->map(function (Region $region, $key) use($column) {
                    return "(CASE ".
                        "WHEN ".
                        "{$this->qualifyColumn(Str::singular($region->getTable()).'_name')} IS NOT NULL ".
                        ($column == 'full_name_inverse' ?
                            ($key == 3 ? "THEN {$region->getTable()}.name " : "THEN CONCAT({$region->getTable()}.name, ', ') ") :
                            ($key == 0 ? "THEN {$region->getTable()}.name " : "THEN CONCAT(', ', {$region->getTable()}.name) ")
                        ).
                        "ELSE '' END".
                        ")";
                })->implode(', ').
                ')'
            );
        } elseif (Str::contains($column, [ 'province_', 'regency_', 'district_', 'village_' ])) {
            $region = explode('_', $column);
            return ${$region[0]}->getTable().'.'.($region[1]);
        }

        return parent::qualifyColumn($column);
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return 'region_id';
    }
}
