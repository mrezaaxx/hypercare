<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function index()
    {
        $beds = Bed::with('room')->paginate(10);
        return view('beds.index', compact('beds'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('beds.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_number' => 'required|string|max:50',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Bed::create($validated);

        return redirect()->route('beds.index')->with('success', 'Bed created successfully.');
    }

    public function edit(Bed $bed)
    {
        $rooms = Room::all();
        return view('beds.edit', compact('bed', 'rooms'));
    }

    public function update(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_number' => 'required|string|max:50',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $bed->update($validated);

        return redirect()->route('beds.index')->with('success', 'Bed updated successfully.');
    }

    public function destroy(Bed $bed)
    {
        $bed->delete();
        return redirect()->route('beds.index')->with('success', 'Bed deleted successfully.');
    }
}
