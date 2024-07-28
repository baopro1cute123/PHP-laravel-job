<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    public function index(Request $request) {

        $categories = Category::where('status',1)->get();
        $jobTypes = JobType::where('status',1)->get();

        $jobs = Job::where('status', 1);

        //search keyword
        
        if(!empty($request->keywords)){
            $jobs = $jobs->where(function($query) use($request){
                $query->orWhere('title','like','%' .$request->keyword.'%');
                $query->orWhere('keyword','like','%' .$request->keyword.'%');
            });
        }

        //search keyword
        if(!empty($request->location)){
            $jobs = $jobs->where('location', $request->location);
        }
        //search category
        if(!empty($request->category)){
            $jobs = $jobs->where('category_id', $request->category);
        }

        //search jobType
        $jobTypeArray = [];

        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }
        
         //search experience
        if(!empty($request->experience)){
            $jobs = $jobs->where('experience', $request->experience);
        }

        // if(!empty($request->experience)){
        //     $jobs = $jobs->where('experience', $request->experience);
        // }
        
        $jobs = $jobs->with(['jobType','category']);
        
        if($request->sort == '0') {
            $jobs= $jobs->orderBy('created_at', 'ASC');

        }else{
            $jobs= $jobs->orderBy('created_at', 'DESC');
        }
        
        $jobs= $jobs->paginate(9);
        
        
        
        return view('front.jobs',[
            'categories'=> $categories,
            'jobTypes'=>$jobTypes,
            'jobs'=>$jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }

    public function detail($id){
        
        $job = Job::where(['id'=> $id, 'status'=> 1])
        ->with(['jobType', 'category'])->first();
        if($job == null){
            abort(404);
        }
        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        
        return view('front.jobDetail',[
            'job'=> $job,
            'count' => $count
        ]);
    }

    public function applyJob(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:jobs,id',
    ]);

    $id = $request->id;
    $job = Job::find($id);

    if ($job == null) {
        session()->flash('error', 'Job does not exist');
        return response()->json([
            'status' => false,
            'message' => 'Job does not exist'
        ]);
    }

    $employer_id = $job->user_id;

    if (Auth::check() && $employer_id == Auth::user()->id) {
        session()->flash('error', 'You cannot apply for your own job');
        return response()->json([
            'status' => false,
            'message' => 'You cannot apply for your own job'
        ]);
    }

    $jobApplicationCount = JobApplication::where([
        'user_id' => Auth::user()->id,
        'job_id' => $id
    ])->count();

    if ($jobApplicationCount > 0) {
        session()->flash('error', 'You have already applied for this job');
        return response()->json([
            'status' => false,
            'message' => 'You have already applied for this job'
        ]);
    }

    $application = new JobApplication();
    $application->job_id = $id;
    $application->user_id = Auth::user()->id;
    $application->employer_id = $employer_id;
    $application->applied_date = now();
    $application->save();

    // send email
    $employer = User::find($employer_id);
    $mailData = [
        'employer' => $employer,
        'user' => Auth::user(),
        'job' => $job,
    ];
    Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

    session()->flash('success', 'You have successfully applied');
    return response()->json([
        'status' => true,
        'message' => 'You have successfully applied'
    ]);
}

    public function saveJob(Request $request){

        $id = $request->id;
        $job = Job::find($id);
        if($job == null){
            session()->flash('error','Job not found');

            return response()->json([
                'status' => false,
            ]);
        }
        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        if($count > 0) {
            session()->flash('error','You already applied on this job');

            return response()->json([
                'status' => false,
            ]);
        }
        $savedJob = new SavedJob;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();

        session()->flash('success','You have successfully saved the job');

            return response()->json([
                'status' => true,
            ]);
    }
}