<?php

use LuckPermsAPI\Context\Context;
use LuckPermsAPI\Context\ContextKey;
use LuckPermsAPI\Context\ContextSetMapper;
use PHPUnit\Framework\TestCase;

class ContextSetMapperTest extends TestCase {

    public function test_context_mapper_can_map_context_data_to_context_objects(): void {
        $contextData = [
            [
                'key' => 'world',
                'value' => 'hub',
            ],
            [
                'key' => 'server',
                'value' => 'lobby',
            ],
            [
                'key' => 'server',
                'value' => 'survival-1',
            ],
        ];

        $contextSet = ContextSetMapper::map($contextData);

        $this->assertCount(3, $contextSet);

        foreach ($contextSet->all() as $context) {
            $this->assertInstanceOf(Context::class, $context);
        }

        $this->assertEquals(ContextKey::World, $contextSet->get(0)->key());
        $this->assertEquals('hub', $contextSet->get(0)->value());
        $this->assertEquals(ContextKey::Server, $contextSet->get(1)->key());
        $this->assertEquals('lobby', $contextSet->get(1)->value());
        $this->assertEquals(ContextKey::Server, $contextSet->get(2)->key());
        $this->assertEquals('survival-1', $contextSet->get(2)->value());
    }

}
