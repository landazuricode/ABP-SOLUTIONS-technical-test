<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city_name',
    ];

    /**
     * Get the user that owns the saved city.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Method to save a city.
     *
     * @param  int  $userId
     * @param  string  $cityName
     * @return SavedCity
     */
    public static function saveCity(int $userId, string $cityName)
    {
        return self::create([
            'user_id' => $userId,
            'city_name' => $cityName,
        ]);
    }

    /**
     * Method to delete a city by ID.
     *
     * @param  int  $cityId
     * @return void
     */
    public static function deleteCity(int $cityId)
    {
        self::destroy($cityId);
    }

    /**
     * Method to retrieve saved cities by user ID.
     *
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getSavedCitiesByUserId(int $userId)
    {
        return self::where('user_id', $userId)->get();
    }
}
