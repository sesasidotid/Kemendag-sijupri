<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $this->parent();
        $this->child();
    }

    public function parent()
    {
        DB::table('tbl_menu')->insert([
            ['name' => 'Dashboard', 'code' => 'DAS_1', 'routes' => '/dashboard,/profile/**', 'created_by' => "system", 'parent_code' => null, 'idx' => 0],
        ]);
        DB::table('tbl_menu')->insert([
            ['name' => 'User', 'code' => 'USR_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
            ['name' => 'Formasi', 'code' => 'FOR_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
            ['name' => 'Maintenance', 'code' => 'MNT_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
            ['name' => 'AKP', 'code' => 'AKP_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
            ['name' => 'PAK', 'code' => 'PAK_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
            ['name' => 'UKom', 'code' => 'UKM_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
            ['name' => 'Task', 'code' => 'TSK_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
            ['name' => 'Security', 'code' => 'SEC_1', 'created_by' => "system", 'parent_code' => null, 'idx' => 1],
        ]);
    }

    public function child()
    {
        DB::table('tbl_menu')->insert([
            ['name' => 'Admin Instansi', 'code' => 'USR_2', 'created_by' => "system", 'parent_code' => "USR_1", 'routes' => "/user/admin_instansi/**,/registration/instansi/**", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Admin Unit Kerja/OPD', 'code' => 'USR_3', 'created_by' => "system", 'parent_code' => "USR_1", 'routes' => "/user/admin_unit_kerja_opd/**,/registration/pengelola/**", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'User JF', 'code' => 'USR_4', 'created_by' => "system", 'parent_code' => "USR_1", 'routes' => "/user/user_jf/**,/registration/user/**", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],

            ['name' => 'User', 'code' => 'SEC_2', 'created_by' => "system", 'parent_code' => "SEC_1", 'routes' => "/security/user/**,/registration/sijupri/**", 'lvl' => 1, 'app_code' => 'PUSBIN'],
            ['name' => 'Role', 'code' => 'SEC_3', 'created_by' => "system", 'parent_code' => "SEC_1", 'routes' => "/security/role/**", 'lvl' => 1, 'app_code' => 'PUSBIN'],

            ['name' => 'Periode', 'code' => 'UKM_2', 'created_by' => "system", 'parent_code' => "UKM_1", 'routes' => "/ukom/**,/admin/ukom/**,/user/ukom/**", 'lvl' => 1, 'app_code' => 'PUSBIN'],
            ['name' => 'Kenaikan Jenjang', 'code' => 'UKM_3', 'created_by' => "system", 'parent_code' => "UKM_1", 'routes' => "/ukom/**,/admin/ukom/**,/user/ukom/**", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Publish Hasil', 'code' => 'UKM_4', 'created_by' => "system", 'parent_code' => "UKM_1", 'routes' => "/ukom/**,/admin/ukom/**,/user/ukom/**", 'lvl' => 1, 'app_code' => 'PUSBIN'],

            ['name' => 'penera', 'code' => 'FOR_2', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/penera', 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Pengamat Tera', 'code' => 'FOR_3', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/pengamat_tera', 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Pengawas Kemetrologian', 'code' => 'FOR_4', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/pengawas_kemetrologian', 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Penguji Mutu Barang', 'code' => 'FOR_5', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/penguji_mutu_barang', 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Pengawas Perdagangan', 'code' => 'FOR_6', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/pengawas_perdagangan', 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Analis Perdagangan', 'code' => 'FOR_7', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/analis_perdagangan', 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Daftar', 'code' => 'FOR_8', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/detail/**,/formasi/data_rekomendasi_formasi,/formasi/import', 'lvl' => 1, 'app_code' => 'PUSBIN'],
            ['name' => 'Daftar', 'code' => 'FOR_9', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/data_rekomendasi_formasi,/formasi/jabatan/konfirmasi/**', 'lvl' => 1, 'app_code' => 'USER'],
            ['name' => 'Daftar', 'code' => 'FOR_10', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/data_rekomendasi_formasi', 'lvl' => 1, 'app_code' => 'USER'],
            ['name' => 'Request Formasi', 'code' => 'FOR_11', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/request_formasi/**', 'lvl' => 1, 'app_code' => 'USER'],
            ['name' => 'Pemetaan Formasi', 'code' => 'FOR_12', 'created_by' => "system", 'parent_code' => "FOR_1", 'routes' => '/formasi/pemetaan_formasi_seluruh_indonesia/**', 'lvl' => 1, 'app_code' => 'PUSBIN'],

            ['name' => 'Review', 'code' => 'AKP_2', 'created_by' => "system", 'parent_code' => "AKP_1", 'routes' => "/akp/review,/akp/review/personal", 'lvl' => 1, 'app_code' => 'USER'],
            ['name' => 'KKN', 'code' => 'AKP_3', 'created_by' => "system", 'parent_code' => "AKP_1", 'routes' => "/akp/kkn/**", 'lvl' => 1, 'app_code' => 'PUSBIN'],
            ['name' => 'Daftar', 'code' => 'AKP_4', 'created_by' => "system", 'parent_code' => "AKP_1", 'routes' => "/akp/daftar/**", 'lvl' => 1, 'app_code' => 'PUSBIN'],
            ['name' => 'Pemetaan AKP', 'code' => 'AKP_5', 'created_by' => "system", 'parent_code' => "AKP_1", 'routes' => "/akp/pemetaan_akp/**,/akp/daftar_user_akp/**", 'lvl' => 1, 'app_code' => 'PUSBIN'],

            ['name' => 'Pendidikan', 'code' => 'MNT_2', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/pendidikan", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Jabatan', 'code' => 'MNT_3', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/jabatan", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Jenjang', 'code' => 'MNT_4', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/jenjang", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Pangkat', 'code' => 'MNT_5', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/pangkat", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Unit Kerja/OPD', 'code' => 'MNT_6', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/unit_kerja_opd", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Provinsi', 'code' => 'MNT_7', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/provinsi/**", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Kabupaten', 'code' => 'MNT_8', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/kabupaten/**", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
            ['name' => 'Kota', 'code' => 'MNT_9', 'created_by' => "system", 'parent_code' => "MNT_1", 'routes' => "/maintenance/kota/**", 'lvl' => 1, 'app_code' => 'USER,PUSBIN'],
        ]);
    }
}
