<?php

namespace App\Exports;

use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IndikatorMutuExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithMapping
{

    protected $id;
    protected $tanggal;

    // make contructor untuk menerima id
    public function __construct($id, $tanggal)
    {
        $this->id = $id;
        $this->tanggal= $tanggal;
    }


    public function query()
    {
        $indikator_mutu = IndikatorMutu::find($this->id);
        $nama_unit = auth()
            ->user()
            ->unit->where('id', $indikator_mutu->unit_id)
            ->first()->nama_unit;
        $data_rekap = PengukuranMutu::with('indikator_mutu')
            ->where('tanggal_input', 'like', "%$this->tanggal%")
            ->where('indikator_mutu_id', $this->id)
            ->get();
        return $data_rekap;
    }

    public function headings(): array
    {
        return [
            'Nama Indikator',
            'Nama Numerator',
            'Nama Denumerator',
            'Tanggal Input',
            'Jumlah Numerator',
            'Jumlah Denumerator',
            'Prosentase',
        ];
    }
    public function map($data_rekap): array{
        return [
            $data_rekap->indikator_mutu->nama_indikator,
            $data_rekap->indikator_mutu->nama_numerator,
            $data_rekap->indikator_mutu->nama_denumerator,
            $data_rekap->tanggal_input,
            $data_rekap->numerator,
            $data_rekap->denumerator,
            $data_rekap->prosentase,
        ];
    }



    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event){
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }

    public function collection()
    {
        $indikator_mutu = IndikatorMutu::find($this->id);
        $nama_unit = auth()
            ->user()
            ->unit->where('id', $indikator_mutu->unit_id)
            ->first()->nama_unit;
        $data_rekap = PengukuranMutu::with('indikator_mutu')
            ->where('tanggal_input', 'like', "%$this->tanggal%")
            ->where('indikator_mutu_id', $this->id)
            ->get();
        return $data_rekap;
    }


}
