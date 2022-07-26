<?php

use LuckPermsAPI\Config\ConfigBuilder;
use LuckPermsAPI\Exception\LuckPermsConnectionException;
use LuckPermsAPI\Session;

class SessionTest extends \PHPUnit\Framework\TestCase {

    public function test_exception_handled_during_initialization(): void {
        $this->markTestSkipped();

        $session = $this->createMock(Session::class);
        $session->method('validateConnection')->willReturnCallback(function () {
            throw new LuckPermsConnectionException("Could not connect to LuckPerms API: foo bar");
        });

        $this->expectException(LuckPermsConnectionException::class);
        $this->expectExceptionMessage("Could not connect to LuckPerms API: foo bar");

        LuckPermsAPI\LuckPermsClient::make(
            ConfigBuilder::make()
                ->withBaseUri('http://localhost:8080')
                ->withApiKey('invalid')
                ->build()
        );
    }

}
