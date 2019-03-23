<?php 


namespace App;


trait RecordsActivity {

	protected static function bootRecordsActivity() {

        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function($model) use ($event) {
                $model->recordActivity($event);
            });
        }
	}

    protected static function getActivitiesToRecord(){
        return ['created'];
    }

	protected function recordActivity($event)
    {
        if(!auth()->check()) return;

        $this->activity()->create([
            'type' => $event . '_' . $this->getActivityType() ,
            'user_id' => auth()->user()->id
        ]);
    }


    protected function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }


    protected function getActivityType()
    {
        $model = strtolower((new \ ReflectionClass($this))->getShortName());
        return $model;
    }


}