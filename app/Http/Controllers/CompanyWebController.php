<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Rules\UniqueCompanyRule;

class CompanyWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::where('user_id', auth()->id());

        // Búsqueda por razón social
        if ($request->has('search') && $request->search) {
            $query->where('razon_social', 'LIKE', '%' . $request->search . '%');
        }

        $companies = $query->orderBy('created_at', 'desc')->paginate(4);
        $search = $request->search;

        return view('companies.index', compact('companies', 'search'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        try {
            // Validación básica
            $data = $request->validate([
                'razon_social' => 'required|string|max:255',
                'ruc' => 'required|string|size:11',
                'direccion' => 'required|string|max:255',
                'production' => 'nullable',
                'logo' => 'nullable|file|max:2048',
                'certificado' => 'required|file|max:2048',
            ]);

            // Verificar que se recibió el certificado
            if (!$request->hasFile('certificado')) {
                return back()->withErrors(['certificado' => 'El certificado es requerido'])->withInput();
            }

            // Procesar logo si existe
            if ($request->hasFile('logo')) {
                $data['logo_path'] = $request->file('logo')->store('logos', 'public');
            }

            // Procesar certificado
            $data['cert_path'] = $request->file('certificado')->store('certificates', 'public');

            // Asignar datos adicionales
            $data['user_id'] = auth()->id();
            $data['sol_user'] = auth()->user()->email;
            $data['sol_pass'] = 'default_password';
            $data['client_id'] = null;
            $data['client_secret'] = null;
            $data['production'] = $request->has('production') ? 1 : 0;

            // Crear la empresa
            $company = Company::create($data);

            return redirect()->route('companies.index')->with([
                'status' => 'created',
                'message' => 'Empresa registrada exitosamente'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $company = Company::where('user_id', auth()->id())->findOrFail($id);
        return view('companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::where('user_id', auth()->id())->findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::where('user_id', auth()->id())->findOrFail($id);

        $data = $request->validate([
            'razon_social' => 'required|string|max:255',
            'ruc' => 'required|string|size:11',
            'direccion' => 'required|string|max:255',
            'production' => 'nullable',
            'logo' => 'nullable|file|max:2048',
            'certificado' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('certificado')) {
            if ($company->cert_path) {
                Storage::disk('public')->delete($company->cert_path);
            }
            $data['cert_path'] = $request->file('certificado')->store('certificates', 'public');
        }

        $data['production'] = $request->has('production') ? 1 : 0;

        $company->update($data);

        return redirect()->route('companies.index')->with([
            'status' => 'updated',
            'message' => 'Empresa actualizada exitosamente'
        ]);
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        
        if (!$company) {
            return redirect()->route('companies.index')->with([
                'status' => 'error',
                'message' => 'Empresa no encontrada'
            ]);
        }

        if ($company->user_id !== auth()->id()) {
            return redirect()->route('companies.index')->with([
                'status' => 'error',
                'message' => 'No tienes permisos para eliminar esta empresa'
            ]);
        }

        if ($company->logo_path) {
            Storage::disk('public')->delete($company->logo_path);
        }
        if ($company->cert_path) {
            Storage::disk('public')->delete($company->cert_path);
        }

        $company->delete();

        return redirect()->route('companies.index')->with([
            'status' => 'deleted',
            'message' => 'Empresa eliminada exitosamente'
        ]);
    }
}