<?php

if (!function_exists('gregorian_to_hijri')) {
    /**
     * Convert Gregorian date to Hijri date
     * 
     * @param string $date Format: Y-m-d
     * @return array ['year', 'month', 'day', 'month_name']
     */
    function gregorian_to_hijri($date)
    {
        $timestamp = strtotime($date);
        $day = date('d', $timestamp);
        $month = date('m', $timestamp);
        $year = date('Y', $timestamp);
        
        // Algorithmic conversion (simplified)
        $jd = gregoriantojd($month, $day, $year);
        
        // Hijri calculation
        $l = $jd - 1948440 + 10632;
        $n = (int)(($l - 1) / 10631);
        $l = $l - 10631 * $n + 354;
        $j = ((int)((10985 - $l) / 5316)) * ((int)((50 * $l) / 17719)) + 
             ((int)($l / 5670)) * ((int)((43 * $l) / 15238));
        $l = $l - ((int)((30 - $j) / 15)) * ((int)((17719 * $j) / 50)) - 
            ((int)($j / 16)) * ((int)((15238 * $j) / 43)) + 29;
        $m = (int)((24 * $l) / 709);
        $d = $l - (int)((709 * $m) / 24);
        $y = 30 * $n + $j - 30;
        
        $hijri_months = [
            1 => 'Muharram', 2 => 'Safar', 3 => 'Rabiul Awal', 
            4 => 'Rabiul Akhir', 5 => 'Jumadil Awal', 6 => 'Jumadil Akhir',
            7 => 'Rajab', 8 => "Sya'ban", 9 => 'Ramadan',
            10 => 'Syawal', 11 => 'Dzulqaidah', 12 => 'Dzulhijjah'
        ];
        
        return [
            'year' => $y,
            'month' => $m,
            'day' => $d,
            'month_name' => $hijri_months[$m],
            'formatted' => $d . ' ' . $hijri_months[$m] . ' ' . $y . ' H'
        ];
    }
}

if (!function_exists('get_hijri_month_name')) {
    function get_hijri_month_name($month)
    {
        $hijri_months = [
            1 => 'Muharram', 2 => 'Safar', 3 => 'Rabiul Awal', 
            4 => 'Rabiul Akhir', 5 => 'Jumadil Awal', 6 => 'Jumadil Akhir',
            7 => 'Rajab', 8 => "Sya'ban", 9 => 'Ramadan',
            10 => 'Syawal', 11 => 'Dzulqaidah', 12 => 'Dzulhijjah'
        ];
        
        return $hijri_months[$month] ?? '';
    }
}