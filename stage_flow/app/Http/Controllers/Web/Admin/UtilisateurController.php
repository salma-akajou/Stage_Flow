<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\UtilisateurService;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    protected UtilisateurService $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'statut', 'role']);
        $users = $this->utilisateurService->listUsers($filters, 9);
        
        if ($request->ajax()) {
            return view('components.admin.users.table', compact('users'))->render();
        }

        return view('admin.users.index', compact('users'));
    }

    public function show(int $id)
    {
        $user = $this->utilisateurService->getUserDetails($id);
        return response()->json($user);
    }

    public function suspend($id)
    {
        $this->utilisateurService->suspendUser($id);
        return back()->with('success', 'Utilisateur suspendu avec succès.');
    }

    public function reactivate($id)
    {
        $this->utilisateurService->reactivateUser($id);
        return back()->with('success', 'Utilisateur réactivé avec succès.');
    }

    public function destroy($id)
    {
        $this->utilisateurService->deleteUser($id);
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
