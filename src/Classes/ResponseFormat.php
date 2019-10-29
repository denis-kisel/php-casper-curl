<?php


namespace DenisKisel\CasperCURL\Classes;


class ResponseFormat
{
    public static function format($content)
    {
        preg_match('/\{STATUS:(.*):STATUS\}/m', $content, $matches);
        $status = $matches[1] ?? 0;
        $content = (!empty($matches[0])) ? str_replace($matches[0], '', $content) : '';

        $response = new \stdClass();
        $response->status = $status;
        $response->content = $content;
        return $response;
    }
}
