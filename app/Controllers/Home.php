<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $siswaModel = new SiswaModel();
        $page = max(1, (int) ($this->request->getVar('page') ?: 1));
        $perPage = 10;

        $data = [
            'siswa'   => $siswaModel->paginate($perPage),
            'pager'   => $siswaModel->pager,
            'page'    => $page,
            'perPage' => $perPage,
        ];

        return view('siswa_view', $data);
    }

    public function tambah()
    {
        $rules = [
            'nis'   => 'required',
            'nama'  => 'required',
            'kelas' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url());
        }

        $siswaModel = new SiswaModel();
        $siswaModel->save([
            'nis'   => $this->request->getPost('nis'),
            'nama'  => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        return redirect()->to(base_url());
    }

    public function hapus($id)
    {
        $siswaModel = new SiswaModel();
        $siswaModel->delete($id);

        return redirect()->to(base_url());
    }

    public function edit($id)
    {
        $rules = [
            'nis'   => 'required',
            'nama'  => 'required',
            'kelas' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url());
        }

        $siswaModel = new SiswaModel();
        $siswaModel->update($id, [
            'nis'   => $this->request->getPost('nis'),
            'nama'  => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        return redirect()->to(base_url());
    }
}
