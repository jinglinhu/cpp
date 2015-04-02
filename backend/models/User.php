<?php
namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Organization;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends \common\models\User
{
    public $password;
    public $repassword;
    private $_statusLabel;

    /**
     * @inheritdoc
     */
    public function getStatusLabel()
    {
        if ($this->_statusLabel === null) {
            $statuses = self::getArrayStatus();
            $this->_statusLabel = $statuses[$this->status];
        }
        return $this->_statusLabel;
    }

    /**
     * @inheritdoc
     */
    public static function getArrayStatus()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('app', 'STATUS_INACTIVE'),
        ];
    }

    /**
      * @inheritdoc
      */
    public function rules()
    {
        return [
            [['username','realname', 'email','oid'], 'required'],
            [['password', 'repassword'], 'required', 'on' => ['admin-create']],
            [['username', 'realname','position','mobile','email', 'password', 'repassword'], 'trim'],
            [['password', 'repassword'], 'string', 'min' => 6, 'max' => 30],
            // Unique
            [['username', 'email'], 'unique'],
            // Username
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/'],
            ['username', 'string', 'min' => 3, 'max' => 30],
            // E-mail
            ['oid', 'integer', 'min' => 1],
            ['email', 'string', 'max' => 100],
            ['avatar_url', 'string', 'max' => 64],
            [['realname','position','mobile'], 'string', 'max' => 20],
            ['mobile','match','pattern'=>'/^1[0-9]{10}$/'],

            ['email', 'email'],
            // Repassword
            ['repassword', 'compare', 'compareAttribute' => 'password'],
            //['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'admin-create' => ['username', 'email', 'password', 'repassword', 'status','avatar_url','oid','realname','position','mobile'],
            'admin-update' => ['username', 'email', 'password', 'repassword', 'status','avatar_url','oid','realname','position','mobile']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge(
            $labels,
            [
                'password' => Yii::t('app', 'Password'),
                'repassword' => Yii::t('app', 'Repassword'),
                'realname' => Yii::t('app', 'Realname'),
                'position' => Yii::t('app', 'Position'),
                'mobile' => Yii::t('app', 'Mobile'),
                'oid' => Yii::t('app', 'Oid'),
            ]
        );
    }
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'oid']);
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || (!$this->isNewRecord && $this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
                $this->generatePasswordResetToken();
            }
            return true;
        }
        return false;
    }
}
