<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order_index', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'procedure' => 'nullable|string',
            'download_form_link' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $request->input('order_index', 0);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan divisi berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'procedure' => 'nullable|string',
            'download_form_link' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');
        $validated['order_index'] = $request->input('order_index', 0);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan divisi berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Toggle the entire services module on/off for public site
     */
    public function toggleModule(Request $request)
    {
        \App\Models\Setting::clearCache();

        if ($request->filled('target_status')) {
            $newStatus = $request->input('target_status') === '1' ? '1' : '0';
        } else {
            $current = (string) get_setting('enable_services', '1');
            $newStatus = in_array($current, ['0', 'false', 'off', ''], true) ? '1' : '0';
        }

        \App\Models\Setting::set('enable_services', $newStatus);
        \App\Models\Setting::clearCache();

        $message = ($newStatus === '1')
            ? 'Fitur Layanan Divisi berhasil DIAKTIFKAN (ON). Modul dan menu Layanan sekarang tampil di website publik.'
            : 'Fitur Layanan Divisi berhasil DINONAKTIFKAN (OFF). Modul dan menu Layanan sekarang disembunyikan dari website publik.';

        return redirect()->back()->with('success', $message);
    }
}
