<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShirtOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'size'
    ];

    public function registration(){
        return $this->belongsTo(Registration::class);
    }

    public function shirtSizeAttribute(){
        switch ($this->size) {
            case 'xs':
                return "extra small";

            case 'sm':
                return "small";

            case 'md':
                return "medium";

            case 'xm':
                return "extra medium";

            case 'lg':
                return "large";

            case 'xl':
                return "extra large";
        }

        return "any";
    }
}
