<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    // Menampilkan semua pelanggan
    public function index()
    {
        $customers = User::where('role', 'pelanggan')->get();

        return response()->json([
            'message' => 'List pelanggan',
            'data' => $customers
        ]);
    }

    // Update data pelanggan
    public function update(Request $request, $id)
    {
        $customer = User::where('role', 'pelanggan')->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'string|max:255',
            'email'    => 'email|unique:users,email,' . $id,
            'username' => 'string|unique:users,username,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer->update($request->only(['name', 'email', 'username']));

        return response()->json([
            'message' => 'Pelanggan berhasil diperbarui',
            'data' => $customer
        ]);
    }

    // Hapus data pelanggan
    public function destroy($id)
    {
        $customer = User::where('role', 'pelanggan')->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Pelanggan berhasil dihapus'
        ]);
    }
}
