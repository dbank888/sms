<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 15/05/2017
 * Time: 10:10 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsReceiveModel extends Model {

    protected $table = 'sms_receive';

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

}