<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;
use Modules\Base\Entities\Photo;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function newFactory()
    {
        return \Modules\Project\Database\factories\ProjectFactory::new();
    }

    public function photo()
    {
        return $this->morphMany(Photo::class, 'pictures');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($project){
            $project->photo()->get()->each(function ($photo){
                File::delete($photo->path);
                $photo->delete();
            });
        });
    }
}
