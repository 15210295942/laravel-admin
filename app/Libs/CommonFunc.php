<?php
/**
 * Created by PhpStorm.
 */

namespace App\Libs;


class CommonFunc
{
    /**
     * 获取开始和结束时间内的日期数组
     * @param string $bDate 开始日期
     * @param string $eDate 结束日期
     * @param string $format 返回的日期格式。默认Y-m-d
     * @return array 日期数组
     */
    public static function intervalDates($bDate, $eDate, $format = 'Y-m-d')
    {
        $bDate = new \DateTime($bDate);
        $eDate = new \DateTime($eDate);
        $eDate->modify('+1 day');

        $interval = new \DateInterval('P1D');
        $dateRange = new \DatePeriod($bDate, $interval, $eDate);
        $dates = [];
        foreach ($dateRange as $date) {
            $dates[] = $date->format($format);
        }
        return $dates;
    }

    public static function intervalMonth($bDate, $eDate, $format = 'Y-m')
    {
        $bDate = new \DateTime($bDate);
        $eDate = new \DateTime($eDate);
        $eDate->modify('+1 day');

        $interval = new \DateInterval('P1D');
        $dateRange = new \DatePeriod($bDate, $interval, $eDate);
        $month = [];
        foreach ($dateRange as $date) {
            $month[$date->format($format)] = null;
        }
        return array_keys($month);
    }

    /**
     * 导出excel(csv)
     * @param array $data 导出数据
     * @param array $headlist 第一行,列名
     * @param string $fileName 输出Excel文件名
     */
    public static function csv_export($data = [], $headlist = [], $fileName)
    {
        if (stristr($_SERVER['HTTP_USER_AGENT'], 'ipad') OR stristr($_SERVER['HTTP_USER_AGENT'],
                'iphone') OR stristr($_SERVER['HTTP_USER_AGENT'], 'ipod')
        ) {
            header("Content-Type: application/octet-stream");
        } else {
            header('Content-Type: application/vnd.ms-excel');
        }
        header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');
        header('Cache-Control: max-age=0');

        //打开PHP文件句柄,php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        //输出Excel列名信息
        //foreach ($headlist as $key => $value) {
        //CSV的Excel支持GBK编码，一定要转换，否则乱码
        //    $headlist[$key] = iconv('utf-8', 'gbk', $value);
        //}

        //将数据通过fputcsv写到文件句柄
        fputcsv($fp, $headlist);

        //计数器
        $num = 0;

        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;

        //逐行取出数据，不浪费内存
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {

            $num++;

            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }

            $row = $data[$i];
            //foreach ($row as $key => $value) {
            //    $row[$key] = iconv('utf-8', 'gbk', $value);
            //}

            fputcsv($fp, $row);
        }
    }
}