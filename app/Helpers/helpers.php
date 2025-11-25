

<?php


use Hekmatinasser\Verta\Verta;

function datejallali($datetime,$mode)
{
    if ($mode == 1) {
        $timeseparate = explode(' ', $datetime);
        $time = explode('-', $timeseparate[0]);
        $date = verta::GregorianToJalali($time[0], $time[1], $time[2]); //1401-05-24 00:00:00
        $time = implode('/', $date);

        return $time;
    }


    if ($mode == 2) {
        $timeseparate = explode(' ', $datetime);
        $time = explode('-', $timeseparate[0]);
        $date = verta::GregorianToJalali($time[0], $time[1], $time[2]); //1401-05-24 00:00:00
//    $time = implode('/', $date);
        if ($date[1] == 1) {
            $month = 'فروردین';
        }
        if ($date[1] == 2) {
            $month = 'اردیبهشت';
        }
        if ($date[1] == 3) {
            $month = 'خرداد';
        }
        if ($date[1] == 4) {
            $month = 'تیر';
        }
        if ($date[1] == 5) {
            $month = 'مرداد';
        }
        if ($date[1] == 6) {
            $month = 'شهریور';
        }
        if ($date[1] == 7) {
            $month = 'مهر';
        }
        if ($date[1] == 8) {
            $month = 'آبان';
        }
        if ($date[1] == 9) {
            $month = 'آذر';
        }
        if ($date[1] == 10) {
            $month = 'دی';
        }
        if ($date[1] == 11) {
            $month = 'بهمن';
        }
        if ($date[1] == 12) {
            $month = 'اسفند';
        }

        if ($date[2] == 1) {
            $dayName = 'یک';
        }
        if ($date[2] == 2) {
            $dayName = 'دو';
        }
        if ($date[2] == 3) {
            $dayName = 'سه';
        }
        if ($date[2] == 4) {
            $dayName = 'چهار';
        }
        if ($date[2] == 5) {
            $dayName = 'پنج';
        }
        if ($date[2] == 6) {
            $dayName = 'شش';
        }
        if ($date[2] == 7) {
            $dayName = 'هفت';
        }
        if ($date[2] == 8) {
            $dayName = 'هشت';
        }
        if ($date[2] == 9) {
            $dayName = 'نه';
        }
        if ($date[2] == 10) {
            $dayName = 'ده';
        }
        if ($date[2] == 11) {
            $dayName = 'یازده';
        }
        if ($date[2] == 12) {
            $dayName = 'دوازده';
        }
        if ($date[2] == 13) {
            $dayName = 'سیزده';
        }
        if ($date[2] == 14) {
            $dayName = 'چهارده';
        }
        if ($date[2] == 15) {
            $dayName = 'پانزده';
        }
        if ($date[2] == 16) {
            $dayName = 'شانزده';
        }
        if ($date[2] == 17) {
            $dayName = 'هفده';
        }
        if ($date[2] == 18) {
            $dayName = 'هجده';
        }
        if ($date[2] == 19) {
            $dayName = 'نوزده';
        }
        if ($date[2] == 20) {
            $dayName = 'بیست';
        }
        if ($date[2] == 21) {
            $dayName = 'بیست و یک';
        }
        if ($date[2] == 22) {
            $dayName = 'بیست و دو';
        }
        if ($date[2] == 23) {
            $dayName = 'بیست و سه';
        }
        if ($date[2] == 24) {
            $dayName = 'بیست و چهار';
        }
        if ($date[2] == 25) {
            $dayName = 'بیست و پنج';
        }
        if ($date[2] == 26) {
            $dayName = 'بیست و شش';
        }
        if ($date[2] == 27) {
            $dayName = 'بیست و هفت';
        }
        if ($date[2] == 28) {
            $dayName = 'بیست و هشت';
        }
        if ($date[2] == 29) {
            $dayName = 'بیست و نه';
        }
        if ($date[2] == 30) {
            $dayName = 'سی';
        }
        if ($date[2] == 31) {
            $dayName = 'سی و یک';
        }


        $time = $dayName . '/' . $month . '/' . $date[0];

        return $time;
    }


    if ($mode) {
        $yearnow = date('Y');
        $monthnow = date('m');
        $daynow = date('d');
        $timeseparate = explode(' ', $datetime);
        $time = explode('-', $timeseparate[0]);
        $time[0] = (int)$time[0];
        $time[1] = (int)$time[1];
        $time[2] = (int)$time[2];


        $yearlyfilter = $yearnow - $time[0];
        $monthfilter = $monthnow - $time[1];
        $dayfilter = $daynow - $time[2];

        if ($yearlyfilter != 0) {
            if ($yearlyfilter == 1) {
                $yearname = 'یک';
            }
            if ($yearlyfilter == 2) {
                $yearname = 'دو';
            }
            if ($yearlyfilter == 3) {
                $yearname = 'سه';
            }
            if ($yearlyfilter == 4) {
                $yearname = 'چهار';
            }
            if ($yearlyfilter == 5) {
                $yearname = 'پنج';
            }
            if ($yearlyfilter == 6) {
                $yearname = 'شش';
            }
            if ($yearlyfilter == 7) {
                $yearname = 'هفت';
            }
            if ($yearlyfilter == 8) {
                $yearname = 'هشت';
            }
            if ($yearlyfilter == 9) {
                $yearname = 'نه';
            }
            if ($yearlyfilter == 10) {
                $yearname = 'ده';
            }
            if ($yearlyfilter == 11) {
                $yearname = 'یازده';
            }
            if ($yearlyfilter == 12) {
                $yearname = 'دوازده';
            }
            if ($yearlyfilter == 13) {
                $yearname = 'سیزده';
            }
            if ($yearlyfilter == 14) {
                $yearname = 'چهارده';
            }
            if ($yearlyfilter == 15) {
                $yearname = 'پانزده';
            }
            if ($yearlyfilter == 16) {
                $yearname = 'شانزده';
            }
            if ($yearlyfilter == 17) {
                $yearname = 'هفده';
            }
            if ($yearlyfilter == 18) {
                $yearname = 'هجده';
            }
            if ($yearlyfilter == 19) {
                $yearname = 'نوزده';
            }
            if ($yearlyfilter == 20) {
                $yearname = 'بیست';
            }
            if ($yearlyfilter == 21) {
                $yearname = 'بیست و یک';
            }
            if ($yearlyfilter == 22) {
                $yearname = 'بیست و دو';
            }
            if ($yearlyfilter == 23) {
                $yearname = 'بیست و سه';
            }
            if ($yearlyfilter == 24) {
                $yearname = 'بیست و چهار';
            }
            if ($yearlyfilter == 25) {
                $yearname = 'بیست و پنج';
            }
            if ($yearlyfilter == 26) {
                $yearname = 'بیست و شش';
            }
            if ($yearlyfilter == 27) {
                $yearname = 'بیست و هفت';
            }
            if ($yearlyfilter == 28) {
                $yearname = 'بیست و هشت';
            }
            if ($yearlyfilter == 29) {
                $yearname = 'بیست و نه';
            }
            if ($yearlyfilter == 30) {
                $yearname = 'سی';
            }
            if ($yearlyfilter == 31) {
                $yearname = 'سی و یک';
            } elseif ($yearlyfilter > 31) {
                $yearname = '';
                $massage = 'خیلی وقت پیش';
            }


        }
        if (empty($massage)) {
            if ($monthfilter > 0) {
                if ($monthfilter == 1) {
                    $mothname = 'یک';
                }
                if ($monthfilter == 2) {
                    $mothname = 'دو';
                }
                if ($monthfilter == 3) {
                    $mothname = 'سه';
                }
                if ($monthfilter == 4) {
                    $mothname = 'چهار';
                }
                if ($monthfilter == 5) {
                    $mothname = 'پنج';
                }
                if ($monthfilter == 6) {
                    $mothname = 'شش';
                }
                if ($monthfilter == 7) {
                    $mothname = 'هفت';
                }
                if ($monthfilter == 8) {
                    $mothname = 'هشت';
                }
                if ($monthfilter == 9) {
                    $mothname = 'نه';
                }
                if ($monthfilter == 10) {
                    $mothname = 'ده';
                }
                if ($monthfilter == 11) {
                    $mothname = 'یازده';
                }
                if ($monthfilter == 12) {
                    $mothname = 'دوازده';
                }
            }

            if ($dayfilter > 0) {
                if ($dayfilter == 1) {
                    $dayName = 'یک';
                }
                if ($dayfilter == 2) {
                    $dayName = 'دو';
                }
                if ($dayfilter == 3) {
                    $dayName = 'سه';
                }
                if ($dayfilter == 4) {
                    $dayName = 'چهار';
                }
                if ($dayfilter == 5) {
                    $dayName = 'پنج';
                }
                if ($dayfilter == 6) {
                    $dayName = 'شش';
                }
                if ($dayfilter == 7) {
                    $dayName = 'هفت';
                }
                if ($dayfilter == 8) {
                    $dayName = 'هشت';
                }
                if ($dayfilter == 9) {
                    $dayName = 'نه';
                }
                if ($dayfilter == 10) {
                    $dayName = 'ده';
                }
                if ($dayfilter == 11) {
                    $dayName = 'یازده';
                }
                if ($dayfilter == 12) {
                    $dayName = 'دوازده';
                }
                if ($dayfilter == 13) {
                    $dayName = 'سیزده';
                }
                if ($dayfilter == 14) {
                    $dayName = 'چهارده';
                }
                if ($dayfilter == 15) {
                    $dayName = 'پانزده';
                }
                if ($dayfilter == 16) {
                    $dayName = 'شانزده';
                }
                if ($dayfilter == 17) {
                    $dayName = 'هفده';
                }
                if ($dayfilter == 18) {
                    $dayName = 'هجده';
                }
                if ($dayfilter == 19) {
                    $dayName = 'نوزده';
                }
                if ($dayfilter == 20) {
                    $dayName = 'بیست';
                }
                if ($dayfilter == 21) {
                    $dayName = 'بیست و یک';
                }
                if ($dayfilter == 22) {
                    $dayName = 'بیست و دو';
                }
                if ($dayfilter == 23) {
                    $dayName = 'بیست و سه';
                }
                if ($dayfilter == 24) {
                    $dayName = 'بیست و چهار';
                }
                if ($dayfilter == 25) {
                    $dayName = 'بیست و پنج';
                }
                if ($dayfilter == 26) {
                    $dayName = 'بیست و شش';
                }
                if ($dayfilter == 27) {
                    $dayName = 'بیست و هفت';
                }
                if ($dayfilter == 28) {
                    $dayName = 'بیست و هشت';
                }
                if ($dayfilter == 29) {
                    $dayName = 'بیست و نه';
                }
                if ($dayfilter == 30) {
                    $dayName = 'سی';
                }
                if ($dayfilter == 31) {
                    $dayName = 'سی و یک';
                }
            }


        }
        if (!empty($yearname)) {
            $yearlymasage = $yearname . ' ' . 'سال';
        } else {
            $yearlymasage = '';
        }
        if (!empty($mothname)) {
            $monthmassage = $mothname . ' ' . 'ماه';
        } else {
            $monthmassage = '';
        }
        if (!empty($dayName)) {
            $daymassage = $dayName . ' ' . 'روز';

        } else {
            $daymassage = '';
        }
        if (!empty($massage)) {
            $completmassage = $massage;
        } elseif (empty($yearlymasage) and empty($monthmassage) and empty($daymassage)) {
            $completmassage = 'امروز اپلود شده است';
        } else {
            $completmassage = '';
            if (!empty($yearlymasage)) {
                $completmassage=$completmassage.$yearlymasage . ' و ';
            }if (!empty($monthmassage)) {
                $completmassage = $completmassage.$monthmassage . ' و ';
            }
            if (!empty($daymassage)) {
                $completmassage = $completmassage.$daymassage . '  ';
            }
            $completmassage=$completmassage.'گذشته';

        }

        return $completmassage;
    }


}
