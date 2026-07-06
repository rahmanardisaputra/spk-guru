<?php

namespace App\Helpers;

class SemesterHelper
{
    public static function listSemesters()
    {
        return [
            '20241' => 'Ganjil 2024-2025',
            '20242' => 'Genap 2024-2025',
            '20251' => 'Ganjil 2025-2026',
            '20252' => 'Genap 2025-2026',
            '20261' => 'Ganjil 2026-2027',
            '20262' => 'Genap 2026-2027',
        ];
    }

    public static function getName($code)
    {
        $list = self::listSemesters();
        return $list[$code] ?? $code;
    }
}
