<?php

namespace App\Http\Controllers;

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
}