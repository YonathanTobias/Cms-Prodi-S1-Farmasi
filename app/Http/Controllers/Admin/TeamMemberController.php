<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = TeamMember::query();

        // Filter tipe (dosen / tendik)
        if ($request->filled('type') && in_array($request->type, ['dosen', 'tendik'])) {
            $query->where('type', $request->type);
        }

        // Pencarian nama, NIDN/NIP, atau keahlian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('identifier', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('expertise', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('order_index', 'asc')->orderBy('id', 'asc')->get();

        $totalMembers = TeamMember::count();
        $totalDosen = TeamMember::where('type', 'dosen')->count();
        $totalTendik = TeamMember::where('type', 'tendik')->count();

        return view('admin.team.index', compact('members', 'totalMembers', 'totalDosen', 'totalTendik'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'title_degree' => 'nullable|string|max:100',
            'identifier' => 'nullable|string|max:100',
            'position' => 'required|string|max:150',
            'type' => 'required|in:dosen,tendik',
            'expertise' => 'nullable|string|max:255',
            'academic_rank' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:30',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = \App\Services\ImageService::uploadAndOptimize($request->file('photo'), 'team', 800, 85);
        }

        $validated['order_index'] = $request->input('order_index', 0);
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Data Dosen / Tendik berhasil ditambahkan.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'title_degree' => 'nullable|string|max:100',
            'identifier' => 'nullable|string|max:100',
            'position' => 'required|string|max:150',
            'type' => 'required|in:dosen,tendik',
            'expertise' => 'nullable|string|max:255',
            'academic_rank' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:30',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($team->photo && !str_starts_with($team->photo, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $team->photo));
            }
            $validated['photo'] = \App\Services\ImageService::uploadAndOptimize($request->file('photo'), 'team', 800, 85);
        }

        $validated['order_index'] = $request->input('order_index', 0);
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        $team->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Data Dosen / Tendik berhasil diperbarui.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo && !str_starts_with($team->photo, 'http')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $team->photo));
        }
        $team->delete();

        return back()->with('success', 'Data personil berhasil dihapus.');
    }

    /**
     * Update organization chart image and display mode
     */
    public function updateChart(Request $request)
    {
        $request->validate([
            'organization_chart' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'organization_display_mode' => 'required|in:both,tab,chart_only,members_only',
        ]);

        if ($request->hasFile('organization_chart')) {
            $oldChart = \App\Models\Setting::get('organization_chart_image');
            if ($oldChart && !str_starts_with($oldChart, 'http')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldChart));
            }
            $chartPath = \App\Services\ImageService::uploadAndOptimize($request->file('organization_chart'), 'organization', 2000, 88);
            \App\Models\Setting::set('organization_chart_image', $chartPath);
        }

        \App\Models\Setting::set('organization_display_mode', $request->input('organization_display_mode', 'both'));
        \App\Models\Setting::clearCache();

        return redirect()->route('admin.team.index')->with('success', 'Bagan struktur organisasi dan mode tampilan berhasil diperbarui.');
    }

    /**
     * Remove organization chart image
     */
    public function removeChart()
    {
        $oldChart = \App\Models\Setting::get('organization_chart_image');
        if ($oldChart && !str_starts_with($oldChart, 'http')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $oldChart));
        }
        \App\Models\Setting::set('organization_chart_image', '');
        \App\Models\Setting::clearCache();

        return redirect()->route('admin.team.index')->with('success', 'Gambar bagan struktur organisasi berhasil dihapus.');
    }
}
