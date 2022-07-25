<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LuckPermsAPI\Group\GroupMapper;
use LuckPermsAPI\Session;
use LuckPermsAPI\User\User;
use LuckPermsAPI\User\UserRepository;
use Psr\Http\Message\StreamInterface;

class UserRepositoryTest extends \PHPUnit\Framework\TestCase {

    public function test_load_will_return_user_if_valid() {
        $session = $this->createMock(Session::class);
        $httpClient = $this->createMock(Client::class);
        $session->httpClient = $httpClient;
        $httpClient->method('get')->willReturn($response = $this->createMock(Response::class));
        $response->method('getBody')->willReturn($body = $this->createMock(StreamInterface::class));
        $body->method('getContents')->willReturn(json_encode([
            'uniqueId' => '9490b898-856a-4aae-8de3-2986d007269b',
            'username' => 'Aberdeener',
            'nodes' => [
                [
                    'key' => 'group.staff',
                    'type' => 'inheritance',
                    'value' => 'true',
                    'context' => [],
                ],
                [
                    'key' => 'minecraft.command.ban',
                    'type' => 'permission',
                    'value' => 'true',
                    'context' => [
                        [
                            'key' => 'server',
                            'value' => 'lobby',
                        ],
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR));

        $user = UserRepository::get($session)->load('9490b898-856a-4aae-8de3-2986d007269b');
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('9490b898-856a-4aae-8de3-2986d007269b', $user->uniqueId());
        $this->assertSame('Aberdeener', $user->username());
        $this->assertCount(2, $user->rawNodes());
        $this->assertCount(1, $user->groups());
        $this->assertSame('staff', $user->groups()->first()->name());
        $this->assertTrue($user->groups()->first()->value());
        $this->assertCount(1, $user->permissions());
    }

}
