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
            'title' => 'Daftar user',
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
                $btn = '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
 
                $btn .= '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\'' . url('/admin/user/' . $user->id_user . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                
                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }
}
