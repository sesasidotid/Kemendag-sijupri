<!-- <?php
// use App\Enums\TaskStatus;
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {

//     public function up()
//     {
//         if (!Schema::hasTable('tbl_ukom'))
//             Schema::create('tbl_ukom', function (Blueprint $table) {
//                 $table->string('code')->primary();
//                 $table->timestamps();
//                 $table->string('created_by')->nullable();
//                 $table->string('updated_by')->nullable();
//                 $table->string('tipe_ukom');
//                 $table->string('jenis_ukom');
//                 $table->string('jabatan_tujuan');
//                 //bebas pelanggaran kode etik dan disiplin
//                 $table->string('file_bebas_hukuman'); // kalau promosi (3 tahun terakhir)
//                 $table->string('file_surat_atasan');
//                 $table->string('file_surat_dokter');
//                 //file portofolia kompetensi (mengulang/perpindahan)
//                 $table->string('file_portofolio');
//                 //file pernyataan bersedia diangkat (perpindahan)
//                 $table->string('file_sedia_angkat');
//                 //bukti hasil kajian (perpindahan)
//                 $table->string('file_hasil_kaji');
//                 //file rekam jejak (promosi)
//                 $table->string('file_rekam_jejak');
//                 //surat rekomendasi tim penilai kinerja pns (promosi)
//                 $table->string('file_rekomendasi_penilai');
//                 //sk pembentukan tim penilai kinerja pns (promosi)
//                 $table->string('file_pembentukan_penilai');
//                 $table->float('puncak_jenjang')->nullable();
//                 $table->string('description');
//                 $table->boolean('delete_flag')->default(false);
//                 $table->boolean('inactive_flag')->default(false);
//                 $table->string('task_status')->nullable();
                $table->string('comment')->nullable();
//                 $table->string('nip')->nullable();

//                 $table->foreign('nip')->references('nip')->on('tbl_user');
//                 $table->foreign('jabatan_tujuan')->references('code')->on('tbl_jabatan');
//             });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('tbl_ukom');
//     }
// };