<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'        => 'harus diterima.',
    'accepted_if' => 'harus diterima jika :other adalah :value.',
    'active_url'      => 'bukan URL yang valid.',
    'after'           => 'harus berisi tanggal setelah :date.',
    'after_or_equal'  => 'harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'           => 'hanya boleh berisi huruf.',
    'alpha_dash'      => 'hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'       => 'hanya boleh berisi huruf dan angka.',
    'array'           => 'harus berisi sebuah array.',
    'before'          => 'harus berisi tanggal sebelum :date.',
    'before_or_equal' => 'harus berisi tanggal sebelum atau sama dengan :date.',
    'between'         => [
        'numeric' => 'harus bernilai antara :min sampai :max.',
        'file'    => 'harus berukuran antara :min sampai :max kilobita.',
        'string'  => 'harus berisi antara :min sampai :max karakter.',
        'array'   => 'harus memiliki :min sampai :max anggota.',
    ],
    'boolean'        => 'harus bernilai true atau false',
    'confirmed'      => 'Konfirmasi tidak cocok.',
    'current_password' => 'Kata sandi salah.',
    'date'           => 'bukan tanggal yang valid.',
    'date_equals'    => 'harus berisi tanggal yang sama dengan :date.',
    'date_format'    => 'tidak cocok dengan format :format.',
    'declined' => 'harus ditolak.',
    'declined_if' => 'harus ditolak ketika :other adalah :value.',
    'different'      => 'dan :other harus berbeda.',
    'digits'         => 'harus terdiri dari :digits angka.',
    'digits_between' => 'harus terdiri dari :min sampai :max angka.',
    'dimensions'     => 'tidak memiliki dimensi gambar yang valid.',
    'distinct'       => 'memiliki nilai yang duplikat.',
    'email'          => 'harus berupa alamat surel yang valid.',
    'ends_with'      => 'harus diakhiri salah satu dari berikut: :values',
    'enum' => 'yang dipilih tidak valid.',
    'exists'         => 'yang dipilih tidak valid.',
    'file'           => 'harus berupa sebuah berkas.',
    'filled'         => 'harus memiliki nilai.',
    'gt'             => [
        'numeric' => 'harus bernilai lebih besar dari :value.',
        'file'    => 'harus berukuran lebih besar dari :value kilobita.',
        'string'  => 'harus berisi lebih besar dari :value karakter.',
        'array'   => 'harus memiliki lebih dari :value anggota.',
    ],
    'gte' => [
        'numeric' => 'harus bernilai lebih besar dari atau sama dengan :value.',
        'file'    => 'harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'string'  => 'harus berisi lebih besar dari atau sama dengan :value karakter.',
        'array'   => 'harus terdiri dari :value anggota atau lebih.',
    ],
    'image'    => 'harus berupa gambar.',
    'in'       => 'yang dipilih tidak valid.',
    'in_array' => 'tidak ada di dalam :other.',
    'integer'  => 'harus berupa bilangan bulat.',
    'ip'       => 'harus berupa alamat IP yang valid.',
    'ipv4'     => 'harus berupa alamat IPv4 yang valid.',
    'ipv6'     => 'harus berupa alamat IPv6 yang valid.',
    'json'     => 'harus berupa JSON string yang valid.',
    'lt'       => [
        'numeric' => 'harus bernilai kurang dari :value.',
        'file'    => 'harus berukuran kurang dari :value kilobita.',
        'string'  => 'harus berisi kurang dari :value karakter.',
        'array'   => 'harus memiliki kurang dari :value anggota.',
    ],
    'lte' => [
        'numeric' => 'harus bernilai kurang dari atau sama dengan :value.',
        'file'    => 'harus berukuran kurang dari atau sama dengan :value kilobita.',
        'string'  => 'harus berisi kurang dari atau sama dengan :value karakter.',
        'array'   => 'harus tidak lebih dari :value anggota.',
    ],
    'mac_address' => 'harus berupa alamat MAC yang valid.',
    'max' => [
        'numeric' => 'maskimal bernilai :max.',
        'file'    => 'maksimal berukuran :max kilobita.',
        'string'  => 'maskimal berisi :max karakter.',
        'array'   => 'maksimal terdiri dari :max anggota.',
    ],
    'mimes'     => 'harus berupa berkas berjenis: :values.',
    'mimetypes' => 'harus berupa berkas berjenis: :values.',
    'min'       => [
        'numeric' => 'minimal bernilai :min.',
        'file'    => 'minimal berukuran :min kilobita.',
        'string'  => 'minimal berisi :min karakter.',
        'array'   => 'minimal terdiri dari :min anggota.',
    ],
    'multiple_of' => 'atribut harus kelipatan :value.',
    'not_in'               => 'yang dipilih tidak valid.',
    'not_regex'            => 'Format tidak valid.',
    'numeric'              => 'harus berupa angka.',
    'password'             => 'Kata sandi salah.',
    'present'              => 'wajib ada.',
    'prohibited' => 'field is prohibited.',
    'prohibited_if' => 'field is prohibited when :other is :value.',
    'prohibited_unless' => 'field is prohibited unless :other is in :values.',
    'prohibits' => 'field prohibits :other from being present.',
    'regex'                => 'Format tidak valid.',
    'required'             => 'wajib diisi.',
    'required_array_keys' => 'field atribut harus berisi entri untuk: :values.',
    'required_if'          => 'wajib diisi bila :other adalah :value.',
    'required_unless'      => 'wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => 'wajib diisi bila terdapat :values.',
    'required_with_all'    => 'wajib diisi bila terdapat :values.',
    'required_without'     => 'wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'wajib diisi bila sama sekali tidak terdapat :values.',
    'same'                 => 'dan :other harus sama.',
    'size'                 => [
        'numeric' => 'harus berukuran :size.',
        'file'    => 'harus berukuran :size kilobyte.',
        'string'  => 'harus berukuran :size karakter.',
        'array'   => 'harus mengandung :size anggota.',
    ],
    'starts_with' => 'harus diawali salah satu dari berikut: :values',
    'string'      => 'harus berupa string.',
    'timezone'    => 'harus berisi zona waktu yang valid.',
    'unique'      => 'sudah ada sebelumnya.',
    'uploaded'    => 'gagal diunggah.',
    'url'         => 'Format tidak valid.',
    'uuid'        => 'harus merupakan UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
