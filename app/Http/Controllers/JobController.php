<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Http\Resources\JobCollection;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;

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

    public function store(StoreJobRequest $request)
    {
        $validated = $request->validated();

        $job = Job::create($validated);

        return new JobResource($job);

    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $validated = $request->validated();

        $job->update($validated);

        return new JobResource($job);
    }

    public function destroy(Request $request, Job $job)
    {
        $job->delete();

        return response()->noContent();
    }
}
