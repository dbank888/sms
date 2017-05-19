<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 12/05/2017
 * Time: 4:42 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsSendModel extends Model {

    protected $table = 'sms_send';

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

}