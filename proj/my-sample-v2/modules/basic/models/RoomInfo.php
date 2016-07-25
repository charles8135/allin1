<?php

namespace app\modules\basic\models;

use yii\db\ActiveRecord;

class RoomInfo extends ActiveRecord {

    public static function tableName() {
        return 'room_info';
    }

}
