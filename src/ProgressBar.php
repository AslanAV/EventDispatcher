<?php

namespace App;

class ProgressBar
{
    private int $len;

    public function __construct(int $len)
    {
        $this->len = $len;
    }

    public function progressBar(int $done, string $info = ""): string
    {
        $total = $this->len;
        $func = static function (int $done, int $total, string $info = "", int $width = 50): string {

                $perch = (int) round(($done * 100) / $total);
                $bar = (int) round(($width * $perch) / 100);
                return sprintf(
                    "%s%% [%s>%s] %s\r",
                    $perch,
                    str_repeat("=", $bar),
                    str_repeat(" ", $width - $bar),
                    $info
                );
        };
        return $func($done, $total, $info, 50);
    }
}
