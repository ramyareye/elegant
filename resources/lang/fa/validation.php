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

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attribute مطابقت ندارد',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => ' :attribute باید یک آدرس ایمیل معتبر باشد',
    'exists'               => ':attribute وارد شده غیر معتبر است',
    'filled'               => 'واردکردن :attribute الزامی است',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => ':attribute باید دارای حداقل :min حرف باشد.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'واردکردن :attribute الزامی است',
    'required_if'          => 'اگر :value هستید :attribute خود را وارد کنید',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'وارد کردن یکی از دو مقادیر :attribute و :values  اجباری است.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'این :attribute قبلا در سیستم ثبت شده است. لطفا از :attribute دیگری استفاده کنید.',
    'url'                  => 'The :attribute format is invalid.',
    'mobile'               => 'شماره ی همراه حتما باید 11 رقمی بوده و با 09 شروع شود',

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
        'attribute-name'      => [
            'rule-name' => 'custom-message',
        ],
        'generalError'        => 'خطا',
        'serverErrorOccurred' => 'متاسفانه خطایی در سرور رخ داده‌است!',
        'saveDataServerError' => 'متاسفانه خطایی در زمان ذخیره‌سازی اطلاعات رخ‌داده‌است. لطفا مجددا تلاش کنید',
        'fileNotFoundError'   => 'فایلی با این آدرس وجود ندارد',
        'emptyImageUrl'       => '    آدرس تصویر ارسال نشده است',
        'generalInputError'   => 'خطا در ورودی‌ها',

        'success' => [
            'saveAbstract' => 'ثبت موفّق',
            'save'         => 'اطلاعات با موفقیت ذخیره شد',
            'removeImage'  => 'تصویر با موفقیت حذف شد',
        ],

        'error' => [
            'general' => 'خطا',
            'upload'  => 'خطایی در هنکام آپلود به وجود آمد. لطفا نام فایل خود را بررسی کنید.',
            'insert'  => '',
        ],

        'confirmation' => [
            'general'     => 'هشدار',
            'removeImage' => 'آیا مطمئن هستید که می‌خواهید این تصویر را پاک کنید؟',
        ],

        'childBirthDate'  => [
            'required'                 => 'وارد کردن تاریخ تولد نوزاد الزامی است',
            'requiredIfYouArePregnant' => 'واردکردن تاریخ تولد نوزاد الزامی است! اگر باردار نیستید و قصد بارداری دارید، تیک «من قصد بارداری دارم» را بزنید',
            'formatError'              => 'تاریخ واردشده درست نیست. تاریخ باید به صورت (روز-دو رقم)/(ماه-دو رقم)/(سال-چهار رقم) باشد. برای وارد کردن تاریخ از تقویم موجود در سایت استفاده کنید.',
        ],
        'mobileAndEmail'  => [
            'required' => 'وارد کردن یکی از فیلدهای موبایل یا ایمیل الزامی است',
        ],
        'mobile'          => [
            'required'      => 'وارد کردن شماره موبایل الزامی است',
            'numeric'       => 'شماره همراه فقط باید از اعداد تشکیل شده باشد',
            'length'        => 'شماره‌های همراه باید دارای ۱۱ رقم باشند',
            'notStartWith0' => 'شماره‌ی همراه خود را به صورت ...۰۹ وارد کنید',
        ],
        'email'           => [
            'required'          => 'وارد کردن آدرس ایمیل الزامی است',
            'notValid'          => 'آدرس ایمیل معتبر نیست. آدرس معتبر حتما باید دارای کاراکترهای @ و . باشد',
            'alreadyRegistered' => 'ایمیلی که وارد کرده‌اید، قبلا در سیستم ثبت شده‌است. <br>
اگر این ایمیل متعلق به شماست و کلمه‌ی عبور خود را فراموش کرده‌اید، از «فراموشی کلمه‌ی عبور» در بخش ورود به سایت استفاده کنید',
        ],
        'password'        => [
            'required' => 'وارد کردن کلمه‌ی عبور الزامی است',
        ],
        'week'            => [
            'tabContentDoesNotExist' => 'همچین بخشی برای این هفته وجود ندارد',
        ],
        'periodLength'    => [
            'notEntered' => 'طول دوره‌ی ماهانه‌ی خود را وارد کنید',
            'notNumeric' => 'بازه‌ی قاعدگی باید یک عدد صحیح باشد',
        ],
        'periodDateDay'   => [
            'notEntered' => 'تاریخ اولین روز از آخرین قاعدگی خود را وارد نمایید',
        ],
        'periodDateMonth' => [
            'notEntered' => 'تاریخ ماه آخرین قاعدگی خود را وارد نمایید',
        ],
        'periodDateYear'  => [
            'notEntered' => 'تاریخ سال آخرین قاعدگی خود را وارد نمایید',
        ],
        'periodDate'      => [
            'day'        => [
                'notNumeric' => 'روز قاعدگی باید یک عدد صحیح باشد',
            ],
            'month'      => [
                'notNumeric' => 'لطفا ماه قاعدگی را وارد نمایید',
            ],
            'year'       => [
                'notNumeric' => 'سال قاعدگی باید یک عدد صحیح باشد',
            ],
            'notNumeric' => 'فرمت وارد شده صحیح نمیباشد',
            'notFormat'  => 'فرمت وارد شده صحیح نمیباشد',
        ],
        'weekOfPregnancy' => [
            'notInTrueIntervals' => 'اولین روز از آخرین قاعدگی شما نمی تواند در زمان آینده باشد',
            'yourChildBorn'      => 'بر اساس این تاریخ، فرزند شما باید تا به حال متولد شده باشد',
        ],
        'blog'            => [
            'comment' => [
                'notFormatEmail' => 'فرمت ایمیل وارد شده صحیح نمیباشد',
                'nameNotSet'     => 'لطفا نام خود را وارد نمایید',
                'emailNotSet'    => 'لطفا ایمیل خود را وارد نمایید',
                'messageNotSet'  => 'لطفا نظر خود را وارد نمایید',
            ],
        ],
        'media'           => [
            'delete'            => 'حدف',
            'error'             => 'خطا',
            'uploadSuccess'     => 'تصویر با موفقیت آپلود شد.',
            'uploadError'       => 'متاسفانه فایل مورد نظر آپلود نشد.',
            'incorrectImageUrl' => 'آدرس نصویر صحیح نیست.',
            'errorInsert'       => 'خطای پایگاه داده',
            'errorExtension'    => 'فرمت فایل انتخابی صحیح نیست.',
            'duplicateName'     => 'فایلی با همین نام قبلا آپلود شده است. لطفا ابتدا فایل قبلی را حذف و سپس فایل جدید را آپلود کنید.',
        ],
        'approvalDoctor'  => [
            'noDataEnteredError' => 'هنوز در بخش مورد نظر مقاله چیزی را وارد نکرده‌اید',
        ],
        'profile'         => [
            'wrongPassword'        => 'پسورد وارد شده صحیح نیست.',
            'confirmPasswordError' => 'پسوردهای وارد شده یکسان نیستند.',
        ],
        'consulting'      => [
            'questionCategoryWasNotSelected' => 'لطفا بخشی را که می‌خواهید پیرامون آن سوال کنید را انتخاب کنید',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'                 => 'نام و نام خانوادگی',
        'email'                => 'آدرس ایمیل',
        'password'             => 'کلمه‌ی عبور',
        'newsTitle'            => 'عنوان خبر',
        'newsKeywords'         => 'کلیدواژه‌ های خبر',
        'newsDescription'      => 'توصیف خبر',
        'newsFeaturedImage'    => 'آدرس تصویر شاخص',
        'newsCategoryId'       => 'دسته‌بندی خبر',
        'newsContent'          => 'محتوای خبر',
        'mobile'               => 'شماره همراه',
        'status'               => 'وضعیت شما (بارداری، ناباروری و ..)',
        'pregnant'             => 'باردار',
        'childBirthDate_day'   => 'روز تولد فرزند',
        'childBirthDate_month' => 'ماه تولد فرزند',
        'childBirthDate_year'  => 'سال تولد فرزند',
        'newsTitleUrl'         => 'تایتل خبر',
        'username'             => 'نام کاربری',
    ],
    /*    'required_if'          => 'The :attribute field is required when :other is :value.',*/

    'values' => [
        'status' => [
            'pregnant' => 'باردار',
        ],
    ],

    'registration_name:required'                    => 'نام و نام خانوادگی وارد نشده است',
    'registration_name:max'                         => 'نام و نام خانوادگی حداکثر می تواند شامل 255 کاراکتر باشد',
    'registration_type:required'                    => 'انتخاب پست الکترونیک یا موبایل الزامی است',
    'registration_email:required_if'                => 'پست الکترونیک وارد نشده است',
    'registration_email:email'                      => 'پست الکترونیک وارد شده نامعتبر است',
    'registration_email:max'                        => 'حداکثر کاراکتر مجاز پست الکترونیک 255 کاراکتر است',
    'registration_email:unique'                     => 'پست الکترونیک وارد شده تکراری است',
    'registration_mobile:required_if'               => 'تلفن همراه وارد نشده است',
    'registration_mobile:mobile'                    => 'تلفن همراه وارد شده نامعتبر است',
    'registration_mobile:unique'                    => 'تلفن همراه وارد شده تکراری است',
    'registration_password:required'                => 'کلمه عبور وارد نشده است',
    'registration_password:confirmed'               => 'کلمه عبور و تکرار آن با یکدیگر تفاوت دارند',
    'registration_password:min'                     => 'کلمه عبور باید حداقل دارای 6 کاراکتر باشد',
    'registration_status:required'                  => 'وضعیت شما (بارداری، ناباروری و ...) انتخاب نشده است',
    'registration_childBirthDate_day:required_if'   => 'روز تولد فرزند انتخاب نشده است',
    'registration_childBirthDate_day:between'       => 'روز تولد فرزند باید در محدوده 1 تا 31 باشد',
    'registration_childBirthDate_month:required_if' => 'ماه تولد فرزند انتخاب نشده است',
    'registration_childBirthDate_month:between'     => 'ماه تولد فرزند باید در محدوده 1 تا 12 باشد',
    'registration_childBirthDate_year:required_if'  => 'سال تولد فرزند انتخاب نشده است',
    'registration_childBirthDate_year:size'         => 'سال تولد فرزند باید 4 رقمی باشد',
];
