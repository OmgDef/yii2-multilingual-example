<?php

namespace app\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property Tag[] $tags
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['tags'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('post_tag_assn', ['post_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::class,
                'languages' => [
                    'ru' => 'Russian',
                    'en-US' => 'English',
                ],
                'langClassName' => PostLang::class, // or namespace/for/a/class/PostLang
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'post_id',
                'tableName' => "{{%post_lang}}",
                'attributes' => [
                    'title', 'text',
                ]
            ],
            'saveRelations' => [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'tags',
                ],
            ],
        ];
    }
}
