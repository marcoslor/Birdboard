<span>
    @php($after = $activity->changes['after'])
    {{trans_choice('projects.activity.'.$activity->description, count($after), ['user'=>$activity->username(), 'changed' => key($after)])}}
</span>

