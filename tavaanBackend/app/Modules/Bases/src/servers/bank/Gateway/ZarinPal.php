<?php

namespace App\Modules\Bases\src\servers\bank\Gateway;

use App\Modules\Payments\src\Repositories\PaymentInterface;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\bank\PaymentGatewayInterface;
use holoo\modules\Payments\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class ZarinPal implements PaymentGatewayInterface
{
    protected bool $sandbox = false;
    protected mixed $merchant_id = '';
    protected mixed $callBack = '';

    protected mixed $request = '';
    protected mixed $verify = '';

    protected int $amount;
    protected string $currency = 'rial';

    public function __construct(public Responses $responses, public PaymentInterface $payment)
    {
        $this->merchant_id = config('client.ZarinPal.merchant_id');
        $this->callBack = config('client.ZarinPal.call_back');
        $this->request = config('client.ZarinPal.request');
        $this->verify = config('client.ZarinPal.verify');
    }

    public function startPayment($amount, $desc, $mobile = null, $email = null, $id = null): mixed
    {
        $metaDate = ($email) ? ['email' => $email] : ['mobile' => $mobile];
        $amount = (int)$amount;

        $payment = Payment::create([
            "link_id" => $id,
            "amount" => $amount,
            'status' => 'pending'
        ]);

        $data = [
            'merchant_id' => $this->merchant_id,
            'amount' => $amount,
            'callback_url' => $this->callBack,
            'description' => $desc,
            'metadata' => $metaDate,
        ];

        try {
            $response = Http::post($this->request, $data);
            $response = json_decode($response->body(), true);
            if (isset($response['data']['message']) == "Success" && isset($response['data']['code']) == 100) {

                $payment->update([
                    'transaction_id' => $response['data']['authority']
                ]);
                return redirect()->to('https://www.zarinpal.com/pg/StartPay/' . $response['data']['authority']);
            }
            return false;
        } catch (Exception $exception) {
            Log::channel('banks')->error('result request zarinPal', [
                'action' => 'startPayment',
                'msg' => 'Zarinpal attempt gateway ' . 'startPayment' . ' response: ' . json_encode($exception->getMessage())
            ]);
            return false;
        }
    }

    public function verify($params)
    {
        try {
            // Check if 'Authority' key exists in $params array
            if (!isset($params['Authority'])) {
                throw new \Exception('Authority parameter is missing.');
            }
            // Find the payment using the transaction ID
            $payment = Payment::where('transaction_id', $params['Authority'])->first();
            if (!$payment) {
                throw new \Exception('Payment not found.');
            }
            // Prepare the data for the verification request
            $data = [
                'merchant_id' => $this->merchant_id,
                'authority' => $params['Authority'],
                'amount' => $payment->amount
            ];
            // Make the HTTP request to verify the payment
            $response = Http::post($this->verify, $data);

            // Check if the response is successful
            if (!$response->successful()) {
                throw new \Exception('Failed to connect to the payment verification service.');
            }
            $responseObject = $response->object();

            // Check if response data exists
            if ($response->successful() && isset($responseObject->data) && $responseObject->data->code == 100) {
                // Update the payment record
                $payment->update([
                    'res_code' =>( $responseObject->data->code) ?  $responseObject->data->code : "",
                    'status' => 'paid',
                    'ref_id' => ($responseObject->data->ref_id) ? $responseObject->data->ref_id : "",
                    'card_number' => ($responseObject->data->card_pan)? $responseObject->data->card_pan : "",
                    'merchant_id' => ($this->merchant_id)? $this->merchant_id : "", // Remove the space here to avoid typo
                    'card_hash' => ($responseObject->data->card_hash)? $responseObject->data->card_hash: "",
                ]);
                return ($responseObject->data->ref_id) ? $responseObject->data->ref_id : true;
            }
        } catch (\Exception $exception) {
            Log::channel('banks')->error('result request zarinPal', [
                'action' => 'verify',
                'msg' => 'Zarinpal attempt gateway ' . 'verify' . ' response: ' . json_encode($exception->getMessage())
            ]);
            return false;
        }
    }

    public function getErrorTrans($code): ?string
    {
        $cases = [
            '-1' => 'اططلاعات ارسال شده ناقص است.',
            '-2' => 'آی پی و با مرچنت کد پذیرنده صحیح نیست.',
            '-3' => 'با توجه به محدودیت های شاپرک امکان پرداخت با رقم درخواست شده میسر نمی باشد.',
            '-4' => 'سطح تایید پذیرنده پایین تر از سطح نقره ای است.',
            '-11' => 'درخواست مورد نظر یافت نشد.',
            '-12' => 'امکان ویرایش درخواست میسر نمی باشد.',
            '-21' => 'هیچ نوع عملیات مالی برای این تراکنش یافت نشد.',
            '-22' => 'تراکنش ناموفق می باشد.',
            '-33' => 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد.',
            '-34' => 'سقف تراکنش از لحاظ تعداد یا رقم عبور کرده است.',
            '-40' => 'اجازه درسترسی به متد مربوطه وجود ندارد.',
            '-41' => 'اطلاعات ارسال additionalData  غیر معتبر می باشد',
            '-42' => 'مدت زمان معتبر طول عمر شناسه پرداخت بین ۳۰ تا ۴۰ دقیقه می باشد.',
            '-54' => 'ارشیومودر نظردرخواست شده است',
            '100' => 'عملیات با موفقیت انجام گردیده است.',
            '101' => 'عملیات پرداخت موفق بوده و قبلا PaymentVerification تراکنش انجام شده است.'
        ];
        return $cases[$code] ?? null;

    }
}
