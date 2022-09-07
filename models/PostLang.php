<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_lang".
 *
 * @property int $id
 * @property int $post_id
 * @property string $language
 * @property string|null $title
 * @property string|null $text
 *
 * @property Post $post
 */
class PostLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'language'], 'required'],
            [['post_id'], 'integer'],
            [['text'], 'string'],
            [['language', 'title'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'language' => 'Language',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }
}
