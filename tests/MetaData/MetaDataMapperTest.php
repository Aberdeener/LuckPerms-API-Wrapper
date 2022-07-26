<?php

use LuckPermsAPI\MetaData\MetaDataMapper;

class MetaDataMapperTest extends \PHPUnit\Framework\TestCase {

    public function test_metadata_mapper_can_map_metadata_data_to_metadata_object(): void {
        $metadataData = [
            'meta' => [
                'test' => 'test',
                'test2' => 'test2',
                'test3' => 'test3',
            ],
        ];

        $metaData = MetaDataMapper::mapSingle($metadataData);

        $this->assertEquals($metadataData['meta'], $metaData->meta()->toArray());
    }
}
