<?php

use LuckPermsAPI\MetaData\UserMetaDataMapper;

class UserMetaDataMapperTest extends \PHPUnit\Framework\TestCase {

    public function test_usermetadata_mapper_can_map_usermetadata_data_to_usermetadata_object(): void {
        $userMetadataData = [
            'meta' => [
                'test' => 'test',
                'test2' => 'test2',
                'test3' => 'test3',
            ],
            'prefix' => 'test4',
            'suffix' => 'test5',
            'primaryGroup' => 'staff',
        ];

        $userMetaData = UserMetaDataMapper::mapSingle($userMetadataData);

        $this->assertEquals($userMetadataData['meta'], $userMetaData->meta()->toArray());
        $this->assertEquals($userMetadataData['prefix'], $userMetaData->prefix());
        $this->assertEquals($userMetadataData['suffix'], $userMetaData->suffix());
        $this->assertEquals($userMetadataData['primaryGroup'], $userMetaData->primaryGroup());
    }
}
