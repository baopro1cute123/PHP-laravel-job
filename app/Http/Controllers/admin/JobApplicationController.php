<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(){
        $jobs = JobApplication::orderBy('created_at','DESC')->with('user','job', 'employer')->paginate(10);
        return view('admin.jobApplications.list',[
            'jobs' => $jobs
        ]);
    }
    public function destroy(Request $request){
        $id = $request->id;
        
        $job = JobApplication::find($id);
    
        if ($job === null) {
            session()->flash('error', 'Job delete error!');
            return response()->json([
                'status' => false,
            ]);
        }
    
        $job->delete();
        session()->flash('success', 'Job deleted successfully!');
        return response()->json([
            'status' => true,
        ]);
    }
}