<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Project;
use App\Models\Woreda;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Fetch distinct zones from projects table
        $zones = DB::table('projects')->select('zone')->distinct()->pluck('zone');

        $selectedZone = $request->zone ?? null;
        $selectedWoreda = $request->woreda ?? null;

        $query = DB::table('projects');

        if ($selectedZone) {
            $query->where('zone', $selectedZone);
        }

        if ($selectedWoreda) {
            $query->where('woreda_or_city', $selectedWoreda);
        }
        $count = $query->count();

        $reports = $query->paginate(10);
        $export = true;

        // Fetch distinct woredas for the selected zone
        $woredas = $selectedZone
            ? DB::table('projects')
            ->where('zone', $selectedZone)
            ->select('woreda_or_city')
            ->distinct()
            ->pluck('woreda_or_city')
            : collect();

        $name = $selectedZone ?? 'All Zones';

        return view('projects.index', compact(
            'reports',
            'count',
            'zones',
            'woredas',
            'export',
            'selectedZone',
            'selectedWoreda',
            'name'
        ));
    }

    // AJAX fetch for woredas based on selected zone
    public function fetchWoredas($zone)
    {
        $woredas = DB::table('projects')
            ->where('zone', $zone)
            ->select('woreda_or_city')
            ->distinct()
            ->pluck('woreda_or_city');

        return response()->json($woredas);
    }

    public function create()
    {
        // Get all unique zones
        $zones = Woreda::select('zone')
            ->whereNotNull('zone')
            ->distinct()
            ->orderBy('zone', 'asc')
            ->pluck('zone');

        return view('projects.create', compact('zones'));
    }

    // Fetch woredas for selected zone (AJAX)
    public function fetchWoreda($zone)
    {
        $woredas = Woreda::where('zone', $zone)->pluck('name');
        return response()->json($woredas);
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
    'name' => 'required|string|max:255',
    'zone' => 'required|string',
    'woreda_or_city' => 'required|string',
    'type' => 'nullable|string',
    'site' => 'nullable|string',
    'numbers' => 'nullable|integer',
    'started_year' => 'nullable|string|max:10',
    'address' => 'nullable|string',
    'progression' => 'nullable|string',
    'budget' => 'nullable|numeric',
    'community_participation' => 'nullable|numeric',
    'deployed_budget' => 'nullable|numeric',
    'total_budget' => 'nullable|numeric',
    'benefitiary' => 'nullable|integer',
    'how_many_get_job' => 'nullable|integer',
]);

    
        $zone1 = Project::create($validated);



        return redirect()->route('project.index')->with('success', 'Project Created successfully');
    }





    // Export projects data
    public function export(Request $request)
    {
        $zone = $request->zone ?? null;
        $woreda = $request->woreda ?? null;

        $date = date('d-m-Y');

        $query = DB::table('projects');

        if ($zone) $query->where('zone', $zone);
        if ($woreda) $query->where('woreda_or_city', $woreda);

        $projects = $query->get();

        return Excel::download(new ProjectsExport($projects), "ProjectsReport_{$date}.xlsx");
    }
}
