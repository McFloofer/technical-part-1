<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    public function all(array $filters = [])
    {
        $query = Client::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function find(int $id): ?Client
    {
        return Client::find($id);
    }

    public function update(int $id, array $data): ?Client
    {
        $client = $this->find($id);

        if (!$client) {
            return null;
        }

        $client->update($data);

        return $client->fresh();
    }

    public function delete(int $id): bool
    {
        $client = $this->find($id);

        if (!$client) {
            return false;
        }

        return (bool) $client->delete();
    }
}