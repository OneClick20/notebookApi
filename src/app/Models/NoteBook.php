<?php

namespace App\Models;

use App\Collections\NoteBookCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class NoteBook extends Model
{
    protected $table = 'notebook';

    protected $fillable = [
        'name',
        'company',
        'phone',
        'email',
        'birth_date',
        'image',

    ];

    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public $timestamps = false;
    
    public function newCollection(array $models = []): Collection
    {
        return new NoteBookCollection($models);
    }

}
