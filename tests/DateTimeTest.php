<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * DateTime class tests
 *
 * @author Dmitrii Litovchenko
 */
final class DateTimeTest extends TestCase
{
    /**
     * Check if the toSql helper works properly
     */
    public function testToSql()
    {
        // Arrange
        $input = '15.05.2005 12:15:45';
        $expected = '2005-05-15 12:15:45';

        // Act
        $actual = \Bobel\Helpers\DateTime::toSql($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the isValid helper works properly
     */
    public function testIsValid()
    {
        // Arrange
        $input = '15.05.2005';

        // Act
        $actual = \Bobel\Helpers\DateTime::isValid($input);

        // Assert
        $this->assertTrue($actual);
    }
}
