<?php

/**
 * Компонент интеграции с CRM при оставлении заказов клиентов
 * @var $RetailCRM \RetailCrm\ApiClient
 */


namespace app\components;


use RetailCrm\ApiClient;
use yii\base\Component;

class IntegrationRetailCRM extends Component {

    protected $token;
    protected $linkCrm;
    protected $RetailCRM;

    public function init() {
        $this->token = \Yii::getAlias('@RetailToken');
        $this->linkCrm = \Yii::getAlias('@RetailLink');
        parent::init();
    }


    public function CreateOrderCRM($model) {
        /** @var $model \app\models\uploadphoto\OrderPhoto */
        $this->RetailCRM = new ApiClient($this->linkCrm, $this->token, ApiClient::V5);
        $model->clientIdCrm = $this->searchClientIdCrm($model->email);
        $model->client_id = ($model->client_id) ? $model->client_id : 'Guest_'.$model->name;
        $orderInfo = [
            'firstName' => $model->name,
            'phone' => $model->phone,
            'email' => $model->email,
            'call' => 1,
            'customerComment' => $model->comment,
            'managerComment' => 'Папка заказа: ' . \Yii::$app->session->get('folder')
        ];
        if ($model->clientIdCrm)
            $orderInfo['customer'] = ['id' => $model->clientIdCrm];
        //        return $model->realPrice;
        foreach ($model->realPrice as $k => $v) {
            foreach ($v as $key => $item) {
                if ($item['pcs'] !== 0) {
                    $orderInfo['items'][] = [
                        'offer' => ['externalId' => 'paper_' . $k . '_230g_' . $key],
                        'quantity' => $item['pcs']
                    ];
                }
            }
        }

        try {
            $response = $this->RetailCRM->request->ordersCreate($orderInfo);
        } catch (\RetailCrm\Exception\CurlException $e) {
            return "Connection error: " . $e->getMessage();
        }

        if ($response->isSuccessful() && 201 === $response->getStatusCode()) {
            $model->orderNumCRM = $response->id;
            $model->status = 'open';
            return ['status' => 'ok', 'id' => $response->id];
        }

    }

    public function searchClientIdCrm($email = false) {
        $this->RetailCRM = new ApiClient($this->linkCrm, $this->token, ApiClient::V5);
        if (!$email)
            return $email;

        try {
            $response = $this->RetailCRM->request->customersList(['email' => $email], 1);
        } catch (\RetailCrm\Exception\CurlException $e) {
            return false;
        }
        if ($response->isSuccessful()) {
            if (isset($response['customers']['0']))
                return $response['customers']['0']['id']; else return false;

        }
        return false;

    }

}