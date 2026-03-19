<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function __construct(protected ClientRepository $clientRepository) {}

    // GET /api/clients
    // GET /api/clients?status=active
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status']);

        if (!empty($filters['status']) && !in_array($filters['status'], ['active', 'inactive'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid status filter. Use "active" or "inactive".',
            ], 422);
        }

        $clients = $this->clientRepository->all($filters);

        return response()->json([
            'status'  => 'success',
            'clients' => $clients,
        ]);
    }

    // POST /api/clients
    public function store(Request $request): JsonResponse
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

    // GET /api/clients/{id}
    public function show(int $id): JsonResponse
    {
        $client = $this->clientRepository->find($id);

        if (!$client) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Client not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'client' => $client,
        ]);
    }

    // PUT /api/clients/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $client = $this->clientRepository->find($id);

        if (!$client) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Client not found.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'name'   => 'sometimes|required|string|max:255',
                'email'  => [
                    'sometimes',
                    'required',
                    'email',
                    Rule::unique('clients', 'email')->ignore($id),
                ],
                'status' => ['sometimes', 'required', Rule::in(['active', 'inactive'])],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $updated = $this->clientRepository->update($id, $validated);

        return response()->json([
            'status' => 'success',
            'client' => $updated,
        ]);
    }

    // DELETE /api/clients/{id}
    public function destroy(int $id): JsonResponse
    {
        $client = $this->clientRepository->find($id);

        if (!$client) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Client not found.',
            ], 404);
        }

        $this->clientRepository->delete($id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Client deleted successfully.',
        ]);
    }

    // POST /api/clients/store-details  (Part 1 - Question 3)
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
}