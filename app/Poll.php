<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    //
    public  function user(){
        return $this->belongsTo(User::class);
    }

    public function options(){
        return $this->hasMany(Option::class);
    }

    public  function expires(){
        return $this->hasOne(Expire::class);
    }

    public function completed(){
        // the commented code works but is a little bit too cumbersome to understand
        $poll = Poll::with('options')->whereHas('expires', function($q){
            $q->where('expires', '<', Carbon::now());
        })->orderBy('created_at','desc')->simplePaginate(5);
        return $poll;
/*
        $time = Carbon::now();
        $completed= Expire::where($time, '>','expires')->get();
        $completed = $completed->pluck('poll_id')->toArray();

        $comp = $this->find($completed);
        return $comp;
*/
      /*
        $testing = Poll::whereHas('expires', function($query){
            $query->where('expires', '<', Carbon::now());
        })->get();
        return $testing;
      */
      //  return Expire::where('expires','<',Carbon::now())->get();
    }

    public  function ongoing(){
        // the commented code works but is a little bit too cumbersome to understand
        $poll = Poll::with('options')->whereHas('expires', function($q){
            $q->where('expires', '>', Carbon::now());
        })->orderBy('created_at','desc')->simplePaginate(5);
        return $poll;
/*
        $time = Carbon::now();
        $ongoing= Expire::where($time, '<','expires')->get();
        $ongoing = $ongoing->pluck('poll_id')->toArray();

       $comp = $this->find($ongoing);
        return $comp;
*/
        /*
        $testing = Poll::whereHas('expires', function($query){
            $query->where('expires', '>', Carbon::now());
        })->get();
        return $testing;
        */
        // return Expire::where('expires','>',Carbon::now())->get();
    }
}
