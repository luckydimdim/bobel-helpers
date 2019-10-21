<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Numeric class tests
 *
 * @author Dmitrii Litovchenko
 */
final class NumericTest extends TestCase
{
    /**
     * Check if the getDeclension helper works properly
     */
    public function testGetDeclencion()
    {
        // Arrange
        $input = 22;
        $expected = 'trees';

        // Act
        $actual = \Bobel\Helpers\Numeric::getDeclension($input, ['tree', 'trees', 'trees']);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the formatPrice helper works properly
     */
    public function testFormatPrice()
    {
        // Arrange
        $input = 4000200.5;
        $expected = '4 000 200.50';

        // Act
        $actual = \Bobel\Helpers\Numeric::formatPrice($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }
}
