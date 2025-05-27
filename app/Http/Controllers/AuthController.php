<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Inscription d'un nouvel utilisateur
    public function register(Request $request)
    {
        try {
            
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
            }
    
            // Test de validation étape par étape
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'username' => 'required|string|unique:users,username|max:255',
                'password' => 'required|string|min:8',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            
            
            // Validation avec messages personnalisés
            $validator = \Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                \Log::error('Validation failed: ', $validator->errors()->toArray());
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }
            
            $validated = $validator->validated();

    
            // Hash du mot de passe
            $validated['password'] = Hash::make($validated['password']);
    
            // Gestion de l'avatar
            if ($request->hasFile('avatar')) {
                
                $file = $request->file('avatar');
                
                if (!$file->isValid()) {
                    return response()->json([
                        'error' => 'Invalid avatar file',
                        'file_error' => $file->getError()
                    ], 422);
                }
                
                try {
                    // Vérifier que le dossier existe
                    $avatarPath = storage_path('app/public/avatars');
                    if (!file_exists($avatarPath)) {
                        mkdir($avatarPath, 0755, true);
                    }
                    
                    // Créer un nom unique
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Stocker le fichier
                    $path = $file->storeAs('avatars', $filename, 'public');
                    
                    if (!$path) {
                        return response()->json(['error' => 'Failed to store avatar'], 500);
                    }
                    
                    $validated['avatar'] = $path;
                    \Log::info('Avatar stored successfully at: ' . $path);
                    
                } catch (\Exception $e) {
                    return response()->json([
                        'error' => 'Avatar upload failed',
                        'message' => $e->getMessage()
                    ], 500);
                }
            }
    
            // Création de l'utilisateur            
            $user = User::create($validated);
            
            if (!$user) {
                return response()->json(['error' => 'Failed to create user'], 500);
            }
    
            // Génération du token JWT
            
            try {
                $token = JWTAuth::fromUser($user);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Token generation failed',
                    'message' => $e->getMessage()
                ], 500);
            }
    
            \Log::info('=== REGISTRATION SUCCESS ===');
            
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $token,
            ], 201);
    
        } catch (\Exception $e) {
            
            return response()->json([
                'error' => 'Registration failed',
                'message' => $e->getMessage(),
                'debug' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }

    // Connexion d'un utilisateur
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }

        return response()->json([
            'user' => auth()->user(),
            'token' => $token,
        ]);
    }

    // Déconnexion
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Déconnexion réussie']);
    }

    // Obtenir l'utilisateur connecté
    public function me()
    {
        return response()->json(auth()->user());
    }
}