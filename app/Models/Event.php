<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'published', 'fee', 'location', 'date', 'has_addon', 'grants_entrance'];
    protected $dates = ['date'];

    public function registrations(){
        return $this->hasMany(Registration::class);
    }

    /**
     * @param array $registrant
     * @return Registration
     */
    public function register($registrant){
        return $this->registrations()->create([
            'user_id' => $registrant['user_id'],
            'name' => $registrant['name'],
            'mile_time' => $registrant['mile_time'],
            'email' => $registrant['email'],
        ]);
    }

    public function getFormattedPriceAttribute() {
        return number_format($this->fee / 100, 2);
    }

    public function getFormattedDateAttribute() {
        return $this->date->toFormattedDateString();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'published' => $this->published,
            'has_addon' => $this->has_addon,
            'grants_entrance' => $this->grants_entrance,
            'fee' => $this->fee,
            'formatted_price' => $this->formatted_price,
            'location' => $this->location,
            'dates' => [
                'human' => $this->formatted_date,
                'full' => $this->date
            ]
        ];
    }

    public function toJson($options = 0)
    {
        return parent::toJson($options); // TODO: Change the autogenerated stub
    }
}
