<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HasilController extends Controller
{
    public function index()
    {
        $employees = User::all();
        $v1 = $v2 = $v3 = $v4 = $v5 = $v6 = 0;

        $total_normalized_score = $totalAbsensi = $totalKebersihan = $totalLoyalitas = $totalPerilaku = $totalPeringatan = $totalKinerja = 0;
        $min = $max = 1;

        foreach ($employees as $employee) {
            $employee->absensi = $this->convertToGrade($employee->absensi);
            $employee->kebersihan = $this->convertToGrade($employee->kebersihan);
            $employee->loyalitas = $this->convertToGrade($employee->loyalitas);
            $employee->perilaku = $this->convertToGrade($employee->perilaku);
            $employee->peringatan = $this->convertToGrade($employee->peringatan);
            $employee->kinerja = $this->convertToGrade($employee->kinerja);


            $max = (float) max($employee->absensi, $employee->kebersihan, $employee->loyalitas, $employee->perilaku, $employee->peringatan, $employee->kinerja);
            $min = (float) min($employee->absensi, $employee->kebersihan, $employee->loyalitas, $employee->perilaku, $employee->peringatan, $employee->kinerja);    
            $max = max(1, $max);
            $min = max(1, $min);

            // Cost & Benefit
            $absensi_cb =  $employee->absensi / max(1, $max);
            $kebersihan_cb = $employee->kebersihan / $max;
            $loyalitas_cb = $employee->loyalitas / $max;
            $perilaku_cb = $employee->perilaku / $max;
            $peringatan_cb = $min / $employee->peringatan;
            $kinerja_cb = $employee->kinerja / $max;

            $employee->absensi_normalized = number_format($this->calculateNormalizedScore($absensi_cb, 0.2), 3);
            $employee->kebersihan_normalized = number_format($this->calculateNormalizedScore($kebersihan_cb, 0.2), 3);
            $employee->loyalitas_normalized = number_format($this->calculateNormalizedScore($loyalitas_cb, 0.2), 3);
            $employee->perilaku_normalized = number_format($this->calculateNormalizedScore($perilaku_cb, 0.2), 3);
            $employee->peringatan_normalized = number_format($this->calculateNormalizedScore($peringatan_cb, 0.1), 3);
            $employee->kinerja_normalized = number_format($this->calculateNormalizedScore($kinerja_cb, 0.1), 3);

            $employee->total_normalized_score = $this->calculateTotalNormalizedScore($employee->absensi_normalized, $employee->kebersihan_normalized, $employee->loyalitas_normalized, $employee->perilaku_normalized, $employee->peringatan_normalized, $employee->kinerja_normalized);

            $totalAbsensi += $employee->absensi_normalized;
            $totalKebersihan += $employee->kebersihan_normalized;
            $totalLoyalitas += $employee->loyalitas_normalized;
            $totalPerilaku += $employee->perilaku_normalized;
            $totalPeringatan += $employee->peringatan_normalized;
            $totalKinerja += $employee->kinerja_normalized;
            
            $total_normalized_score = $employee->absensi_normalized + $employee->kebersihan_normalized + $employee->loyalitas_normalized + $employee->perilaku_normalized + $employee->peringatan_normalized + $employee->kinerja_normalized;
            
            $employee->total_normalized_score = $total_normalized_score;
        }
        
        $avgAbsensi = $totalAbsensi / count($employees);
        $avgKebersihan = $totalKebersihan / count($employees);
        $avgLoyalitas = $totalLoyalitas / count($employees);
        $avgPerilaku = $totalPerilaku / count($employees);
        $avgPeringatan = $totalPeringatan / count($employees);
        $avgKinerja = $totalKinerja / count($employees);
        
        $top3Absensi = $this->calculateTop3($employees, 'absensi_normalized');
        $top3Kebersihan = $this->calculateTop3($employees, 'kebersihan_normalized');
        $top3Loyalitas = $this->calculateTop3($employees, 'loyalitas_normalized');
        $top3Perilaku = $this->calculateTop3($employees, 'perilaku_normalized');
        $top3Peringatan = $this->calculateTop3($employees, 'peringatan_normalized');
        $top3Kinerja = $this->calculateTop3($employees, 'kinerja_normalized');
        
        $sortedEmployees = $employees->sortByDesc('total_normalized_score');
        $top3Employees = $sortedEmployees->take(3);
        
        return view('pages.hasil.index', compact('employees', 'top3Employees', 'top3Absensi', 'top3Kebersihan', 'top3Loyalitas', 'top3Perilaku', 'top3Peringatan', 'top3Kinerja', 'avgAbsensi','avgKebersihan', 'avgLoyalitas', 'avgPerilaku', 'avgPeringatan', 'avgKinerja'));
    }


    private function convertToGrade($grade)
    {
        $gradeToNumber = match($grade) {
            'A' => 100,
            'B' => 80,
            'C' => 60,
            'D' => 40,
            'E' => 20,
            default => 0,
        };

        return $gradeToNumber;
    }

    private function calculateNormalizedScore($value, $weight)
    {
        return $value * $weight;
    }

    private function calculateTotalNormalizedScore($c1, $c2, $c3, $c4, $c5, $c6): float
    {
        return $c1 + $c2 + $c3 + $c4 + $c5 + $c6;
    }

    private function calculateTop3($employees, $attribute)
    {
        $sortedEmployees = $employees->sortByDesc($attribute)->values()->all();

        $top3 = array_slice($sortedEmployees, 0, 3);

        return $top3;
    }
}
