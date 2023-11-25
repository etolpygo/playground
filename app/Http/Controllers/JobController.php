<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Http\Resources\JobCollection;

class JobController extends Controller
{
    public function index(Request $request)
    {
        return new JobCollection(Job::where('accepting_applications', true)->get());
    }

    public function show(Request $request, Job $job)
    {
        return new JobResource($job);
    }
}
