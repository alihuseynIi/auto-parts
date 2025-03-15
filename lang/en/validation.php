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

    'accepted' => ':attribute sahəsi qəbul edilməlidir.',
    'accepted_if' => ':other :value olduqda, :attribute sahəsi qəbul edilməlidir.',
    'active_url' => ':attribute sahəsi etibarlı bir URL olmalıdır.',
    'after' => ':attribute sahəsi :date tarixindən sonra olmalıdır.',
    'after_or_equal' => ':attribute sahəsi :date tarixindən sonra və ya ona bərabər olmalıdır.',
    'alpha' => ':attribute sahəsi yalnız hərflərdən ibarət olmalıdır.',
    'alpha_dash' => ':attribute sahəsi yalnız hərflər, rəqəmlər, tire (-) və alt xətlər (_) içerməlidir.',
    'alpha_num' => ':attribute sahəsi yalnız hərflər və rəqəmlər içerməlidir.',
    'array' => ':attribute sahəsi bir array (siyahı) olmalıdır.',
    'ascii' => ':attribute sahəsi yalnız tək baytlıq əlifba-rəqəm simvollarından və işarələrdən ibarət olmalıdır.',
    'before' => ':attribute sahəsi :date tarixindən əvvəl olmalıdır.',
    'before_or_equal' => ':attribute sahəsi :date tarixindən əvvəl və ya ona bərabər olmalıdır.',
    'between' => [
        'array' => ':attribute sahəsi :min ilə :max element arasında olmalıdır.',
        'file' => ':attribute sahəsinin ölçüsü :min ilə :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute sahəsi :min ilə :max arasında olmalıdır.',
        'string' => ':attribute sahəsi :min ilə :max simvol arasında olmalıdır.',
    ],
    'boolean' => ':attribute sahəsi doğru (true) və ya yanlış (false) olmalıdır.',
    'can' => ':attribute sahəsində icazəsiz dəyər mövcuddur.',
    'confirmed' => ':attribute sahəsinin təsdiqi uyğun gəlmir.',
    'contains' => ':attribute sahəsində tələb olunan dəyər çatışmır.',
    'current_password' => 'Parol yanlışdır.',
    'date' => ':attribute sahəsi etibarlı bir tarix olmalıdır.',
    'date_equals' => ':attribute sahəsi :date tarixinə bərabər olmalıdır.',
    'date_format' => ':attribute sahəsi :format formatına uyğun olmalıdır.',
    'decimal' => ':attribute sahəsi :decimal onluq mərtəbəyə malik olmalıdır.',
    'declined' => ':attribute sahəsi rədd edilməlidir.',
    'declined_if' => ':other :value olduqda, :attribute sahəsi rədd edilməlidir.',
    'different' => ':attribute sahəsi və :other fərqli olmalıdır.',
    'digits' => ':attribute sahəsi :digits rəqəmdən ibarət olmalıdır.',
    'digits_between' => ':attribute sahəsi :min və :max rəqəm arasında olmalıdır.',
    'dimensions' => ':attribute sahəsi etibarsız şəkil ölçülərinə malikdir.',
    'distinct' => ':attribute sahəsində təkrarlanan dəyər var.',
    'doesnt_end_with' => ':attribute sahəsi aşağıdakılardan biri ilə bitməməlidir: :values.',
    'doesnt_start_with' => ':attribute sahəsi aşağıdakılardan biri ilə başlamamalıdır: :values.',
    'email' => 'Doğru e-poçt daxil edilməyib.',
    'ends_with' => ':attribute sahəsi aşağıdakılardan biri ilə bitməlidir: :values.',
    'enum' => 'Seçilmiş :attribute etibarlı deyil.',
    'exists' => 'Seçilmiş :attribute etibarlı deyil.',
    'extensions' => ':attribute sahəsi aşağıdakı uzantılardan birinə malik olmalıdır: :values.',
    'file' => ':attribute sahəsi bir fayl olmalıdır.',
    'filled' => ':attribute sahəsi boş buraxıla bilməz.',
    'gt' => [
        'array' => ':attribute sahəsi :value elementdən çox olmalıdır.',
        'file' => ':attribute sahəsinin ölçüsü :value kilobaytdan çox olmalıdır.',
        'numeric' => ':attribute sahəsi :value-dən çox olmalıdır.',
        'string' => ':attribute sahəsi :value simvoldan çox olmalıdır.',
    ],
    'gte' => [
        'array' => ':attribute sahəsi ən azı :value element olmalıdır.',
        'file' => ':attribute sahəsinin ölçüsü :value kilobaytdan çox və ya bərabər olmalıdır.',
        'numeric' => ':attribute sahəsi :value-dən çox və ya bərabər olmalıdır.',
        'string' => ':attribute sahəsi :value simvoldan çox və ya bərabər olmalıdır.',
    ],
    'hex_color' => ':attribute sahəsi etibarlı onaltılıq (hex) rəng kodu olmalıdır.',
    'image' => ':attribute sahəsi şəkil olmalıdır.',
    'in' => 'Seçilmiş :attribute etibarlı deyil.',
    'in_array' => ':attribute sahəsi :other daxilində mövcud olmalıdır.',
    'integer' => ':attribute sahəsi tam ədəd olmalıdır.',
    'ip' => ':attribute sahəsi etibarlı IP ünvanı olmalıdır.',
    'ipv4' => ':attribute sahəsi etibarlı IPv4 ünvanı olmalıdır.',
    'ipv6' => ':attribute sahəsi etibarlı IPv6 ünvanı olmalıdır.',
    'json' => ':attribute sahəsi etibarlı JSON mətn formatında olmalıdır.',
    'list' => ':attribute sahəsi siyahı olmalıdır.',
    'lowercase' => ':attribute sahəsi kiçik hərflərlə yazılmalıdır.',
    'lt' => [
        'array' => ':attribute sahəsi :value elementdən az olmalıdır.',
        'file' => ':attribute sahəsinin ölçüsü :value kilobaytdan az olmalıdır.',
        'numeric' => ':attribute sahəsi :value-dən az olmalıdır.',
        'string' => ':attribute sahəsi :value simvoldan az olmalıdır.',
    ],
    'lte' => [
        'array' => ':attribute sahəsi maksimum :value elementdən ibarət ola bilər.',
        'file' => ':attribute sahəsinin ölçüsü :value kilobaytdan az və ya bərabər olmalıdır.',
        'numeric' => ':attribute sahəsi :value-dən az və ya bərabər olmalıdır.',
        'string' => ':attribute sahəsi maksimum :value simvol ola bilər.',
    ],
    'mac_address' => ':attribute sahəsi etibarlı MAC ünvanı olmalıdır.',
    'max' => [
        'array' => ':attribute sahəsində ən çox :max element ola bilər.',
        'file' => ':attribute faylının ölçüsü :max kilobaytdan çox olmamalıdır.',
        'numeric' => ':attribute sahəsinin dəyəri :max dəyərindən böyük olmamalıdır.',
        'string' => ':attribute sahəsinin uzunluğu :max simvoldan çox olmamalıdır.',
    ],
    'max_digits' => ':attribute sahəsi maksimum :max rəqəm ola bilər.',
    'mimes' => ':attribute sahəsi aşağıdakı formatlardan biri olmalıdır: :values.',
    'mimetypes' => ':attribute sahəsi aşağıdakı formatlardan biri olmalıdır: :values.',
    'min' => [
        'array' => ':attribute sahəsində ən azı :min element olmalıdır.',
        'file' => ':attribute faylının ölçüsü ən azı :min kilobayt olmalıdır.',
        'numeric' => ':attribute sahəsi ən azı :min olmalıdır.',
        'string' => ':attribute sahəsi ən azı :min simvoldan ibarət olmalıdır.',
    ],
    'min_digits' => ':attribute sahəsi ən azı :min rəqəmdən ibarət olmalıdır.',
    'missing' => ':attribute sahəsi mövcud olmamalıdır.',
    'missing_if' => ':other :value olduqda, :attribute sahəsi mövcud olmamalıdır.',
    'missing_unless' => ':other :value olmadığı halda, :attribute sahəsi mövcud olmamalıdır.',
    'missing_with' => ':values mövcud olduqda, :attribute sahəsi mövcud olmamalıdır.',
    'missing_with_all' => ':values mövcud olduqda, :attribute sahəsi mövcud olmamalıdır.',
    'multiple_of' => ':attribute sahəsi :value-in qatları olmalıdır.',
    'not_in' => 'Seçilmiş :attribute etibarlı deyil.',
    'not_regex' => ':attribute sahəsinin formatı etibarlı deyil.',
    'numeric' => ':attribute sahəsi rəqəm olmalıdır.',
    'password' => [
        'letters' => ':attribute sahəsi ən azı bir hərf daxil etməlidir.',
        'mixed' => ':attribute sahəsi ən azı bir böyük və bir kiçik hərf daxil etməlidir.',
        'numbers' => ':attribute sahəsi ən azı bir rəqəm daxil etməlidir.',
        'symbols' => ':attribute sahəsi ən azı bir simvol daxil etməlidir.',
        'uncompromised' => 'Seçilmiş :attribute məlumat sızıntısında aşkar edilib. Zəhmət olmasa, başqa şifrə seçin.',
    ],
    'present' => ':attribute sahəsi mövcud olmalıdır.',
    'present_if' => ':other :value olduqda, :attribute sahəsi mövcud olmalıdır.',
    'present_unless' => ':other :value olmadığı halda, :attribute sahəsi mövcud olmalıdır.',
    'present_with' => ':values mövcud olduqda, :attribute sahəsi də mövcud olmalıdır.',
    'present_with_all' => ':values mövcud olduqda, :attribute sahəsi də mövcud olmalıdır.',
    'prohibited' => ':attribute sahəsinə icazə verilmir.',
    'prohibited_if' => ':other :value olduqda, :attribute sahəsinə icazə verilmir.',
    'prohibited_unless' => ':other :values daxilində olmadığı halda, :attribute sahəsinə icazə verilmir.',
    'prohibits' => ':attribute sahəsi, :other sahəsinin mövcud olmasına mane olur.',
    'regex' => ':attribute sahəsinin formatı etibarlı deyil.',
    'required' => 'Bu sahə boş qoyula bilməz.',
    'required_array_keys' => ':attribute sahəsi aşağıdakı açarları ehtiva etməlidir: :values.',
    'required_if' => ':other :value olduqda, :attribute sahəsi mütləq doldurulmalıdır.',
    'required_if_accepted' => ':other qəbul edildikdə, :attribute sahəsi tələb olunur.',
    'required_if_declined' => ':other rədd edildikdə, :attribute sahəsi tələb olunur.',
    'required_unless' => ':other :values daxilində olmadığı halda, :attribute sahəsi mütləq doldurulmalıdır.',
    'required_with' => ':values mövcud olduqda, :attribute sahəsi mütləq doldurulmalıdır.',
    'required_with_all' => ':values mövcud olduqda, :attribute sahəsi mütləq doldurulmalıdır.',
    'required_without' => ':values olmadıqda, :attribute sahəsi mütləq doldurulmalıdır.',
    'required_without_all' => ':values-dan heç biri mövcud olmadıqda, :attribute sahəsi mütləq doldurulmalıdır.',
    'same' => ':attribute sahəsi :other ilə eyni olmalıdır.',
    'size' => [
        'array' => ':attribute sahəsi :size elementdən ibarət olmalıdır.',
        'file' => ':attribute sahəsinin ölçüsü :size kilobayt olmalıdır.',
        'numeric' => ':attribute sahəsi :size olmalıdır.',
        'string' => ':attribute sahəsi :size simvoldan ibarət olmalıdır.',
    ],
    'starts_with' => ':attribute sahəsi aşağıdakı dəyərlərdən biri ilə başlamalıdır: :values.',
    'string' => ':attribute sahəsi mətn olmalıdır.',
    'timezone' => ':attribute sahəsi etibarlı zaman qurşağı olmalıdır.',
    'unique' => 'Bu :attribute artıq sistemdə mövcuddur.',
    'uploaded' => ':attribute yüklənərkən səhv baş verdi.',
    'uppercase' => ':attribute sahəsi böyük hərflə olmalıdır.',
    'url' => ':attribute sahəsi etibarlı URL olmalıdır.',
    'ulid' => ':attribute sahəsi etibarlı ULID olmalıdır.',
    'uuid' => ':attribute sahəsi etibarlı UUID olmalıdır.',

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
