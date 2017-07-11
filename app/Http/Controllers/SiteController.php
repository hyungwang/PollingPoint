<?php

namespace App\Http\Controllers;

use App\Expire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Session;
use Validator;
use App\Poll;
use App\Option;
use Auth;

class SiteController extends Controller
{
    //this controller is probably going to be the only one needed. it should be enough for the purpose of this single page site
    public function index(Poll $poll){

        $polls = Poll::all();
        $completed= $poll->completed();
        $ongoing = $poll->ongoing();
        return view('index')->withCompleted($completed)->withOngoing($ongoing);

    }

    public  function pollCreate(Request $request){

        $rules = [
            'title'=>'required|max:200',
            'options.*.name'=>'required',
            'expire'=>'required'
        ];
        if(count($request->options) > 1){
            $validator = Validator::make($request->all(), $rules);
            if($validator->passes()){
                //TODO save in database
                $poll = new Poll;
                $poll->title = $request->title;
                $poll->user_id = Auth::user()->id;
                $poll->save();

                $expire = new Expire;
                $expire->poll_id = $poll->id;
                $time = Carbon::now();
                $expire->expires = $time->addDays($request->expire);
                $expire->save();

                foreach($request->options as $opt){
                    $option = new Option;
                    $option->name = $opt['name'];
                    $option->poll_id = $poll->id;
                    $option->save();

                }
             //todo cookie creation
                Session::flash('message','Poll created successfully');
                return redirect()->route('home');
            }else{
                return redirect()->route('home')->withErrors($validator->errors()->all());
            }
        }else{
            Session::flash('error','Votable option must be more than one'.$request->options);
            return redirect()->route('home');

        }
        return $request->all();
    }

    public function vote(Request $request){

        if($request->vote){
            $opt = Option::find($request->vote);
            $opt->increment('votes');
            $poll_id = $opt->poll->id;
            if(Cookie::has('voted')){
                $cook = Cookie::get('voted');
                $cook[$poll_id] = $opt->name;
                $cookie = cookie()->forever('voted', $cook);
            }else {
                $cookie = cookie()->forever('voted', array($poll_id=>$opt->name));
            }

            return redirect()->route('home')->withCookie($cookie);
        }
    }
}
