<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Tournament;
use App\Models\User;
use Exception;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['team-list', 'team-create', 'team-edit', 'team-delete']);

        try {

            $teams = Team::with('tournament')->latest()->get();
            return view('teams.index', compact('teams'));

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ResponseService::noPermissionThenRedirect('team-create');

        $tournaments = Tournament::whereNull('deleted_at')->get();

        return view('teams.create', compact('tournaments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ResponseService::noPermissionThenRedirect('team-create');

        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:20',
            'owner_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())
                ->withInput();
        }

        DB::beginTransaction();

        try {

            $team = new Team();

            $team->tournament_id = $request->tournament_id;
            $team->name = $request->name;
            $team->short_name = $request->short_name;
            $team->description = $request->description;
            $team->owner_name = $request->owner_name;
            $team->contact_email = $request->contact_email;
            $team->contact_phone = $request->contact_phone;
            $team->status = $request->has('status') ? 1 : 0;

            if ($request->hasFile('file')) {
                $team->logo = compressAndUpload($request->file('file'), 'teams');
            } else {
                $team->logo = '';
            }

            $team->save();

            DB::commit();

            return redirect('teams')
                ->with('success', __('Team created successfully'));

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $team = Team::with('tournament')->findOrFail($id);

        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $tournaments = Tournament::whereNull('deleted_at')->get();

        return view('teams.edit', compact('team', 'tournaments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        ResponseService::noPermissionThenRedirect('team-edit');

        $validator = Validator::make($request->all(), [

            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:20',
            'owner_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())
                ->withInput();
        }

        DB::beginTransaction();

        try {

            $team = Team::findOrFail($id);

            $team->tournament_id = $request->tournament_id;
            $team->name = $request->name;
            $team->short_name = $request->short_name;
            $team->description = $request->description;
            $team->owner_name = $request->owner_name;
            $team->contact_email = $request->contact_email;
            $team->contact_phone = $request->contact_phone;
            $team->status = $request->has('status') ? 1 : 0;

            if ($request->hasFile('file')) {

                $team->logo = compressAndUpload($request->file('file'), 'teams');

            }

            $team->save();

            DB::commit();

            return redirect('teams')
                ->with('success', __('Team updated successfully'));

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        ResponseService::noPermissionThenRedirect('team-delete');

        try {

            $team = Team::findOrFail($id);

            $team->delete();

            return redirect('teams')
                ->with('success', __('Team deleted successfully'));

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}
