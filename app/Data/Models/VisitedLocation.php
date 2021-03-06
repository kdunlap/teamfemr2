<?php

namespace FEMR\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitedLocation extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visited_locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'address_ext',
        'locality',
        'administrative_area_level_1',
        'administrative_area_level_2',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'address'                     => 'string',
        'address_ext'                 => 'string',
        'locality'                    => 'string',
        'administrative_area_level_1' => 'string',
        'administrative_area_level_2' => 'string',
        'postal_code'                 => 'string',
        'country'                     => 'string',
        'latitude'                    => 'double',
        'longitude'                   => 'double',
        'start_date'                  => 'date',
        'end_date'                    => 'date'
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    //protected $dateFormat = 'Y-m-d';

    /**
     * The attributes that should not be encoded to json
     *
     * @var array
     */
    protected $hidden = [

        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [

        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes to append when returning json
     *
     * @var array
     */
    protected $appends = [

      'city_state_country'
    ];

    /**
     * @param $start_date
     */
    public function setStartDateAttribute( $start_date )
    {
        if( empty( $start_date ) ) {

            $this->attributes['start_date'] = null;
        }
        else {

            $this->attributes['start_date'] = $start_date;
        }
    }

    /**
     * @param $start_date
     */
    public function setEndDateAttribute( $start_date )
    {
        if( empty( $start_date ) ) {

            $this->attributes['end_date'] = null;
        }
        else {

            $this->attributes['end_date'] = $start_date;
        }
    }

    /**
     * @return string
     */
    public function getCityCountryAttribute(){

        $text = '';

        // locality
        if( $this->locality ){

            $text .= $this->locality;
        }

        // country
        if( $this->country ){

            if( strlen( $text ) > 0 ) $text .= ', ';

            $text .= $this->country;
        }

        return $text;
    }

    /**
     * @return string
     */
    public function getCityStateCountryAttribute(){

        $text = '';

        // locality
        if( $this->locality ){

            $text .= $this->locality;
        }

        // administrative_area_level_1 (state)
        if( $this->administrative_area_level_1 ){

            if( strlen( $text ) > 0 ) $text .= ', ';

            $text .= $this->administrative_area_level_1;
        }

        // country
        if( $this->country ){

            if( strlen( $text ) > 0 ) $text .= ' ';

            $text .= $this->country;
        }

        return $text;
    }

    /**
     * @param $query
     * @param $latitude
     * @param $longitude
     * @param int $radius
     *
     * @return
     */
    public function scopeNearbyLocation( $query, $latitude, $longitude, $radius = 1000 )
    {
        return $query->selectRaw(
                        'id,
                        outreach_program_id,
                        ( 6371 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                        ) AS distance',
                            [ $latitude, $longitude, $latitude ]
                        )
                     ->having( "distance", "<=", $radius )
                     ->orderBy( "distance", 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outreachProgram()
    {
        return $this->belongsTo( OutreachProgram::class );
    }
}
