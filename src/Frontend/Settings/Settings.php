<?php

namespace Aternos\Mclogs\Frontend\Settings;

use Aternos\Mclogs\Frontend\Cookie\SettingsCookie;

class Settings
{
    /**
     * @var array<string, mixed>
     */
    protected array $data = [];

    public function __construct()
    {
        $rawData = new SettingsCookie()->getValue();
        if ($rawData) {
            $parsedData = json_decode($rawData, true);
            if (is_array($parsedData)) {
                $this->data = $parsedData;
            }
        }
    }

    /**
     * @return string
     */
    public function getBodyClassesString(): string
    {
        $classes = $this->getBodyClasses();
        if (empty($classes)) {
            return "";
        }
        return " " . implode(" ", $this->getBodyClasses());
    }

    /**
     * @return string[]
     */
    public function getBodyClasses(): array
    {
        $classes = [];
        foreach (Setting::cases() as $setting) {
            if ($this->get($setting)) {
                $bodyClass = $setting->getBodyClass();
                if ($bodyClass) {
                    $classes[] = $bodyClass;
                }
            }
        }
        return $classes;
    }

    /**
     * @param Setting $key
     * @return bool
     */
    public function get(Setting $key): bool
    {
        $value = $this->data[$key->value] ?? false;
        if (is_bool($value)) {
            return $value;
        }
        return false;
    }
}