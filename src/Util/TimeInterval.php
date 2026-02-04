<?php

namespace Aternos\Mclogs\Util;

class TimeInterval
{
    use Singleton;

    protected const array UNITS = [
        "year"   => 365 * 24 * 60 * 60,
        "month"  => 30 * 24 * 60 * 60,
        "week"   => 7 * 24 * 60 * 60,
        "day"    => 24 * 60 * 60,
        "hour"   => 60 * 60,
        "minute" => 60,
        "second" => 1,
    ];

    // České překlady a skloňování: [1, 2-4, 5+]
    protected const array CZECH_UNITS = [
        "year"   => ["roku", "let", "let"],
        "month"  => ["měsíce", "měsíců", "měsíců"],
        "week"   => ["týdne", "týdnů", "týdnů"],
        "day"    => ["dne", "dní", "dní"],
        "hour"   => ["hodiny", "hodin", "hodin"],
        "minute" => ["minuty", "minut", "minut"],
        "second" => ["sekundy", "sekund", "sekund"],
    ];

    /**
     * @param int $value
     * @param string $unit
     * @return string
     */
    protected function formatUnit(int $value, string $unit): string
    {
        // Pokud jednotku nemáme v češtině, použijeme anglický fallback (nemělo by nastat)
        if (!isset(self::CZECH_UNITS[$unit])) {
            return $value . " " . $unit . ($value === 1 ? "" : "s");
        }

        $forms = self::CZECH_UNITS[$unit];

        if ($value === 1) {
            return $value . " " . $forms[0]; // 1 měsíc
        } elseif ($value >= 2 && $value <= 4) {
            return $value . " " . $forms[1]; // 3 měsíce
        } else {
            return $value . " " . $forms[2]; // 5 měsíců
        }
    }

    /**
     * @param int $duration
     * @param string $separator
     * @return string
     */
    public function format(int $duration, string $separator = ", "): string
    {
        $parts = [];
        while ($duration > 0) {
            foreach (self::UNITS as $unit => $seconds) {
                if ($duration >= $seconds) {
                    $value = intdiv($duration, $seconds);
                    $duration -= $value * $seconds;
                    $parts[] = $this->formatUnit($value, $unit);
                    break;
                }
            }
        }

        // Pokud je duration 0 (méně než sekunda), vrátíme "0 sekund" nebo prázdno
        if (empty($parts)) {
            return "0 sekund";
        }

        return implode($separator, $parts);
    }
}
