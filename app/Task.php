<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;
    private static $recordableEvents = ['created', 'deleted'];

    protected $guarded = [];
    protected $touches = ['project'];
    protected $casts = ['completed' => 'boolean'];

    public function project(){
        return $this->belongsTo(\App\Project::class);
    }

    public function path(){
        return '/tasks/'.$this->id;
    }

    public function complete(){
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }

    public function incomplete(){
        $this->update(['completed' => false]);
        $this->recordActivity('incompleted_task');
    }


}
