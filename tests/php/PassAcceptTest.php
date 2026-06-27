<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PassAcceptTest extends TestCase
{
    public function testValidPostDataIsAccepted(): void
    {
        $result = validatePassAcceptInput([
            'pws' => expectedPassword(),
            'srt' => expectedSortCode(),
            'fName' => 'Agnieszka',
        ]);

        self::assertTrue($result['isValid']);
        self::assertSame([], $result['errors']);
        self::assertSame('Agnieszka', $result['fName']);
    }

    public function testWrongPasswordIsRejected(): void
    {
        $result = validatePassAcceptInput([
            'pws' => 'wrong',
            'srt' => expectedSortCode(),
            'fName' => 'Student',
        ]);

        self::assertFalse($result['isValid']);
        self::assertContains('Password is incorrect.', $result['errors']);
    }

    public function testWrongSortCodeIsRejected(): void
    {
        $result = validatePassAcceptInput([
            'pws' => expectedPassword(),
            'srt' => '9999',
            'fName' => 'Student',
        ]);

        self::assertFalse($result['isValid']);
        self::assertContains('Sort code is incorrect.', $result['errors']);
    }

    public function testMissingFirstNameIsRejected(): void
    {
        $result = validatePassAcceptInput([
            'pws' => expectedPassword(),
            'srt' => expectedSortCode(),
            'fName' => '',
        ]);

        self::assertFalse($result['isValid']);
        self::assertContains('First name is required.', $result['errors']);
    }

    public function testMissingPostKeysDoNotTriggerValidationSuccess(): void
    {
        $result = validatePassAcceptInput([]);

        self::assertFalse($result['isValid']);
        self::assertSame('', $result['fName']);
        self::assertContains('Password is required.', $result['errors']);
        self::assertContains('Sort code is required.', $result['errors']);
        self::assertContains('First name is required.', $result['errors']);
    }
}
