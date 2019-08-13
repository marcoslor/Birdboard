<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Project
 *
 * @property int $id
 * @property string $title
 * @property int $owner_id
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $owner
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDescription($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereOwnerId($value)
 * @method static Builder|Project whereTitle($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Project extends Model
{
    use RecordsActivity;
    protected static $recordableEvents = ['created', 'updated'];

    protected $guarded = [];

    public function path()
    {
        return "/projects/".$this->id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        $task = $this->tasks()->create(compact('body'));
        return $task;
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }


    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }
}
