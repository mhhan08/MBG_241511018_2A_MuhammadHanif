<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (empty($arguments)) {
            return;
        }

        // ambil role dari user
        $userRole = session()->get('role');

        // Jika role nya tidak ada di dalam daftar role yang diizinkan
        if (!in_array($userRole, $arguments)) {
            // redirect ke dashboard
            return redirect()->to('dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
