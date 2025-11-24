<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table            = 'programs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields    = [
        'school_id', 
        'title', 
        'description', 
        'icon', 
        'order_position'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'title'       => 'required|min_length[3]|max_length[100]',
        'description' => 'required|min_length[10]',
        'icon'        => 'required|max_length[100]',
    ];
    
    protected $validationMessages   = [
        'title' => [
            'required' => 'Nama program harus diisi.',
        ],
        'icon' => [
            'required' => 'Icon bootstrap harus dipilih/diisi.',
        ]
    ];
}