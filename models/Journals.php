<?php

namespace app\models;

use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "journals".
 *
 * @property integer $id
 * @property integer $students_id
 * @property integer $timetable_id
 * @property integer $evaluation_id
 * @property integer $visit_id
 * @property string $date
 *
 * @property Evaluation $evaluation
 * @property Students $students
 * @property Timetable $timetable
 * @property Visit $visit
 */
class Journals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'journals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['students_id', 'timetable_id', 'evaluation_id', 'visit_id'], 'integer'],
            [['visit_id'], 'required'],
            [['date'], 'safe'],
            [['evaluation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evaluation::className(), 'targetAttribute' => ['evaluation_id' => 'id']],
            [['students_id'], 'exist', 'skipOnError' => true, 'targetClass' => Students::className(), 'targetAttribute' => ['students_id' => 'id']],
            [['timetable_id'], 'exist', 'skipOnError' => true, 'targetClass' => Timetable::className(), 'targetAttribute' => ['timetable_id' => 'id']],
            [['visit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Visit::className(), 'targetAttribute' => ['visit_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'students_id' => 'Students ID',
            'timetable_id' => 'Timetable ID',
            'evaluation_id' => 'Оценка',
            'visit_id' => 'Посещение',
            'date' => 'Дата',
            'students.users.username' => 'ФИО',
            'timetable.plan.discipline.name' => 'Дисциплина',
            'visit.name' => 'Посещение',
            'timetable.users.username' => 'Преподаватель',
            'timetable.trainingChoice.typesTraining.name' => 'Тип занятия',
            'evaluation.name' => 'Оценка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluation()
    {
        return $this->hasOne(Evaluation::className(), ['id' => 'evaluation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(Students::className(), ['id' => 'students_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimetable()
    {
        return $this->hasOne(Timetable::className(), ['id' => 'timetable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['id' => 'visit_id']);
    }

    public function eva($name)
    {
        if ($name === null) {
            
        } else {
            return '<b>Оценка:</b> '. $name .'<br>';
        }
    }

    public function formAddEva()
    {
        $model = new Journals();
        $form = ActiveForm::begin();
        return
            $form->field($model, 'evaluation_id[]')->dropDownList(\app\models\Evaluation::JournalEvaValue(), ['prompt' => ''])->label(false);
        ;
        ActiveForm::end();
    }

    public function formAddVisit()
    {
        $model = new Journals();
        $form = ActiveForm::begin();
        return 
            $form->field($model, 'visit_id[]')->dropDownList(ArrayHelper::map(\app\models\Visit::find()->all(),'id','name'))->label(false);
        ;
        ActiveForm::end();
    }

    public function formAddStudent($arr)
    {
        $model = new Journals();
        $form = ActiveForm::begin();
        return 
            $form->field($model, 'students_id[]')->hiddenInput(['value' => $arr->id])->label(false);
        ;
        ActiveForm::end();
    }

    public function formAddVisitUp($model)
    {    
        $form = ActiveForm::begin();
        return 
            $form->field($model, 'visit_id')->dropDownList(ArrayHelper::map(\app\models\Visit::find()->all(),'id','name'));
        ;
        ActiveForm::end();
    }

    public function formAddEvaUp($model)
    {
        $form = ActiveForm::begin();
        return
            $form->field($model, 'evaluation_id')->dropDownList(\app\models\Evaluation::JournalEvaValue(), ['prompt' => '']);
        ;
        ActiveForm::end();
    }

    public function visitNum($arr, $visit)
    {
        $journals = Journals::find()->where(['students_id' => $arr->id, 'visit_id' => $visit])->all();

        return count($journals); 
    }

    public function evaNum($arr, $eva)
    {
        $journals = Journals::find()->where(['students_id' => $arr->id, 'evaluation_id' => $eva])->all();

        return count($journals);
    }

}
