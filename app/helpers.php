<?php

use App\Models\Departemen;

if (!function_exists('saveDepartmentName')) {
    /**
     * Helper function to save department name instead of id.
     *
     * @param string $departmentName
     * @param string|null $kodeDepartemen
     * @return Departemen
     */
    function saveDepartmentName($departmentName, $kodeDepartemen = null)
    {
        // Cek apakah departemen dengan nama ini sudah ada
        $departemen = Departemen::firstOrCreate([
            'nama_departemen' => $departmentName,
        ]);

        return $departemen; // Kembalikan objek departemen
    }
}


