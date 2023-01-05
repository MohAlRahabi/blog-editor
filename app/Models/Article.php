<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App\Models
 * @mixin Builder
 */
class Article extends Model
{
    use HasFactory , Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'title',
                'maxLength' => 191,
            ]
        ];
    }
}
