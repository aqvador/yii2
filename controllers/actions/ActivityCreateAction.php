<?phpnamespace app\controllers\actions;use yii\base\Action;class ActivityCreateAction extends Action {    public $name;    public function run() {        return $this->controller->render('create', ['name' =>$this->name]);    }}