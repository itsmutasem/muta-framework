<?php

namespace App\Models;

use Framework\Model;

class Product extends Model
{
    protected $table = 'products';

    protected function validate(array $data): bool
    {
        if (empty($data['name'])) {
            return false;
        }
        return true;
    }
}
