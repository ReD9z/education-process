<?

namespace app\models;

use yii\base\Model;
use Yii;

class ModelsFun extends Model
{
    public static function addData($name, $timetable)
    {
	 	$arr = Yii::$app->request->post($name);
        for ($i=0; $i < count($arr['students_id']); $i++) { 
           	Yii::$app->db->createCommand()->insert($name, [
                'students_id' => $arr['students_id'][$i],
                'evaluation_id' => $arr['evaluation_id'][$i],
                'visit_id' => $arr['visit_id'][$i],
                'timetable_id' => $timetable,
                'date' =>  date('Y.m.d'),
            ])->execute();
        }
    }
}