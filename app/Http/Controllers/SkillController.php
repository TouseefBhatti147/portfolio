<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      /*   $skills=SkillResource::collection(Skill::all());
     return Inertia::render('Skills/Index',comact('skills')); */

     $skills = SkillResource::collection(Skill::all());
     return inertia::render('Skills/Index',compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia::render('Skills/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'=>['required','image'],
            'name'=>['required','min:3']

        ]);
        if ($request->hasFile('image')) {
            // Store the image in the 'Skills' directory inside the 'storage/app/public' directory
            $imagePath = $request->file('image')->store('Skills', 'public');

            // Create a new skill with the name and stored image path
            Skill::create([
                'name' => $request->name,
                'image' => $imagePath, // Store the relative path to the image
            ]);

            return Redirect::route('Skills.index')->with('message', 'Skill created successfully.');
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
// In your controller
public function edit($id)
{
    $skill = Skill::find($id);

    if (!$skill) {
        // Handle the case where the skill is not found
        return redirect()->route('skills.index')->with('error', 'Skill not found');
    }

    return Inertia::render('Skills/edit', [
        'skill' => $skill,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the skill by ID or throw a 404 error if not found
        $skill = Skill::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'name' => ['required', 'min:3'],
            'image' => ['nullable', 'image', 'max:2048'], // Validate image if provided
        ]);

        // If a new image is uploaded, delete the old one and store the new one
        if ($request->hasFile('image')) {
            if ($skill->image) {
                Storage::delete($skill->image); // Delete the old image
            }
            $skill->image = $request->file('image')->store('skills'); // Store the new image
        }

        // Update the skill with the new name and possibly new image
        $skill->update([
            'name' => $request->name,
            'image' => $skill->image,
        ]);

        // Redirect back with a success message
        return Redirect::route('Skills.index')->with('message', 'Skill updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);

        if ($skill->image) {
            Storage::delete($skill->image);
        }

        $skill->delete();

        return Redirect::back()->with('message', 'Skill deleted successfully.');
    }

}
