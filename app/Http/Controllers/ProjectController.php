<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Project;
use App\Http\Resources\ProjectResource;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = ProjectResource::collection(Project::with('skill')->get());
        return inertia::render('Projects/Index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills=Skill::all();
       return inertia::render('Projects/create',compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'skill_id'=>['required'],
            'name'=>['required','min:3'],
            'image'=>['required','image'],
            'project_url'=>['required','min:3']

        ]);
        if ($request->hasFile('image')) {
            // Store the image in the 'Skills' directory inside the 'storage/app/public' directory
            $imagePath = $request->file('image')->store('Projects', 'public');

            // Create a new skill with the name and stored image path
            Project::create([
                'name' => $request->name,
                'image' => $imagePath, // Store the relative path to the image
                'skill_id'=>$request->skill_id,
                'project_url'=>$request->project_url
            ]);

            return Redirect::route('Projects.index')->with('message', 'Project created successfully.');
        }
        return  Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $skills = Skill::all();
    $project = Project::find($id);

    return Inertia::render('Projects/edit', compact('project', 'skills'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        // Find the project by ID or fail
        $project = Project::findOrFail($id);
        // Validate the incoming request data
        $validated=  $request->validate([
            'name' => ['required', 'min:3'],
            'project_url' => ['required'],
            'skill_id' => ['required'],
            'image' => ['nullable', 'image', 'max:2048'], // Validate image if provided
        ]);


        // If an image is uploaded, delete the old one and store the new one
        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete($project->image); // Delete the old image
            }
            $project->image = $request->file('image')->store('projects'); // Store new image
        }

        // Update the project
        $isUpdated =$project->update([
            'name' => $request->name,
            'project_url' => $request->project_url,
            'skill_id' => $request->skill_id,
            'image' => $project->image, // Image remains the same if no new image is uploaded
        ]);

        return Redirect::route('Projects.index')->with('message', 'Project updated successfully.');
    } catch (\Throwable $th) {
        \Log::error('Project update failed:', ['error' => $th->getMessage()]);
        return Redirect::back()->withErrors('Failed to update project. Please try again.')->withInput();
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->image) {
            Storage::delete($project->image);
        }

        $project->delete();

        return Redirect::back()->with('message', 'Project deleted successfully.');
    }
}
