<?php

namespace Tec\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Tec\Theme\ThemeOption as BaseThemeOption;

/**
 * @method static array constructArgs()
 * @method static array constructSections()
 * @method static array constructFields(string $sectionId = '')
 * @method static bool getSection(string $id = '')
 * @method static void checkOptName()
 * @method static array getSections()
 * @method static \Tec\Theme\ThemeOption setSections(array $sections = [])
 * @method static \Tec\Theme\ThemeOption setSection(array $section = [])
 * @method static int getPriority(string $type)
 * @method static void processFieldsArray(string $sectionId = '', array $fields = [])
 * @method static \Tec\Theme\ThemeOption setField(array $field = [])
 * @method static \Tec\Theme\ThemeOption removeSection(string $id = '', bool $fields = false)
 * @method static void hideSection(string $id = '', bool $hide = true)
 * @method static array|bool getField(string $id = '')
 * @method static void hideField(string $id = '', bool $hide = true)
 * @method static \Tec\Theme\ThemeOption removeField(string $id = '')
 * @method static array getArgs()
 * @method static \Tec\Theme\ThemeOption setArgs(array $args = [])
 * @method static string|null getArg(string $key = '')
 * @method static \Tec\Theme\ThemeOption setOption(string $key, array|string|null $value = '')
 * @method static string getOptionKey(string $key, string|null $locale = '', string|null $theme = null)
 * @method static string|null renderField(array $field)
 * @method static bool hasOption(string $key)
 * @method static string|null getOption(string $key = '', array|string|null $default = '')
 * @method static bool saveOptions()
 * @method static array getFields()
 * @method static bool hasField(string $id)
 * @method static array prepareFromArray(array $options, string|null $locale = null, string|null $defaultLocale = null)
 * @deprecated
 * @see \Tec\Theme\ThemeOption
 */
class ThemeOptionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseThemeOption::class;
    }
}
