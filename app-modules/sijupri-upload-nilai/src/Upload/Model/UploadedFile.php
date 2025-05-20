<?php
namespace Src\Upload\Model;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $table = 'uploaded_files';

    protected $fillable = [
        'file_name',
        'file_path',
    ];
}
