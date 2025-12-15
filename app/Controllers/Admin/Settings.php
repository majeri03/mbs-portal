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

            // A. Ambil data lama dari database
            $oldData = $this->settingModel->where('setting_key', 'director_photo')
                ->where('school_id', $this->mySchoolId)
                ->first();

            // B. Cek & Hapus file lama jika ada
            if ($oldData && !empty($oldData['setting_value']) && file_exists($oldData['setting_value'])) {
                unlink($oldData['setting_value']);
            }

            // C. Upload file baru
            $newName = $file->getRandomName();
            $file->move('uploads/settings', $newName);

            // D. Simpan path baru
            $this->saveSetting('director_photo', 'uploads/settings/' . $newName, 'general', $this->mySchoolId);
        }
        $logoFields = ['site_logo', 'site_logo_2', 'site_logo_3'];

        foreach ($logoFields as $field) {
            $fileLogo = $this->request->getFile($field);
            if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {

                // A. Ambil data lama
                $oldLogo = $this->settingModel->where('setting_key', $field)
                    ->where('school_id', $this->mySchoolId)
                    ->first();

                // B. Hapus file lama
                if ($oldLogo && !empty($oldLogo['setting_value']) && file_exists($oldLogo['setting_value'])) {
                    unlink($oldLogo['setting_value']);
                }

                // C. Upload baru
                $newLogoName = $fileLogo->getRandomName();
                $fileLogo->move('uploads/logos', $newLogoName);

                $this->saveSetting($field, 'uploads/logos/' . $newLogoName, 'branding', $this->mySchoolId);
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
    // Hapus Logo via AJAX
    public function deleteLogo()
    {
        $logoField = $this->request->getPost('logo_field');
        $allowedFields = ['site_logo', 'site_logo_2', 'site_logo_3', 'director_photo'];

        if (!in_array($logoField, $allowedFields)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid field']);
        }

        // Ambil data logo dari database
        $logo = $this->settingModel->where('setting_key', $logoField)
            ->where('school_id', $this->mySchoolId)
            ->first();

        if ($logo && !empty($logo['setting_value'])) {
            // Hapus file fisik
            if (file_exists($logo['setting_value'])) {
                unlink($logo['setting_value']);
            }

            // Update database jadi kosong
            $this->settingModel->update($logo['id'], ['setting_value' => '']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Logo berhasil dihapus']);
    }
}
