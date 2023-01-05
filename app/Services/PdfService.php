<?php

namespace App\Services;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Post;

class PdfService
{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    // Simple table
    public function getSimpleTable($header, $data) {

        // Header
        foreach($header as $heading) {
            $this->fpdf->Cell(50,20,$heading,1);
        }
        $this->fpdf->Ln(); // Set current position

         foreach($data as $row) {
            foreach($header as $heading) {
                $this->fpdf->Cell(50, 12, $row[$heading], 1);
            }
            $this->fpdf->Ln(); // Set current position
        }

    }




    public function createPdf(Collection $posts, $header)
    {
        $this->fpdf->SetFont('Arial', '', 14);
        $this->fpdf->AddPage('L');
        $this->getSimpleTable($header,$posts);

        return $this->fpdf->Output();

    }

}
