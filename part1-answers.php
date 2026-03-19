<?php

/*

 PART 1 — LARAVEL CODING QUESTIONS

*/

// Question 1 — Eloquent Query
// Get all users whose status is 'active', ordered by created_at descending.

$users = \App\Models\User::where('status', 'active')
    ->orderBy('created_at', 'desc')
    ->get();


// Question 2 — Routing
// Route /dashboard to DashboardController@index, accessible only to authenticated users.
//
// Middleware used: 'auth'
// Why: The built-in `auth` middleware checks if the user has an active
// authenticated session. If not, it redirects them to the login page.
// This protects the dashboard from being accessed by guests.

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


// Question 3 — storeClientDetails()
// Full implementation is in app/Http/Controllers/ClientController.php
// Below is the standalone snippet for reference.

public function storeClientDetails(Request $request): JsonResponse
{
    try {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:clients,email',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Validation failed.',
            'errors'  => $e->errors(),
        ], 422);
    }

    $client = $this->clientRepository->create($validated);

    return response()->json([
        'status' => 'success',
        'client' => $client,
    ], 201);
}