<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassDaySchedule extends Model
{
	protected $table = 'classes_days_schedules';

    protected $fillable = ['class_id', 'day_id', 'schedule_start_id', 'schedule_end_id', 'value'];

    public function classF() {
    	return $this->belongsTo('App\Classes');
    }

    public function day() {
    	return $this->belongsTo('App\Day');
    }

    public static function withClass($value)
    {
        if(!empty($value) && $value != null){
              return static::leftJoin(
                'classes',
                'classes_days_schedules.class_id', '=', 'classes.id'
              )->where('classes.user_id', $value);            
          } else {
            return static::leftJoin(
                'classes',
                'classes_days_schedules.class_id', '=', 'classes.id'
            )->leftJoin(
                'activities',
                'activities.id', '=', 'classes.activity_id'
            );
          }


    }

    public static function withClassroom($value)
    {
      return static::leftJoin(
        'classes',
        'classes_days_schedules.class_id', '=', 'classes.id'
      )->where('classes.classroom_id', $value);
      
    }



}
