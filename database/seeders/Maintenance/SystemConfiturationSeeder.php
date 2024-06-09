<?php

namespace Database\Seeders\Maintenance;

use App\Models\Maintenance\SystemConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemConfiturationSeeder extends Seeder
{
    public function run()
    {
        $sysconf = new SystemConfiguration();
        $sysconf->code = 'rumus_ukom';
        $sysconf->name = 'Parameter Rumus Ukom';
        $sysconf->property = ((object) $this->rumus_ukom());
        $sysconf->type = 'static';
        $sysconf->validation = '/^(?:[-+*\/<>()]\s*\d+(?:\.\d+)?(?:\s*\(?\s*|\s*\)?)\s*(?:\s|$)|(?:[-+*\/<>()]\s*\(\s*\d+(?:\.\d+)?(?:\s*|\s*\)?\s*)))+$/';
        $sysconf->save();

        $sysconf = new SystemConfiguration();
        $sysconf->code = 'review_akp';
        $sysconf->name = 'Parameter Review AKP';
        $sysconf->property = ((object) $this->review_akp());
        $sysconf->type = 'static';
        $sysconf->validation = '/^(true|false)$/';
        $sysconf->save();

        $sysconf = new SystemConfiguration();
        $sysconf->code = 'file_persyaratan_ukom';
        $sysconf->name = 'Parameter Dokumen Ukom';
        $sysconf->property = ((object) $this->file_persyaratan_ukom());
        $sysconf->type = 'dynamic';
        $sysconf->validation = '/^(?!^[0-9])[a-zA-Z0-9\s]*$/';
        $sysconf->save();

        $sysconf = new SystemConfiguration();
        $sysconf->code = 'file_persyaratan_formasi';
        $sysconf->name = 'Parameter Data Dukung Formasi';
        $sysconf->property = ((object) $this->file_persyaratan_formasi());
        $sysconf->type = 'dynamic';
        $sysconf->validation = '/^(?!^[0-9])[a-zA-Z0-9\s]*$/';
        $sysconf->save();
    }

    private function review_akp()
    {
        return (object) [
            "rekan" => (object) [
                "value" => "false",
                "input_type" => "checkbox"
            ]
        ];
    }

    private function file_persyaratan_formasi()
    {
        return (object) [
            "pendaftaran" => (object) [
                "values" => [
                    "Dokumen ABK",
                    "Dokumen ABB",
                    "Dokumen ABTO",
                    "Dokumen Alibaba"
                ],
                "input_type" => "text"
            ]
        ];
    }

    private function file_persyaratan_ukom()
    {
        return (object) [
            "external" => (object) [
                "promosi" => (object) [
                    "values" => [
                        "Dokumen Perserahan",
                        "Dokumen Mana Tahu",
                        "Dokumen Tertentu"
                    ],
                    "input_type" => "text"
                ],
                "perpindahan" => (object) [
                    "values" => [
                        "Dokumen Perserahan"
                    ],
                    "input_type" => "text"
                ],
                "kenaikan_jenjang" => (object) [
                    "values" => [
                        "Dokumen Mana Tahu",
                        "Dokumen Tertentu"
                    ],
                    "input_type" => "text"
                ]
            ],
            "internal" => (object) [
                "promosi" => (object) [
                    "values" => [
                        "Dokumen Perserahan"
                    ],
                    "input_type" => "text"
                ],
                "perpindahan" => (object) [
                    "values" => [
                        "Dokumen Mana Tahu"
                    ],
                    "input_type" => "text"
                ],
                "kenaikan_jenjang" => (object) [
                    "values" => [
                        "Dokumen Tertentu"
                    ],
                    "input_type" => "text"
                ]
            ]
        ];
    }

    private function rumus_ukom()
    {
        return [
            'nb_cat' => [
                'analis_perdagangan' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'negosiator_perdagangan' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'pemeriksa_perdagangan_berjangka_komoditi' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'penera' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'pengamat_tera' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'pengawas_kemetrologian' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'pengawas_perdagangan' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'penguji_mutu_barang' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'penjamin_mutu_produk' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'pranata_lab_kemetrologian' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ],
                'analis_investigasi_dan_pengamanan_perdagangan' => [
                    'utama' => '* (20 / 100)',
                    'madya' => '* (20 / 100)',
                    'muda' => '* (20 / 100)',
                    'pertama' => '* (20 / 100)',
                    'penyelia' => '* (20 / 100)',
                    'mahir' => '* (20 / 100)',
                    'terampil' => '* (20 / 100)',
                    'pemula' => '* (20 / 100)',
                ]
            ],
            'nb_wawancara' => [
                'analis_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'negosiator_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pemeriksa_perdagangan_berjangka_komoditi' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'penera' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '',
                    'mahir' => '* 0.20',
                    'terampil' => '* 0.20',
                    'pemula' => '',
                ],
                'pengamat_tera' => [
                    'utama' => '',
                    'madya' => '',
                    'muda' => '',
                    'pertama' => '',
                    'penyelia' => '',
                    'mahir' => '* 0.20',
                    'terampil' => '* 0.20',
                    'pemula' => '',
                ],
                'pengawas_kemetrologian' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pengawas_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'penguji_mutu_barang' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '* 0.30',
                    'mahir' => '* 0.30',
                    'terampil' => '* 0.30',
                    'pemula' => '',
                ],
                'penjamin_mutu_produk' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pranata_lab_kemetrologian' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'analis_investigasi_dan_pengamanan_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ]
            ],
            'nb_seminar' => [
                'analis_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'negosiator_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pemeriksa_perdagangan_berjangka_komoditi' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'penera' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '',
                    'mahir' => '* 0.20',
                    'terampil' => '* 0.20',
                    'pemula' => '',
                ],
                'pengamat_tera' => [
                    'utama' => '',
                    'madya' => '',
                    'muda' => '',
                    'pertama' => '',
                    'penyelia' => '',
                    'mahir' => '* 0.20',
                    'terampil' => '* 0.20',
                    'pemula' => '',
                ],
                'pengawas_kemetrologian' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pengawas_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'penguji_mutu_barang' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '* 0.30',
                    'mahir' => '* 0.30',
                    'terampil' => '* 0.30',
                    'pemula' => '',
                ],
                'penjamin_mutu_produk' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pranata_lab_kemetrologian' => [
                    'utama' => '',
                    'madya' => '* 0.20',
                    'muda' => '* 0.20',
                    'pertama' => '* 0.20',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'analis_investigasi_dan_pengamanan_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ]
            ],
            'nb_praktik' => [
                'analis_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'negosiator_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pemeriksa_perdagangan_berjangka_komoditi' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'penera' => [
                    'utama' => '',
                    'madya' => '* 0.60',
                    'muda' => '* 0.60',
                    'pertama' => '* 0.60',
                    'penyelia' => '',
                    'mahir' => '* 0.60',
                    'terampil' => '* 0.60',
                    'pemula' => '',
                ],
                'pengamat_tera' => [
                    'utama' => '',
                    'madya' => '',
                    'muda' => '',
                    'pertama' => '',
                    'penyelia' => '',
                    'mahir' => '* 0.60',
                    'terampil' => '* 0.60',
                    'pemula' => '',
                ],
                'pengawas_kemetrologian' => [
                    'utama' => '',
                    'madya' => '* 0.60',
                    'muda' => '* 0.60',
                    'pertama' => '* 0.60',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pengawas_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'penguji_mutu_barang' => [
                    'utama' => '',
                    'madya' => '* 0.30',
                    'muda' => '* 0.30',
                    'pertama' => '* 0.30',
                    'penyelia' => '* 0.50',
                    'mahir' => '* 0.50',
                    'terampil' => '* 0.50',
                    'pemula' => '',
                ],
                'penjamin_mutu_produk' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'pranata_lab_kemetrologian' => [
                    'utama' => '',
                    'madya' => '* 0.60',
                    'muda' => '* 0.60',
                    'pertama' => '* 0.60',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ],
                'analis_investigasi_dan_pengamanan_perdagangan' => [
                    'utama' => '',
                    'madya' => '* 0.40',
                    'muda' => '* 0.40',
                    'pertama' => '* 0.40',
                    'penyelia' => '',
                    'mahir' => '',
                    'terampil' => '',
                    'pemula' => '',
                ]
            ],
            'nilai_ukt' => '* (60/100)',
            'ukmsk' => '* (40/100)',
        ];
    }
}
