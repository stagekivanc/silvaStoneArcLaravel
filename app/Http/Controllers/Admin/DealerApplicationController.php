<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealerApplication;

class DealerApplicationController extends Controller
{
    public function index()
    {
        $applications = DealerApplication::orderBy('created_at', 'desc')->paginate(20);

        return view('yonetim.bayilik.index', compact('applications'));
    }

    public function show($id)
    {
        $application = DealerApplication::findOrFail($id);

        if (!$application->is_read) {
            $application->update(['is_read' => true]);
        }

        return view('yonetim.bayilik.show', compact('application'));
    }

    public function toggleRead($id)
    {
        $application = DealerApplication::findOrFail($id);
        $application->update(['is_read' => !$application->is_read]);

        return back()->with('success', 'Okunma durumu güncellendi.');
    }

    public function destroy($id)
    {
        $application = DealerApplication::findOrFail($id);
        $application->delete();

        return redirect()->route('yonetim.bayilik.index')->with('success', 'Başvuru başarıyla silindi.');
    }
}
