<?php


namespace App;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    public $oldAttributes = [];
    protected static $defaultRecordableEvents = ['created', 'updated', 'deleted'];

    /**
     * Boot the trait
     */
    public static function bootRecordsActivity(): void
    {
        foreach (self::recordableEvents() as $event)
        {
            static::$event(static function ($model) use ($event)
            {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated')
            {
                static::updating(static function ($model){
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * @return array|mixed
     */
    public static function recordableEvents()
    {
        return static::$recordableEvents ?? self::$defaultRecordableEvents;
    }

    protected function activityDescription ($description): string
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    public function recordActivity($description): void
    {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,
            'project_id'=>class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'description' => $description,
            'changes' => $this->getActivityChanges()
        ]);
    }

    protected function getActivityChanges()
    {
        return $this->wasChanged() ? [
            'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()),'updated_at'),
            'after' => Arr::except($this->getChanges(),'updated_at')
        ] : null;
    }

    public function activity()
    {
        return $this->morphMany(Activity::class,'subject')->latest();
    }
}
