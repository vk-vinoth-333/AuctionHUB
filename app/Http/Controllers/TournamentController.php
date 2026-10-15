<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Tournament;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['tournament-list', 'tournament-create', 'tournament-edit', 'tournament-delete']);

        try {

            $tournaments = Tournament::whereNull('deleted_at')->get();
            return view('tournaments.index', compact('tournaments'));

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ResponseService::noPermissionThenRedirect('tournament-create');

        $loggedUser = Auth::user();
        $admin = Admin::findOrFail($loggedUser->id);

        if ($admin->hasRole('Admin') && $admin->id == 1) {
            $organizers = Admin::where('status', 1)->get();
        } else {
            $organizers = Admin::where('id', $loggedUser->id)->where('status', 1)->get();
        }
        return view('tournaments.create', compact('organizers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ResponseService::noPermissionThenRedirect('tournament-create');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_code' => 'required|string|max:255',
            'organizer_id' => 'required|exists:admin,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_teams' => 'required|integer|min:0',
            'venue' => 'required|string',
            'city' => 'required|string',
            'pr_amount' => 'required_unless:is_pr_free,on|nullable|numeric|min:0',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator->errors())
                ->withInput();
        }

        $name = trim($request->name);
        $shortCode = trim($request->short_code);
        $nameExists = Tournament::where('name', $name)->exists();
        $shortCodeExists = Tournament::where('short_code', $shortCode)->exists();

        if ($nameExists || $shortCodeExists) {

            $errors = [];

            if ($nameExists) {
                $errors['name'] = 'Tournament name already exists.';
            }

            if ($shortCodeExists) {
                $errors['short_code'] = 'Short code already exists.';
            }

            return back()->withErrors($errors)->withInput();
        }

        // dd("done");

        DB::beginTransaction();

        try {

            $tournament = new Tournament();
            $tournament->name = $request->name;
            $tournament->short_code = $request->short_code;
            $tournament->description = $request->description;
            $tournament->start_date = $request->start_date;
            $tournament->end_date = $request->end_date;
            $tournament->venue = $request->venue;
            $tournament->city = $request->city;
            $tournament->total_teams = $request->total_teams ?? 0;
            $tournament->prize_amount = $request->prize_amount;
            $tournament->organizer_id = $request->organizer_id;
            $tournament->status = $request->has('status') ? 1 : 0;
            $tournament->is_pr_free = $request->has('is_pr_free') ? 1 : 0;
            $tournament->pr_amount = $request->pr_amount;

            if ($request->hasFile('file')) {
                $tournament->logo = compressAndUpload($request->file('file'), 'tournaments');
            } else {
                $tournament->logo = '';
            }

            $tournament->save();

            DB::commit();

            return redirect('tournaments')
                ->with('success', __('Tournament created successfully'));


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
        ResponseService::noPermissionThenRedirect('tournament-view');

        return view('tournaments.show', [
            'tournament' => Tournament::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        ResponseService::noPermissionThenRedirect('tournament-edit');

        $loggedUser = Auth::user();

        if ($loggedUser->role == 'admin') {
            $organizers = Admin::where('status', 1)->get();
        } else {
            $organizers = Admin::where('id', $loggedUser->id)->where('status', 1)->get();
        }

        return view('tournaments.edit', [
            'tournament' => Tournament::findOrFail($id)
        ], compact('organizers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        ResponseService::noPermissionThenRedirect('tournament-edit');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_code' => 'required|string|max:255',
            'organizer_id' => 'required|exists:admin,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_teams' => 'required|integer|min:0',
            'venue' => 'required|string',
            'city' => 'required|string',
            'pr_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $name = trim($request->name);
        $shortCode = trim($request->short_code);
        // dd($shortCode);
        $nameExists = Tournament::where('name', $name)->where('id', '!=', $id)->exists();
        $shortCodeExists = Tournament::where('short_code', $shortCode)->where('id', '!=', $id)->exists();

        if ($nameExists || $shortCodeExists) {

            $errors = [];

            if ($nameExists) {
                $errors['name'] = 'Tournament name already exists.';
            }

            if ($shortCodeExists) {
                $errors['short_code'] = 'Short code already exists.';
            }

            return back()->withErrors($errors)->withInput();
        }

        DB::beginTransaction();

        try {

            $tournament = Tournament::findOrFail($id);

            $tournament->update([
                'name' => $name,
                'short_code' => $shortCode,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'venue' => $request->venue,
                'city' => $request->city,
                'total_teams' => $request->total_teams,
                'prize_amount' => $request->prize_amount,
                'organizer_id' => $request->organizer_id,
                'status' => $request->has('status') ? 1 : 0,
                'is_pr_free' => $request->has('is_pr_free') ? 1 : 0,
                'pr_amount' => $request->pr_amount,
            ]);

            if ($request->hasFile('file')) {
                $tournament->logo = compressAndUpload($request->file('file'), 'tournaments');
                $tournament->save();
            }

            DB::commit();

            return redirect()->route('tournaments.index')
                ->with('success', 'Tournament updated successfully');

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
        ResponseService::noPermissionThenRedirect('tournament-delete');

        try {

            $tournament = Tournament::findOrFail($id);
            $tournament->delete();

            return redirect()->route('tournaments.index')
                ->with('success', 'Tournament deleted successfully');

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}
