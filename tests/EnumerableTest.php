<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Enumerable class tests
 *
 * @author Dmitrii Litovchenko
 */
final class EnumerableTest extends TestCase
{
    /**
     * Check if the clear helper works properly
     */
    public function testClear()
    {
        // Arrange
        $input = ['a', '', 'b', 'c', 'd', 'e', null];
        $expected = ['a', 'b', 'c', 'd', 'e'];

        // Act
        $actual = \Bobel\Helpers\Enumerable::clear($input);
        $arraysAreSimilar = $this->arraysAreSimilar(array_values($actual), $expected);

        // Assert
        $this->assertTrue($arraysAreSimilar);
    }

    /**
     * Check if the uniqueMulti helper works properly
     */
    public function testUniqueMulti()
    {
        // Arrange
        $input = [
            'a' => ['aa' => 'aaa'],
            'b' => ['aa' => 'aaa'],
            'c' => ['aa' => 'aaa']
        ];

        $expected = ['aa' => 'aaa'];

        // Act
        $actual = \Bobel\Helpers\Enumerable::uniqueMulti($input, 'aa');
        $arraysAreSimilar = $this->arraysAreSimilar($actual[0], $expected);

        // Assert
        $this->assertTrue($arraysAreSimilar);
    }

    /**
     * Check if the uniqueMulti helper works properly
     */
    public function testGet()
    {
        // Arrange
        $input = [1];
        $expected = 'ok';

        // Act
        $actual = \Bobel\Helpers\Enumerable::get($input['not_exists'], 'ok');

        // Assert
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if the pluck helper works properly
     */
    public function testPluck()
    {
        // Arrange
        $input = [
            'a' => ['aa' => 'aaa'],
            'b' => ['bb' => 'bbb'],
            'c' => ['cc' => 'ccc']
        ];

        $expected = 'ccc';

        // Act
        $actual = \Bobel\Helpers\Enumerable::pluck($input, 'cc');

        // Assert
        $this->assertEquals($expected, $actual['c']);
    }

    /**
     * Check if the objectToArray helper works properly
     */
    public function testObjectToArray()
    {
        // Arrange
        $input = (object) ['a', 'b', 'c'];
        $expected = ['a', 'b', 'c'];

        // Act
        $actual = \Bobel\Helpers\Enumerable::objectToArray( (object) $input );
        $arraysAreSimilar = $this->arraysAreSimilar($expected, $actual);

        // Assert
        $this->assertTrue($arraysAreSimilar);
    }

    /**
     * Determine if two associative arrays are similar
     *
     * Both arrays must have the same indexes with identical values
     * without respect to key ordering
     *
     * @param array $a
     * @param array $b
     * @return bool
     */
    private function arraysAreSimilar(array $a, array $b): bool
    {
        // If the indexes don't match, return immediately
        if ( count(array_diff_assoc($a, $b)) ) {
            return false;
        }

        // We know that the indexes, but maybe not values, match.
        // Compare the values between the two arrays
        foreach ($a as $k => $v) {
            if ($v !== $b[$k]) {
                return false;
            }
        }

        // We have identical indexes, and no unequal values
        return true;
    }
}
