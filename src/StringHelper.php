<?php

namespace Wollanup\Helper;

class StringHelper
{
    
    const DEFAULT_REPLACEMENT_CHAR = "-";
    /**
     * Forbidden Chars on File System (Who said Windows FS ?)
     *
     * @var array
     */
    public static $forbiddenFileSystem = ["\\", "/", ":", "*", "?", "<", ">", "|", "\""];
    
    /**
     * @param string     $string
     * @param string     $replace
     *
     * @param array|null $forbidden
     *
     * @return string
     * @throws InvalidReplacementCharacterException
     */
    public static function sanitizeForFileSystem(
        $string,
        $replace = self::DEFAULT_REPLACEMENT_CHAR,
        array $forbidden = null
    ) {
        if (!is_string($string)) {
            throw new \InvalidArgumentException("String expected, " . gettype($string) . "given");
        }
        
        if (null === $replace) {
            $replace = self::DEFAULT_REPLACEMENT_CHAR;
        }
        
        if (null === $forbidden) {
            $forbidden = self::$forbiddenFileSystem;
        }
        
        if ($replace !== self::DEFAULT_REPLACEMENT_CHAR && in_array($replace, $forbidden)) {
            throw new InvalidReplacementCharacterException("\"{$replace}\" is not a valid replacement character");
        }
        $string = trim($string);
        if ($string === '.') {
            return $replace;
        }
        
        return str_replace($forbidden, $replace, $string);
    }
}
