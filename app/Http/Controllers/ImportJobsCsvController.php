<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\JobsCsvImportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class ImportJobsCsvController extends Controller
{
    public function __construct(
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->isValid($request);
        JobsCsvImportJob::dispatch($request->file('file'), Auth::user());

        return new JsonResponse(
            ['The file has been submitted for saving.'],
            Response::HTTP_OK
        );
    }

    private function isValid(Request $request): void
    {
        $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]
        );
    }


}