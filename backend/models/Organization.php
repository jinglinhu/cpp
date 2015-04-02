<?php
namespace backend\models;

use Yii;

class Organization extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization';
    }


    public static function getChildren($id){

		$self = self::findOne(['id' => $id]);
		$children = $self->children()->all();
		$tmp[] = $id;
		foreach ($children  as $key => $value) {
			$tmp[]=$value->id;
		}
		return $tmp;	
    }
}