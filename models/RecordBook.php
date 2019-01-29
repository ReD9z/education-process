<?php

namespace app\models;

use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "recordBook".
 *
 * @property integer $id
 * @property integer $timetable_id
 * @property integer $students_id
 * @property integer $evaluation_id
 * @property integer $visit_id
 * @property string $date
 *
 * @property Evaluation $evaluation
 * @property Students $students
 * @property Timetable $timetable
 * @property Visit $visit
 */
class RecordBook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recordBook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timetable_id', 'students_id', 'visit_id', 'evaluation_id'], 'required'],
            [['timetable_id', 'students_id', 'evaluation_id', 'visit_id'], 'integer'],
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
            'timetable_id' => 'Timetable ID',
            'students_id' => 'Students ID',
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
        $model = new RecordBook;
        $form = ActiveForm::begin();
        return
            $form->field($model, 'evaluation_id[]')->dropDownList(\app\models\Evaluation::EvaValue(), ['prompt' => ''])->label(false);
        ;
        ActiveForm::end();
    }

    public function formAddVisit()
    {
        $model = new RecordBook;
        $form = ActiveForm::begin();
        return 
            $form->field($model, 'visit_id[]')->dropDownList(ArrayHelper::map(\app\models\Visit::find()->all(),'id','name'))->label(false);
        ;
        ActiveForm::end();
    }

    public function formAddStudent($arr)
    {
        $model = new RecordBook;
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
            $form->field($model, 'evaluation_id')->dropDownList(\app\models\Evaluation::EvaValue());
        ;
        ActiveForm::end();
    }

    public function visitNum($arr, $visit)
    {
        $record = RecordBook::find()->where(['students_id' => $arr->id, 'visit_id' => $visit])->all();

        return count($record); 
    }

    public function evaNum($arr, $eva)
    {
        $record = RecordBook::find()->where(['students_id' => $arr->id, 'evaluation_id' => $eva])->all();

        return count($record); 
    }
}
