<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    public function search(Request $request)
    {
        $routeName = $request->route()->getName();

        $query = $request->input('query'); // Get the search query
        $employees = [];

        if (empty($query)) {
            // If the search query is empty, retrieve all data
            $employees = User::all();
            $query = "";
        } else {
            // If a search query is provided, filter the results
            $employees = User::where('name', 'LIKE', "%{$query}%")->orWhere('id', 'LIKE', "%{$query}%")->get();
        }

        // Check the route name and return appropriate view
        if ($routeName === 'listkaryawansearch') {
            return view('pages.listkaryawan.index', compact('employees'));
        } elseif ($routeName === 'nilaikaryawansearch') {
            return view('pages.nilaikaryawan.index', compact('employees'));
        }
        // Fallback view if route is not recognized
        return redirect()->back()->with('success', $employees);
    }

    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        $employees = User::all();

        return view("pages.{$routeName}", compact('employees'));
    }

    public function create()
    {
        return view('pages.listkaryawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
        
        // Convert the date string to a Carbon instance
        $dobCarbon = Carbon::parse($request->dob);

        // Remove hyphens and format the date
        $pass = str_replace('-', '', $dobCarbon->format('dmY'));

        User::create([
            'name' => $request->name,
            'dob' => $dobCarbon, // Save as Carbon instance if your database field accepts it
            'role' => $request->role,
            'email' => $request->email,
            'password' => $pass,
        ]);

        return redirect()->route('listkaryawan.index')->with('success', 'Data Karyawan Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('pages.listkaryawan.edit', compact('employee'));
    }

    public function updateGrade(Request $request, $id)
    {
        $validatedData = $request->validate([
            'column' => 'required', // Add allowed columns
            'value' => 'required'
        ]);

        $employee = User::findOrFail($id);
        $msg = "Berhasil update user {$validatedData['column']} {$validatedData['value']} {$employee->name}, id {$id}";
        $employee->{$validatedData['column']} = $validatedData['value'];
        $employee->save();

        return redirect()->back()->with('success', $msg);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'role' => 'required|string|max:255',
        ]);

        $employee = User::findOrFail($id);
        $employee->update([
            'name' => $request->full_name,
            'dob' => $request->date_of_birth,
            'role' => $request->position,
        ]);

        return redirect()->route('listkaryawan.index')->with('success', 'Data Karyawan Berhasil Diperbaharui');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();
        return redirect()->route('listkaryawan.index')->with('success', 'Data Karyawan Berhasil Dihapus');
    }

    public function showAddGradeForm($id)
    {
        $employee = User::findOrFail($id);
        return view('pages.nilaikaryawan.addgrade', compact('employee'));
    }

    public function addGrade(Request $request)
    {
        $query = $request->input('query'); // Get the search query
        $employees = $results = [];
        $request->validate([
            'id' => 'required|exists:employees,id',
            'dob' => 'nullable|date',
            'role' => 'nullable|string',
            'absensi' => 'nullable|string|max:2',
            'kebersihan' => 'nullable|string|max:2',
            'loyalitas' => 'nullable|string|max:2',
            'perilaku' => 'nullable|string|max:2',
            'peringatan' => 'nullable|string|max:2',
            'kinerja' => 'nullable|string|max:2',
        ]);

        $employee = User::find($request->id);
        $employee->absensi = $request->absensi;
        $employee->kebersihan = $request->kebersihan;
        $employee->loyalitas = $request->loyalitas;
        $employee->perilaku = $request->perilaku;
        $employee->peringatan = $request->peringatan;
        $employee->kinerja = $request->kinerja;
        $employee->save();

        return redirect()->route('nilaikaryawan.index')->with('success', 'Nilai Grade Berhasil Ditambahkan');
    }
}
