<?php

namespace App\Utils;

/**
 * Class LogParserHelper
 * a helper object to parse logs file!
 *
 * @package App\Utils
 */
class LogParserHelper
{
    /**
     * Prepare and retrieve the rows of string logs content.
     *
     * @since 1.0.0
     * @return array
     */
    public static function getRows(string $logsContent): array
    {
        return explode("\r\n", $logsContent);
    }

    /**
     * Retrieve column names.
     *
     * @since 1.0.0
     * @return array
     */
    public static function map(): array
    {
        return [
            'service_name',
            'start_date',
            'method',
            'endpoint',
            'protocol',
            'status_code',
        ];
    }

    /**
     * Retrieve the columns of log data from each line!
     *
     * @since 1.0.0
     * @return array
     */
    public static function getColumns(string $logsContent): array
    {
        foreach (self::getRows($logsContent) as $row) {

            if (empty(trim($row))) {

                continue;
            }

            $separatedCols = explode(" ", $row);
            $filteredData = array_filter($separatedCols, [self::class, 'filter']);
            $sanitizedData = array_map([self::class, 'sanitizer'], $filteredData);

            //Push to colums stack!
            $columns[] = array_combine(self::map(), $sanitizedData);
        }

        if (!empty($columns)) {

            $columns = self::prepareEndDate($columns);
        }

        return $columns ?? [];
    }

    /**
     * Prepare end date
     *
     * @since 1.0.0
     * @return array
     */
    public static function prepareEndDate(array $columns): array
    {
        $collections = collect($columns)->groupBy('service_name');

        foreach ($collections as $key => $collection) {

            $chunk_collection = array_chunk($collection->toArray(), 2);
            $_columns[] = array_map([self::class, 'insertEndDate'], $chunk_collection);
        }

        if (!$_columns) {

            return $columns;
        }

        return array_merge(...$_columns);
    }

    /**
     * Inserting end date service log.
     *
     * @since 1.0.0
     * @return array
     */
    public static function insertEndDate(array $items): array
    {
        if (count($items) < 2) {

            return [];
        }

        return array_merge(
            $items[0],
            [
                'end_date' => $items[1]['start_date'],
            ]
        );
    }

    /**
     * Retrieve sanitized column name.
     *
     * @since 1.0.0
     * @return array
     */
    public static function sanitizer(string $item): string
    {
        if (preg_match('/\d+\/.*\/\d+/i', $item)) {

            $item = str_replace(['[', ']', '/'], ['', '', '-'], $item);
            $is_separated = false;

            for ($i = 0; $i <= strlen($item) - 1; $i++) {

                if (':' !== $item[$i] || $is_separated) {
                    continue;
                }

                $item[$i] = ' ';
                $is_separated = true;
            }

            $time = strtotime($item);
            $item = date('Y-m-d H:i:s', $time);
        }

        return str_replace('"', '', $item);
    }

    /**
     * Retrieve filtered data.
     *
     * @since 1.0.0
     * @return array
     */
    public static function filter(string $item): bool
    {
        return '-' !== $item && !empty($item);
    }
}
