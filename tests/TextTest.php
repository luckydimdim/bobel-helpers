<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Text class tests
 *
 * @author Dmitrii Litovchenko
 */
final class TextTest extends TestCase
{
    /**
     * Check if the getRandomString helper works properly
     */
    public function testGetRandomString()
    {
        // Arrange
        $input = 16;
        $expected = 16;

        // Act
        $actual = strlen(\Bobel\Helpers\Text::getRandomString($input));

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the getRandomNumber helper works properly
     */
    public function testGetRandomNumber()
    {
        // Arrange
        $input = 10;
        $expected = 10;

        // Act
        $actual = strlen(\Bobel\Helpers\Text::getRandomNumber($input));

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the sanitizePhoneNumber helper works properly
     */
    public function testSanitizePhoneNumber()
    {
        // Arrange
        $input = '+1 (917) 123-45-67';
        $expected = '19171234567';

        // Act
        $actual = \Bobel\Helpers\Text::sanitizePhoneNumber($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the stripSpaces helper works properly
     */
    public function testStripSpaces()
    {
        // Arrange
        $input = ' a b  c  ';
        $expected = 'abc';

        // Act
        $actual = \Bobel\Helpers\Text::stripSpaces($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the maybeSerialize helper works properly
     */
    public function testMaybeSerialize()
    {
        // Arrange
        $input = ['a' => 'aa'];
        $expected = 'a:1:{s:1:"a";s:2:"aa";}';

        // Act
        $actual = \Bobel\Helpers\Text::maybeSerialize($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the maybeUnserialize helper works properly
     */
    public function testMaybeUnserialize()
    {
        // Arrange
        $input = 'a:1:{s:1:"a";s:2:"aa";}';
        $expected = ['a' => 'aa'];

        // Act
        $actual = \Bobel\Helpers\Text::maybeUnserialize($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the isSerialized helper works properly
     */
    public function testIsSerialized()
    {
        // Arrange
        $input = 'a:1:{s:1:"a";s:2:"aa";}';

        // Act
        $actual = \Bobel\Helpers\Text::isSerialized($input);

        // Assert
        $this->assertTrue($actual);
    }

    /**
     * Check if the fixBrokenSerialization helper works properly
     */
    public function testFixBrokenSerialization()
    {
        // Arrange
        $input = 'a:1:{s:2:"a";s:3:"aa";}';
        $expected = 'a:1:{s:1:"a";s:2:"aa";}';

        // Act
        $actual = \Bobel\Helpers\Text::fixBrokenSerialization($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the transliterate helper works properly
     */
    public function testTransliterate()
    {
        // Arrange
        $input = 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';
        $expected = 'AaBbVvGgDdEeEeGhghZzIiYyKkLlMmNnOoPpRrSsTtUuFfHhCcChchShshSchschYyYyYyEeYuyuYaya';

        // Act
        $actual = \Bobel\Helpers\Text::transliterate($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }
}
