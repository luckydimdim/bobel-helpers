<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Uri class tests
 *
 * @author Dmitrii Litovchenko
 */
final class UriTest extends TestCase
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
}
