<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Link class tests
 *
 * @author Dmitrii Litovchenko
 */
final class LinkTest extends TestCase
{
    /**
     * Check if the clearParams helper works properly
     */
    public function testClearParams()
    {
        // Arrange
        $input = 'https://fake.url/?param1=value1&param2=value2';
        $expected = 'https://fake.url/';

        // Act
        $actual = \Bobel\Helpers\Link::clearParams($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the setHttps helper works properly
     */
    public function testSetHttps()
    {
        // Arrange
        $input = 'fake.url';
        $expected = 'https://fake.url';

        // Act
        $actual = \Bobel\Helpers\Link::setHttps($input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the setParam helper works properly
     */
    public function testSetParam()
    {
        // Arrange
        $input = 'https://fake.url/?param1=value1&param2=value2';
        $expected = 'https://fake.url/?param1=newValue&param2=value2';

        // Act
        $actual = \Bobel\Helpers\Link::setParam('param1', 'newValue', $input);

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the removeParam helper works properly
     */
    public function testRemoveParam()
    {
        // Arrange
        $input = 'https://fake.url/?param1=value1&param2=value2';
        $expected = 'https://fake.url/?param2=value2';

        // Act
        $actual = \Bobel\Helpers\Link::removeParam('param1', $input);

        // Assert
        $this->assertEquals($expected, $actual);
    }
}
