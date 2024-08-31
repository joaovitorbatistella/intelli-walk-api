<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrences extends Model
{
    use HasFactory;

    protected $table = 'occurrences';

    protected $fillable = [
        "distance",
        "position_left_x",
        "position_left_y",
        "position_right_x",
        "position_right_y",
        "pressure",
        "gear_id",
    ];
}
