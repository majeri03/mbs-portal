<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;
use App\Models\SettingModel;

class Settings extends BaseAdminController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        helper(['form', 'youtube']); // Load helper form & youtube
    }
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // PANGGIL SATPAM
        $this->restrictToAdmin();
    }
    public function index()
    {
        $data['title'] = 'Pengaturan Website';
        // Ambil semua setting jadi array ['key' => 'value']
        $data['settings'] = $this->settingModel->getSettings($this->mySchoolId);

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        // 1. Update Text Settings (Looping input post)
        $textInputs = [
            'site_name',
            'site_desc',
            'email',
            'phone',
            'address', // General
            'facebook_url',
            'instagram_url',
            'youtube_url',
            'tiktok_url', // Sosmed
            'profile_title',
            'profile_description',
            'director_name',
            'director_label',
            'profile_video_url',
            'maps_embed_url' // SECTION PROFIL
        ];

        foreach ($textInputs as $key) {
            $val = $this->request->getPost($key);
            // Cek apakah key sudah ada di DB, jika ada update, jika tidak insert
            $this->saveSetting($key, $val, 'general', $this->mySchoolId);
        }

        // 2. Handle Upload Foto Direktur
        $file = $this->request->getFile('director_photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama jika ada (opsional, butuh query tambahan)

            $newName = $file->getRandomName();
            $file->move('uploads/settings', $newName);

            // Simpan path ke DB
            $this->saveSetting('director_photo', 'uploads/settings/' . $newName, 'general', $this->mySchoolId);
        }
        $logoFields = ['site_logo', 'site_logo_2', 'site_logo_3'];

        foreach ($logoFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/logos', $newName); // Simpan di folder uploads/logos

                // Simpan path ke database setting
                $this->saveSetting($field, 'uploads/logos/' . $newName, 'branding', $this->mySchoolId);
            }
        }
        return redirect()->to('admin/settings')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    // Helper function private untuk simpan ke tabel settings
    private function saveSetting($key, $value, $group, $schoolId)
    {
        // Cek exist
        $exists = $this->settingModel->where('setting_key', $key)
            ->where('school_id', $schoolId)
            ->first();

        if ($exists) {
            $this->settingModel->update($exists['id'], ['setting_value' => $value]);
        } else {
            $this->settingModel->insert([
                'school_id'     => $schoolId,
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_group' => $group
            ]);
        }
    }
}
