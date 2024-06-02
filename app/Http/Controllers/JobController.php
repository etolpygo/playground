<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Http\Resources\JobCollection;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreJobRequest;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Database\Eloquent\Builder;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = QueryBuilder::for(Job::class)
            ->allowedFilters([
                AllowedFilter::exact('job_type'),
                AllowedFilter::exact('job_code'),
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    $query->where(function (Builder $query) use ($value) {
                        $filterValue = '%' . $value . '%';
                        $query->orWhere('title', 'like', $filterValue)
                            ->orWhere('description', 'like', $filterValue)
                            ->orWhere('requirements', 'like', $filterValue);
                    });
                }),
            ])
            ->defaultSort('-created_at')
            ->allowedSorts('title', 'created_at')
            ->where('accepting_applications', true)
            ->paginate(10);
        return new JobCollection($jobs);
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
