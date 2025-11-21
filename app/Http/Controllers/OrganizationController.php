<?php
namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
class OrganizationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');

    //     $this->middleware('permission:organization-list|organization-create|organization-edit|organization-delete', ['only' => ['index', 'store']]);

    //     $this->middleware('permission:organization-create', ['only' => ['create', 'store']]);

    //     $this->middleware('permission:organization-edit', ['only' => ['edit', 'update']]);

    //     $this->middleware('permission:organization-delete', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {
        $organizations = Organization::all();
        return view('organization', compact('organizations'));
    }
}