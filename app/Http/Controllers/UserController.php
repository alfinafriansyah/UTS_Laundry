<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    // Menampilkan Halaman Awal User
    public function index()
    {
        $activeMenu = 'user';

        $page = (object) [
            'title' => 'User',
            'card' => 'Daftar user yang terdaftar',
        ];

        // Mengambil semua data role dari tabel users   
        $roles = UserModel::select('role')->distinct()->pluck('role');

        return view('admin.user.index', ['activeMenu' => $activeMenu, 'page' => $page, 'roles' => $roles]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('id_user', 'nama_user', 'username','role');

        // Filter berdasarkan role jika ada
        if ($request->has('role') && $request->role != '') {
            $users->where('role', $request->role);
        }

        return DataTables::of($users)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) { 
                $btn = '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                
                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_user' => 'required|string|min:3|max:100',
                'username' => 'required|string|max:20|unique:users,username',
                'password' => 'required|min:6',
                'role' => 'required|string|in:admin,staff',
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
        
            try {
                // Hash password sebelum disimpan
                $userData = $request->all();
                $userData['password'] = bcrypt($request->password);
                
                UserModel::create($userData);
        
                return response()->json([
                    'status' => true,
                    'message' => 'Data user berhasil disimpan',
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('admin/user');
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);

        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_user' => 'required|string|min:3|max:100',
                'username' => 'required|string|min:3|unique:users,username,' . $id . ',id_user',
                'password' => 'nullable',
                'role' => 'required|string|in:admin,staff',
            ];
            
            // Validasi input
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
        
            try {
                $user = UserModel::findOrFail($id);
                $userData = $request->except('password');
                
                // Hash password jika diisi
                if ($request->filled('password')) {
                    $userData['password'] = bcrypt($request->password);
                }
                
                $user->update($userData);
        
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }
        }
        return redirect('admin/user');
    }

    public function confirm(string $id)
    {
        $user = UserModel::find($id);

        return view('admin.user.confirm', ['user' => $user]);
    }

    public function delete(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);

            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('admin/user');
    }
}
