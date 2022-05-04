<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResume;
use Illuminate\Http\Request;
use App\Models\Resume;

class ResumeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        $resume = json_encode(Resume::factory()->make());
        return view('resumes.create', compact('resume'));
    }
    public function store(StoreResume $request)
    {
        $data = $request->validated();
        return response()->json($data);
    }
}