<?php

/*
|--------------------------------------------------------------------------
| Pesan validasi — bahasa Indonesia natural
|--------------------------------------------------------------------------
| Ditulis luwes seperti bahasa sehari-hari, bukan terjemahan kaku.
*/

return [

    'accepted' => ':attribute harus disetujui.',
    'accepted_if' => ':attribute harus disetujui bila :other bernilai :value.',
    'active_url' => ':attribute bukan alamat URL yang valid.',
    'after' => ':attribute harus berisi tanggal setelah :date.',
    'after_or_equal' => ':attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'any_of' => ':attribute tidak valid.',
    'array' => ':attribute harus berupa daftar.',
    'ascii' => ':attribute hanya boleh berisi huruf, angka, dan simbol satu-bita.',
    'before' => ':attribute harus berisi tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus berisi antara :min sampai :max item.',
        'file' => 'Ukuran :attribute harus antara :min sampai :max kilobita.',
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'string' => ':attribute harus terdiri dari :min sampai :max karakter.',
    ],
    'boolean' => ':attribute hanya boleh bernilai ya atau tidak.',
    'can' => ':attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'contains' => ':attribute kurang nilai yang diwajibkan.',
    'current_password' => 'Kata sandi yang dimasukkan salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus berisi tanggal :date.',
    'date_format' => ':attribute tidak sesuai format :format.',
    'decimal' => ':attribute harus memiliki :decimal angka di belakang koma.',
    'declined' => ':attribute harus ditolak.',
    'declined_if' => ':attribute harus ditolak bila :other bernilai :value.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus terdiri dari :digits digit.',
    'digits_between' => ':attribute harus terdiri dari :min sampai :max digit.',
    'dimensions' => 'Ukuran gambar :attribute tidak sesuai.',
    'distinct' => ':attribute memiliki nilai yang duplikat.',
    'doesnt_contain' => ':attribute tidak boleh memuat: :values.',
    'doesnt_end_with' => ':attribute tidak boleh diakhiri dengan: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan: :values.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak ditemukan.',
    'extensions' => ':attribute harus berekstensi: :values.',
    'file' => ':attribute harus berupa berkas.',
    'filled' => ':attribute wajib diisi.',
    'gt' => [
        'array' => ':attribute harus berisi lebih dari :value item.',
        'file' => 'Ukuran :attribute harus lebih dari :value kilobita.',
        'numeric' => ':attribute harus lebih besar dari :value.',
        'string' => ':attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => ':attribute harus berisi minimal :value item.',
        'file' => 'Ukuran :attribute minimal :value kilobita.',
        'numeric' => ':attribute minimal bernilai :value.',
        'string' => ':attribute minimal :value karakter.',
    ],
    'hex_color' => ':attribute harus berupa kode warna heksadesimal yang valid.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute harus ada di dalam :other.',
    'in_array_keys' => ':attribute harus memuat salah satu kunci: :values.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'json' => ':attribute harus berupa teks JSON yang valid.',
    'list' => ':attribute harus berupa daftar berurutan.',
    'lowercase' => ':attribute harus berupa huruf kecil semua.',
    'lt' => [
        'array' => ':attribute harus berisi kurang dari :value item.',
        'file' => 'Ukuran :attribute harus kurang dari :value kilobita.',
        'numeric' => ':attribute harus lebih kecil dari :value.',
        'string' => ':attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':attribute harus berisi maksimal :value item.',
        'file' => 'Ukuran :attribute maksimal :value kilobita.',
        'numeric' => ':attribute maksimal bernilai :value.',
        'string' => ':attribute maksimal :value karakter.',
    ],
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => ':attribute tidak boleh berisi lebih dari :max item.',
        'file' => 'Ukuran :attribute tidak boleh melebihi :max kilobita.',
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'string' => ':attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => ':attribute tidak boleh lebih dari :max digit.',
    'mimes' => ':attribute harus berupa berkas bertipe: :values.',
    'mimetypes' => ':attribute harus berupa berkas bertipe: :values.',
    'min' => [
        'array' => ':attribute harus berisi minimal :min item.',
        'file' => 'Ukuran :attribute minimal :min kilobita.',
        'numeric' => ':attribute minimal bernilai :min.',
        'string' => ':attribute minimal :min karakter.',
    ],
    'min_digits' => ':attribute minimal terdiri dari :min digit.',
    'missing' => ':attribute tidak boleh ada.',
    'missing_if' => ':attribute tidak boleh ada bila :other bernilai :value.',
    'missing_unless' => ':attribute tidak boleh ada kecuali :other bernilai :value.',
    'missing_with' => ':attribute tidak boleh ada bila :values terisi.',
    'missing_with_all' => ':attribute tidak boleh ada bila semua :values terisi.',
    'multiple_of' => ':attribute harus kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak sesuai.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => [
        'letters' => ':attribute harus memuat minimal satu huruf.',
        'mixed' => ':attribute harus memuat huruf besar dan huruf kecil.',
        'numbers' => ':attribute harus memuat minimal satu angka.',
        'symbols' => ':attribute harus memuat minimal satu simbol.',
        'uncompromised' => ':attribute ini pernah bocor di internet. Silakan gunakan kata sandi lain.',
    ],
    'present' => ':attribute harus ada.',
    'present_if' => ':attribute harus ada bila :other bernilai :value.',
    'present_unless' => ':attribute harus ada kecuali :other bernilai :value.',
    'present_with' => ':attribute harus ada bila :values terisi.',
    'present_with_all' => ':attribute harus ada bila semua :values terisi.',
    'prohibited' => ':attribute tidak diizinkan.',
    'prohibited_if' => ':attribute tidak diizinkan bila :other bernilai :value.',
    'prohibited_if_accepted' => ':attribute tidak diizinkan bila :other disetujui.',
    'prohibited_if_declined' => ':attribute tidak diizinkan bila :other ditolak.',
    'prohibited_unless' => ':attribute tidak diizinkan kecuali :other ada di dalam :values.',
    'prohibits' => ':attribute membuat :other tidak boleh diisi.',
    'regex' => 'Format :attribute tidak sesuai.',
    'required' => ':attribute wajib diisi.',
    'required_array_keys' => ':attribute harus memuat kunci: :values.',
    'required_if' => ':attribute wajib diisi bila :other bernilai :value.',
    'required_if_accepted' => ':attribute wajib diisi bila :other disetujui.',
    'required_if_declined' => ':attribute wajib diisi bila :other ditolak.',
    'required_unless' => ':attribute wajib diisi kecuali :other ada di dalam :values.',
    'required_with' => ':attribute wajib diisi bila :values terisi.',
    'required_with_all' => ':attribute wajib diisi bila semua :values terisi.',
    'required_without' => ':attribute wajib diisi bila :values kosong.',
    'required_without_all' => ':attribute wajib diisi bila tidak ada satu pun dari :values yang terisi.',
    'same' => ':attribute harus sama dengan :other.',
    'size' => [
        'array' => ':attribute harus berisi tepat :size item.',
        'file' => 'Ukuran :attribute harus tepat :size kilobita.',
        'numeric' => ':attribute harus bernilai tepat :size.',
        'string' => ':attribute harus tepat :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali dengan salah satu dari: :values.',
    'string' => ':attribute harus berupa teks.',
    'timezone' => ':attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah dipakai.',
    'uploaded' => ':attribute gagal diunggah.',
    'uppercase' => ':attribute harus berupa huruf besar semua.',
    'url' => ':attribute harus berupa URL yang valid.',
    'ulid' => ':attribute harus berupa ULID yang valid.',
    'uuid' => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Pesan kustom per atribut & aturan
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Nama atribut yang ramah dibaca
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'nama',
        'email' => 'alamat email',
        'password' => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata sandi',
        'code' => 'kode undangan',
        'quantity' => 'jumlah kode',
        'expires_at' => 'tanggal kedaluwarsa',
    ],

];
