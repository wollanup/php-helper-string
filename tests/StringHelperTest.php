<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 02/06/17
 * Time: 16:29
 */

namespace Wollanup\Helper;

use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    
    public function testSanitizeForFileSystemNonStringShouldThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);
        StringHelper::sanitizeForFileSystem(0);
        
        $this->expectException(\InvalidArgumentException::class);
        StringHelper::sanitizeForFileSystem([]);
        
        $this->expectException(\InvalidArgumentException::class);
        StringHelper::sanitizeForFileSystem(function () { });
        
        $this->expectException(\InvalidArgumentException::class);
        StringHelper::sanitizeForFileSystem(false);
    }
    
    public function testSanitizeForFileSystemDotShouldReturnsDefaultReplacementChar()
    {
        $str = StringHelper::sanitizeForFileSystem('.');
        $this->assertSame($str, StringHelper::DEFAULT_REPLACEMENT_CHAR);
    }
    
    public function testSanitizeForFileSystemForbiddenChars()
    {
        $str = StringHelper::sanitizeForFileSystem(implode('', StringHelper::$forbiddenFileSystem));
        $this->assertSame($str,
            str_repeat(StringHelper::DEFAULT_REPLACEMENT_CHAR, count(StringHelper::$forbiddenFileSystem)));
    }
    
    public function testSanitizeForFileSystemAllAllowed()
    {
        $in = 'foo';
        $out = StringHelper::sanitizeForFileSystem($in);
        $this->assertSame($in, $out);
    }
    public function testSanitizeForFileSystemOtherReplacementChar()
    {
        $replaceChar = "_";
        $str = StringHelper::sanitizeForFileSystem(implode('', StringHelper::$forbiddenFileSystem), $replaceChar);
        $this->assertSame($str,
            str_repeat($replaceChar, count(StringHelper::$forbiddenFileSystem)));
    }
    public function testSanitizeForFileSystemForbiddenReplacementChar()
    {
        $in = 'foo';
        $this->expectException(InvalidReplacementCharacterException::class);
        StringHelper::sanitizeForFileSystem($in, StringHelper::$forbiddenFileSystem[0]);
    }
    
    public function testSanitizeForFileSystemOtherForbiddenList()
    {
        $in = 'foo';
        $forbidden = ['f'];
        $out = StringHelper::sanitizeForFileSystem($in, null, $forbidden);
        $this->assertSame(StringHelper::DEFAULT_REPLACEMENT_CHAR . 'oo', $out);
    }
    
    public function testSanitizeForFileSystemOtherForbiddenListAndReplacementChar()
    {
        $in = 'foo';
        $forbidden = ['f'];
        $out = StringHelper::sanitizeForFileSystem($in, 'b', $forbidden);
        $this->assertSame('boo', $out);
    }
}
