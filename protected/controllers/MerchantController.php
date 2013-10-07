<?php

class MerchantController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Оплата";
    /*
            if( $_POST["register_submit_button"] )
            {
                $gateway = Yii::app()->getComponent('payment')->getGateway('PaypalExpress');
                $response = $gateway->setupPurchase(100, array(
                    'return_url' => $this->createAbsoluteUrl(
                        '/payment/callback', array('success' => 1, 'order_id' => 1)
                    ),
                    'cancel_return_url' => $this->createAbsoluteUrl(
                        '/payment/callback', array('failed'  => 1, 'order_id'  => 1)
                    ),
                    'items' => array(
                        array(
                            'description' => 'Bla bla',
                            'unit_price'  => 100,
                            'quantity'    => 1,
                            'id'              => 1
                        )
                    )
                ));
                if ($response->success()) {
                    $this->redirect($gateway->urlForToken($response->token()));
                }

        // payment controller::callback action
        // IPN
                if (isset($_REQUEST['success'], $_GET['token'], $_GET['PayerID'])) {
                    $gateway = Yii::app()->getComponent('payment')->getGateway('PaypalExpress');
                    $response = $gateway->get_details_for($_GET['token'], $_GET['PayerID']);
                    $response = $gateway->purchase($response->amount());
                    if ($response->success()) {
                        // success payment
                    } else {
                        //error payment
                    }
                }
            }*/

            $id = Yii::app()->request->getParam( "id", 0 );
            if( $id>0 )
            {
                $order = OrderRequest::fetch( $id );
                if( $order->id >0 && $order->del == 0 )
                {
                    $this->render('index', array( "controller"=>$this, "model"=>$order ));
                }
            }
                else $this->redirect( SiteHelper::createUrl("/user/requsets") );
        }
	}

    // Сообщение о успешной оплате
    public function actionReturn()
    {
        if( !Yii::app()->user->isGuest )
        {
            $this->render( "return" );
        }
    }

    // Сообщение о не успешной оплате
    public function actionCansel()
    {
        if( !Yii::app()->user->isGuest )
        {
            $this->render( "cansel" );
        }
    }

    // получение инфорамции о полученной оплате
    public function actionNotify()
    {
        $error = "";
        $response = "";

        $log = fopen("merchant2.log", "a");
        fwrite($log, "\n\nipn - " . gmstrftime ("%b %d %Y %H:%M:%S", time()) . "\n");

        $req = "cmd=_notify-validate";
        foreach($_POST as $key=>$val)
        {
            $req.= "&".$key."=".urlencode($val);
            //$response .= $key."=".$val."<br/>";
            fwrite($log,$key."=".$val."\n");
        }

//--------------------------------------------
// Create message to post back to PayPal...
// Open a socket to the PayPal server...
//--------------------------------------------
        $header = "POST http://www.paypal.com/cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";
        $fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);

//----------------------------------------------------------------------
// Check HTTP connection made to PayPal OK, If not, print an error msg
//----------------------------------------------------------------------
        if (!$fp)
        {
            echo "$errstr ($errno)";
            fwrite($log, "Failed to open HTTP connection!\n");
            fwrite($log, $errstr." ".$errno);
            $error = "Failed to open HTTP connection!\n";
        }

        if( empty( $error ) )
        {
    //--------------------------------------------------------
    // If connected OK, write the posted values back, then...
    //--------------------------------------------------------
            fputs ($fp, $header . $req);
    //-------------------------------------------
    // ...read the results of the verification...
    // If VERIFIED = continue to process the TX...
    //-------------------------------------------
            $res="";
            while (!feof($fp))
                $res .= fgets ($fp, 1024);
            fclose ($fp);

            if (strpos($res, "VERIFIED")===FALSE)
            {
                fwrite($log,"ERROR - UnVERIFIIED payment\r\nPayPal response:");
                fwrite($log,$res);
                $error = "UnVERIFIIED payment\r\nPayPal response".$res;
            }

            if( empty( $error ) )
            {
                fwrite($log,"payment VERIFIIED\r\n");

                if ($_POST["payment_status"]!="Completed")
                {
                    fwrite($log,"ERROR - payment status is not Completed\r\n");
                    $error = "Payment status is not Completed";
                }
            }
        }

        $transaction = new MerchantTransactions();
        $transaction->request_id = $_POST["item_number"];
        $transaction->date = time();
        $transaction->response = print_r( $_POST, 1 );
        $transaction->operator = "paypal";
        $transaction->status = 4; // по умолчанию ошибка оплаты

        $request = PlantRequest::fetch($_POST["item_number"]);
        if( $request->id >0 )$transaction->amount = $request->amount;
                    else $error = "Получен не существующий ID заказа";

        if( empty( $error ) )
        {
            $transaction->status = 2;
            fwrite($log,"OK - payment received.\r\n");;
        }
            else $transaction->error = $error;

        if( !$transaction->save() )
        {
            fwrite($log, "Error save transaction\r\n");
            fwrite($log, print_r( $transaction->getErrors(), 1 ) );
        }
            else fwrite($log, "Transaction save\r\n");

        fclose($log);
    }
}