<?php
// generate-questions.php

// امن‌تر: نمایش خطا به مرورگر غیرفعال (برای پراوداکشن)
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

// فقط POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'error' => 'method_not_allowed',
        'message' => 'فقط متد POST مجاز است.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// کمکی: گرفتن IP کاربر
function getClientIp() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = $_SERVER[$key];
            // اگر لیست بود، اولین آیتم
            if (strpos($ip, ',') !== false) {
                $parts = explode(',', $ip);
                $ip = trim($parts[0]);
            }
            return $ip;
        }
    }
    return 'unknown';
}

// محدودیت: یک آزمون در هر IP در هر ۱ ساعت (۳۶۰۰ ثانیه)
$ip = getClientIp();
$now = time();
$limitSeconds = 10; // 1 ثانیه

$lockDir = __DIR__ . '/ip_locks';
if (!is_dir($lockDir)) {
    @mkdir($lockDir, 0777, true);
}

$lockFile = $lockDir . '/' . md5($ip) . '.json';

// اگر قبلاً برای این IP رکورد داریم، بررسی کن
if (file_exists($lockFile)) {
    $rawLock = @file_get_contents($lockFile);
    if ($rawLock !== false) {
        $lockData = json_decode($rawLock, true);
        if (is_array($lockData) && isset($lockData['last_exam_at'])) {
            $lastExam = (int)$lockData['last_exam_at'];
            $diff = $now - $lastExam;
            if ($diff < $limitSeconds) {
                $remaining = $limitSeconds - $diff;
                http_response_code(429); // Too Many Requests
                echo json_encode([
                    'error' => 'rate_limited',
                    'message' => 'شما به‌تازگی در آزمون شرکت کرده‌اید. لطفاً بعداً دوباره تلاش کنید.',
                    'retryAfterSeconds' => $remaining
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
        }
    }
}

// اگر از اینجا رد شدیم یعنی مجازه آزمون بده → قفل جدید/آپدیت
$lockData = [
    'ip' => $ip,
    'last_exam_at' => $now
];
@file_put_contents($lockFile, json_encode($lockData, JSON_UNESCAPED_UNICODE));

// داده ورودی را بخوان
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$language   = isset($data['language'])   ? strtolower(trim($data['language']))   : 'html';
$difficulty = isset($data['difficulty']) ? strtolower(trim($data['difficulty'])) : 'medium';
$count      = isset($data['count'])      ? (int)$data['count']                   : 10;

// نرمال‌سازی
$allowedLanguages = ['html', 'css', 'javascript', 'php'];
if (!in_array($language, $allowedLanguages, true)) {
    $language = 'html';
}

$allowedDifficulties = ['easy', 'medium', 'hard'];
if (!in_array($difficulty, $allowedDifficulties, true)) {
    $difficulty = 'medium';
}

if ($count < 1)  $count = 5;
if ($count > 20) $count = 20;

// بانک سوالات نمونه (می‌تونی هرچقدر خواستی اضافه کنی)
$questionBank = [


    // ================== HTML ==================
    'html' => [
        'easy' => [
            [
                'text' => 'هدف اصلی تگ <!DOCTYPE html> چیست؟',
                'options' => [
                    'مشخص کردن زبان برنامه‌نویسی سمت سرور',
                    'گفتن به مرورگر که سند را بر اساس استاندارد HTML5 تفسیر کند',
                    'تعیین charset صفحه',
                    'فعال کردن جاوااسکریپت در صفحه'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام ساختار برای یک سند HTML معتبر درست‌تر است؟',
                'options' => [
                    '<html><head><body>...</body></head></html>',
                    '<!DOCTYPE html><html><head>...</head><body>...</body></html>',
                    '<!DOCTYPE html><body>...</body>',
                    '<head><html><body>...</body></html></head>'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام تگ برای عنوان اصلی صفحه (بزرگ‌ترین عنوان) استفاده می‌شود؟',
                'options' => [
                    '<title>',
                    '<h1>',
                    '<header>',
                    '<strong>'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام تگ برای لینک‌ دادن به صفحه‌ی دیگر استفاده می‌شود؟',
                'options' => [
                    '<link>',
                    '<a>',
                    '<href>',
                    '<button>'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام تگ برای نمایش تصویر در HTML استفاده می‌شود؟',
                'options' => [
                    '<image>',
                    '<pic>',
                    '<img>',
                    '<src>'
                ],
                'answerIndex' => 2
            ],
        ],

        'medium' => [
            [
                'text' => 'برای مشخص کردن محتوای اصلی صفحه (بدون هدر و فوتر) از کدام تگ استفاده می‌شود؟',
                'options' => ['<section>', '<main>', '<article>', '<div>'],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای گرفتن ایمیل کاربر کدام ورودی مناسب‌تر است؟',
                'options' => [
                    '<input type="text">',
                    '<input type="email">',
                    '<input type="url">',
                    '<input type="mail">'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای اجباری کردن پر کردن یک فیلد فرم از کدام ویژگی استفاده می‌شود؟',
                'options' => ['validate', 'required', 'must', 'obligatory'],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام متاتگ روی توضیح نتایج جستجو بیشتر تأثیر دارد؟',
                'options' => [
                    '<meta name="keywords">',
                    '<meta name="viewport">',
                    '<meta name="description">',
                    '<meta name="robots">'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'برای بارگذاری تنبل (Lazy Loading) تصاویر از چه ویژگی استفاده می‌شود؟',
                'options' => [
                    'loading="lazy"',
                    'defer="true"',
                    '<lazy>',
                    'فقط با CSS'
                ],
                'answerIndex' => 0
            ],
            [
                'text' => 'برای مشخص کردن زبان محتوای صفحه از کدام ویژگی در تگ <html> استفاده می‌شود؟',
                'options' => [
                    'charset',
                    'dir',
                    'lang',
                    'locale'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'کدام تگ سمانتیک برای گروهی از لینک‌های ناوبری استفاده می‌شود؟',
                'options' => [
                    '<menu>',
                    '<nav>',
                    '<ul>',
                    '<header>'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای نمایش یک نقل‌قول چندخطی از کدام تگ استفاده می‌شود؟',
                'options' => [
                    '<q>',
                    '<blockquote>',
                    '<quote>',
                    '<cite>'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام تگ برای نمایش محتوای مستقل مثل یک پست بلاگ مناسب است؟',
                'options' => ['<section>', '<main>', '<article>', '<aside>'],
                'answerIndex' => 2
            ],
            [
                'text' => 'برای مشخص کردن جهت نوشتن متن (مثلاً راست به چپ) کدام ویژگی استفاده می‌شود؟',
                'options' => [
                    'lang',
                    'dir',
                    'text-direction',
                    'direction'
                ],
                'answerIndex' => 1
            ],
        ],

        'hard' => [
            [
                'text' => 'استفاده‌ی درست از تگ <header> کدام است؟',
                'options' => [
                    'فقط یک‌بار در کل صفحه و فقط در بالای سایت',
                    'می‌تواند برای هدر سایت و هدر هر بخش یا مقاله‌ای استفاده شود',
                    'فقط داخل <body> ولی نه داخل تگ‌های دیگر',
                    'فقط برای نمایش لوگو'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای بهتر کردن سئو و سمانتیک، کدام مورد مناسب‌تر است؟',
                'options' => [
                    'استفاده زیاد از <div> به‌جای تگ‌های سمانتیک',
                    'تقسیم منطقی محتوا با استفاده از <header>، <main>، <section>، <article>',
                    'قرار دادن تمام محتوا داخل یک <main>',
                    'استفاده نکردن از <main> چون اختیاری است'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه درباره‌ی ویژگی aria-label درست است؟',
                'options' => [
                    'برای تنظیم رنگ متن استفاده می‌شود',
                    'فقط در CSS کاربرد دارد',
                    'برای کمک به فناوری کمکی (مانند screen reader) جهت توصیف یک المان استفاده می‌شود',
                    'فقط روی تگ <img> مجاز است'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'برای تعریف رابطه‌ی بین <label> و <input> کدام روش استانداردتر است؟',
                'options' => [
                    'قرار دادن input داخل label',
                    'استفاده از for در label و id در input با مقدار یکسان',
                    'نوشتن name یکسان روی هر دو',
                    'استفاده از data-* برای اتصال'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام ویژگی روی تگ <a> برای امنیت بیشتر لینک‌هایی که در تب جدید باز می‌شوند ضروری است؟',
                'options' => [
                    'rel="noopener noreferrer"',
                    'secure="true"',
                    'target="__blank_secure"',
                    'aria-secure="true"'
                ],
                'answerIndex' => 0
            ],
            [
                'text' => 'تفاوت اصلی بین <section> و <article> چیست؟',
                'options' => [
                    '<article> همیشه داخل <section> قرار می‌گیرد',
                    '<section> برای گروه‌بندی موضوعی است و <article> برای محتوای مستقل که می‌تواند به‌تنهایی معنی‌دار باشد',
                    '<section> فقط در بلاگ‌ها استفاده می‌شود',
                    'هیچ تفاوتی ندارند و قابل جایگزینی کامل هستند'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه برای درج ویدئو بدون استفاده از iframe استانداردتر است؟',
                'options' => [
                    '<video src="..." controls>',
                    '<media src="..." controls>',
                    '<movie src="..." controls>',
                    '<source video="..." controls>'
                ],
                'answerIndex' => 0
            ],
            [
                'text' => 'برای توضیح محتوای یک جدول جهت دسترس‌پذیری، کدام تگ مناسب‌تر است؟',
                'options' => [
                    '<caption>',
                    '<summary>',
                    '<legend>',
                    '<describe>'
                ],
                'answerIndex' => 0
            ],
            [
                'text' => 'در سند HTML5 فقط یک تگ <main> مجاز است. دلیل اصلی این محدودیت چیست؟',
                'options' => [
                    'برای سازگاری با مرورگرهای قدیمی‌تر',
                    'برای ساده‌تر شدن انتخاب آن در CSS',
                    'برای این‌که فناوری‌های کمکی بتوانند محتوای اصلی صفحه را به‌درستی تشخیص دهند',
                    'هیچ دلیل خاصی ندارد و فقط از روی سلیقه است'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'کدام مورد برای بهبود ساختار هدینگ‌ها در سئو و دسترس‌پذیری درست‌تر است؟',
                'options' => [
                    'استفاده از چندین <h1> در بخش‌های مختلف صفحه',
                    'شروع ساختار عنوان‌ها از <h3>',
                    'داشتن یک <h1> اصلی و استفاده‌ی مرتب و سلسله‌مراتبی از <h2> تا <h6>',
                    'استفاده نکردن از تگ‌های هدینگ و فقط استفاده از <div> با کلاس'
                ],
                'answerIndex' => 2
            ],
        ],
    ],

    // ================== CSS ==================
    'css' => [
        'easy' => [
            [
                'text' => 'CSS مخفف چیست؟',
                'options' => [
                    'Cascading Style Sheets',
                    'Computer Style System',
                    'Colorful Style Sheets',
                    'Cascading Script Sheets'
                ],
                'answerIndex' => 0
            ],
            [
                'text' => 'برای رنگ متن از کدام ویژگی استفاده می‌شود؟',
                'options' => ['background-color', 'font-color', 'color', 'text-style'],
                'answerIndex' => 2
            ],
            [
                'text' => 'کدام علامت برای انتخاب کلاس در CSS استفاده می‌شود؟',
                'options' => ['#', '.', '&', '@'],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام علامت برای انتخاب id در CSS استفاده می‌شود؟',
                'options' => ['#', '.', '&', '@'],
                'answerIndex' => 0
            ],
            [
                'text' => 'برای تنظیم فونت اصلی یک المان از کدام ویژگی استفاده می‌شود؟',
                'options' => ['font', 'font-family', 'font-style', 'text-font'],
                'answerIndex' => 1
            ],
        ],
        'medium' => [
            [
                'text' => 'برای چیدمان افقی چند المان داخل یک ردیف، کدام روش مدرن‌تر است؟',
                'options' => [
                    'استفاده از جدول (table)',
                    'float: left',
                    'display: flex',
                    'position: absolute'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'کدام واحد، واحدی نسبی بر اساس اندازه فونت ریشه (html) است؟',
                'options' => ['px', 'em', 'rem', '%'],
                'answerIndex' => 2
            ],
            [
                'text' => 'برای انتخاب همه‌ی فرزندان مستقیم یک المان در CSS از کدام ترکیب استفاده می‌شود؟',
                'options' => [
                    'parent child',
                    'parent > child',
                    'parent + child',
                    'parent ~ child'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه درباره‌ی box-sizing: border-box صحیح است؟',
                'options' => [
                    'پدینگ و بوردر خارج از اندازه‌ی width و height حساب می‌شوند',
                    'پدینگ و بوردر داخل width و height حساب می‌شوند',
                    'فقط روی المان‌های inline اعمال می‌شود',
                    'باعث مخفی شدن overflow می‌شود'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای اعمال استایل فقط زمانی که موس روی المان قرار می‌گیرد از کدام pseudo-class استفاده می‌شود؟',
                'options' => [':active', ':hover', ':focus', ':visited'],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای ساخت یک شبکه‌ی واکنش‌گرا دو‌بعدی، کدام ویژگی مناسب‌تر است؟',
                'options' => [
                    'display: inline-block',
                    'display: grid',
                    'display: block',
                    'visibility: grid'
                ],
                'answerIndex' => 1
            ],
        ],
        'hard' => [
            [
                'text' => 'تفاوت اصلی بین em و rem در CSS چیست؟',
                'options' => [
                    'em همیشه از rem بزرگ‌تر است',
                    'em نسبت به فونت والد و rem نسبت به فونت ریشه (html) محاسبه می‌شود',
                    'rem فقط برای margin استفاده می‌شود',
                    'هیچ تفاوتی ندارند'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه برای مرکز کردن افقی و عمودی یک المان با flexbox درست‌تر است؟',
                'options' => [
                    'justify-content: center;',
                    'align-items: center;',
                    'هر دو (در کانتینر والد) لازم است',
                    'text-align: center; روی المان'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'برای تعریف متغیر در CSS مدرن از کدام دستور استفاده می‌شود؟',
                'options' => [
                    '@var main-color: #333;',
                    '$main-color: #333;',
                    '--main-color: #333; در :root یا یک سلکتور دیگر',
                    'let(--main-color, #333);'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'کدام ترکیب انتخابِ تمام لینک‌هایی است که داخل یک nav قرار دارند؟',
                'options' => [
                    'nav, a',
                    'nav > a',
                    'nav a',
                    'nav + a'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'در CSS Grid، ویژگی grid-template-columns چه کاری انجام می‌دهد؟',
                'options' => [
                    'تعداد ردیف‌ها را مشخص می‌کند',
                    'تعداد و اندازه ستون‌ها را مشخص می‌کند',
                    'فاصله بین ستون‌ها را مشخص می‌کند',
                    'موقعیت grid را نسبت به والد تعیین می‌کند'
                ],
                'answerIndex' => 1
            ],
        ],
    ],

    // ================== JavaScript ==================
    'javascript' => [
        'easy' => [
            [
                'text' => 'برای تعریف یک متغیر قابل تغییر در ES6 از کدام کلمه استفاده می‌شود؟',
                'options' => ['var', 'let', 'const', 'static'],
                'answerIndex' => 1
            ],
            [
                'text' => 'خروجی typeof 42 چیست؟',
                'options' => ['"number"', '"int"', '"float"', '"numeric"'],
                'answerIndex' => 0
            ],
            [
                'text' => 'کدام تابع برای چاپ در کنسول مرورگر استفاده می‌شود؟',
                'options' => ['print()', 'echo()', 'console.log()', 'debug()'],
                'answerIndex' => 2
            ],
            [
                'text' => 'کدام نماد برای کامنت تک‌خطی استفاده می‌شود؟',
                'options' => ['<!-- -->', '//', '/* */', '#'],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه یک آرایه در جاوااسکریپت است؟',
                'options' => ['{}', '[]', '()', '<>'],
                'answerIndex' => 1
            ],
        ],
        'medium' => [
            [
                'text' => 'خروجی عبارت "5" == 5 در جاوااسکریپت چیست؟',
                'options' => ['true', 'false', 'undefined', 'error'],
                'answerIndex' => 0
            ],
            [
                'text' => 'خروجی عبارت "5" === 5 چیست؟',
                'options' => ['true', 'false', 'undefined', 'error'],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام متد برای اضافه کردن یک آیتم به انتهای آرایه استفاده می‌شود؟',
                'options' => ['push()', 'pop()', 'shift()', 'unshift()'],
                'answerIndex' => 0
            ],
            [
                'text' => 'کدام متد برای ساخت یک آرایه‌ی جدید بر اساس map کردن روی آرایه‌ی قبلی استفاده می‌شود؟',
                'options' => ['forEach()', 'map()', 'filter()', 'reduce()'],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه یک تابع arrow معتبر است؟',
                'options' => [
                    'function => () {}',
                    '() -> {}',
                    '() => {}',
                    '=> () {}'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'برای دسترسی به یک المان با id="app" کدام صحیح است؟',
                'options' => [
                    'document.querySelector(".app")',
                    'document.getElementById("app")',
                    'document.getElementsByClassName("app")',
                    'window.app'
                ],
                'answerIndex' => 1
            ],
        ],
        'hard' => [
            [
                'text' => 'کدام گزینه بهترین تعریف از "closure" در جاوااسکریپت است؟',
                'options' => [
                    'تابعی که فقط یک آرگومان می‌گیرد',
                    'توانایی تابع برای دسترسی به محدوده‌ی لغوی بیرونی حتی بعد از اجرای آن',
                    'تابعی که خود را صدا می‌زند',
                    'ابعاد بسته‌بندی شده‌ی DOM'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'خروجی کد زیر چیست؟ const x = { a: 1 }; const y = x; y.a = 2; console.log(x.a);',
                'options' => ['1', '2', 'undefined', 'خطا'],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه درباره‌ی async/await صحیح است؟',
                'options' => [
                    'فقط در مرورگر کار می‌کند و در Node.js نه',
                    'syntactic sugar روی Promiseهاست و خوانایی کد asynchronous را زیاد می‌کند',
                    'جایگزین کامل Promise است و دیگر نیازی به Promise نیست',
                    'فقط در توابع anonymous مجاز است'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام متد برای گرفتن یک Promise که بعد از اولین resolve یا reject بین چند Promise تمام شود استفاده می‌شود؟',
                'options' => [
                    'Promise.all',
                    'Promise.race',
                    'Promise.allSettled',
                    'Promise.any'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام گزینه درباره‌ی this در جاوااسکریپت صحیح است؟',
                'options' => [
                    'همیشه به شیء global اشاره می‌کند',
                    'بسته به نحوه‌ی فراخوانی تابع تغییر می‌کند',
                    'فقط در کلاس‌ها معتبر است',
                    'فقط در strict mode وجود دارد'
                ],
                'answerIndex' => 1
            ],
        ],
    ],

    // ================== PHP ==================
    'php' => [
        'easy' => [
            [
                'text' => 'کدام تگ برای شروع و پایان کد PHP در یک فایل استفاده می‌شود؟',
                'options' => [
                    '<php>...</php>',
                    '<?php ... ?>',
                    '<? ... >',
                    '<script php>...</script>'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای چاپ متن در PHP معمولاً از کدام دستور استفاده می‌شود؟',
                'options' => ['echo', 'print_r', 'console.log', 'write'],
                'answerIndex' => 0
            ],
            [
                'text' => 'کدام علامت برای متغیرها در PHP استفاده می‌شود؟',
                'options' => ['@', '$', '#', '%'],
                'answerIndex' => 1
            ],
            [
                'text' => 'کدام تابع برای محتوای یک آرایه جهت debug مناسب‌تر است؟',
                'options' => ['echo', 'print_r', 'var_dump', 'alert'],
                'answerIndex' => 2
            ],
            [
                'text' => 'پسوند پیش‌فرض فایل‌های PHP چیست؟',
                'options' => ['.html', '.php', '.ph', '.phtmlonly'],
                'answerIndex' => 1
            ],
        ],
        'medium' => [
            [
                'text' => 'کدام سوپرگلوبال برای دریافت داده‌های ارسال شده با فرم method="POST" استفاده می‌شود؟',
                'options' => ['$_GET', '$_POST', '$_REQUEST', '$_FORM'],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای تعریف یک آرایه انجمنی (associative array) کدام درست‌تر است؟',
                'options' => [
                    '$user = array("name" => "Ali", "age" => 20);',
                    '$user = ["Ali", 20];',
                    '$user = ("name" => "Ali", "age" => 20);',
                    '$user = {"name": "Ali", "age": 20};'
                ],
                'answerIndex' => 0
            ],
            [
                'text' => 'کدام تابع برای شامل کردن یک فایل PHP دیگر استفاده می‌شود و در صورت خطا فقط warning می‌دهد؟',
                'options' => ['include', 'require', 'import', 'load'],
                'answerIndex' => 0
            ],
            [
                'text' => 'تفاوت اصلی require و include چیست؟',
                'options' => [
                    'هیچ تفاوتی ندارند',
                    'require در صورت خطا اجرای اسکریپت را متوقف می‌کند، include فقط هشدار می‌دهد',
                    'include در صورت خطا اجرای اسکریپت را متوقف می‌کند',
                    'require فقط در CLI کار می‌کند'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای شروع سشن در PHP از کدام تابع استفاده می‌شود؟',
                'options' => [
                    'session_open()',
                    'session_start()',
                    'start_session()',
                    'session()'
                ],
                'answerIndex' => 1
            ],
        ],
        'hard' => [
            [
                'text' => 'کدام گزینه درباره‌ی PDO در PHP صحیح است؟',
                'options' => [
                    'فقط برای MySQL قابل استفاده است',
                    'یک لایه‌ی abstraction برای اتصال به دیتابیس‌های مختلف است',
                    'فقط در نسخه‌های قدیمی PHP وجود دارد',
                    'جایگزین کامل SQL است و نیازی به نوشتن کوئری نیست'
                ],
                'answerIndex' => 1
            ],
            [
                'text' => 'برای جلوگیری از SQL Injection کدام روش مناسب‌تر است؟',
                'options' => [
                    'استفاده از addslashes روی ورودی',
                    'استفاده از htmlentities روی ورودی',
                    'Prepared Statement با بایند کردن پارامترها',
                    'استفاده از strip_tags روی ورودی'
                ],
                'answerIndex' => 2
            ],
            [
                'text' => 'کدام سطح visibility اجازه‌ی دسترسی فقط در داخل همان کلاس و کلاس‌های ارث‌برنده را می‌دهد؟',
                'options' => ['public', 'private', 'protected', 'static'],
                'answerIndex' => 2
            ],
            [
                'text' => 'برای تعریف یک متد استاتیک در کلاس از کدام کلمه استفاده می‌شود؟',
                'options' => [
                    'static function foo() {}',
                    'function static foo() {}',
                    'const function foo() {}',
                    'final static foo() {}'
                ],
                'answerIndex' => 0
            ],
            [
                'text' => 'کدام گزینه برای تعریف یک کلاس ساده در PHP درست‌تر است؟',
                'options' => [
                    'class User() {}',
                    'class User {}',
                    'User class {}',
                    'new class User {}'
                ],
                'answerIndex' => 1
            ],
        ],
    ],

    // اگر زبان ناشناخته باشد، بعداً می‌افتد روی html
    'python' => [], // فعلاً خالی، در صورت نیاز می‌توانی پر کنی
];

// اگر برای زبان انتخابی بانک سؤال نداشتیم، برگرد به html
if (!isset($questionBank[$language]) || empty($questionBank[$language])) {
    $language = 'html';
}

// اگر درجه سختی نامعتبر بود، medium را انتخاب کن
if (!isset($questionBank[$language][$difficulty])) {
    $difficulty = 'medium';
}

$baseQuestions = $questionBank[$language][$difficulty];

// اگر تعداد سؤال درخواست‌شده بیشتر از تعداد موجود بود، به حداکثر واقعی محدود کن
$totalAvailable = count($baseQuestions);
if ($count > $totalAvailable) {
    $count = $totalAvailable;
}

// شافل سؤال‌ها
shuffle($baseQuestions);

// برش به اندازه‌ی تعداد خواسته‌شده
$selected = array_slice($baseQuestions, 0, $count);

$questions = [];
foreach ($selected as $q) {
    $questions[] = [
        'text'        => $q['text'],
        'options'     => $q['options'],
        'answerIndex' => $q['answerIndex'],
    ];
}

echo json_encode([
    'questions' => $questions,
], JSON_UNESCAPED_UNICODE);
