<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    protected $table            = 'schools';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug', 'description', 'hero_image', 'logo'];

    // Kita tidak butuh logic aneh-aneh, cukup method bawaan findAll() nanti.
}