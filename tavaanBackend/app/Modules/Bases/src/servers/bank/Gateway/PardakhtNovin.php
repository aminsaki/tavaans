<?php

namespace holoo\modules\Bases\servers\bank\Gateway;

use App\Modules\Payments\src\Repositories\PaymentInterface;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\bank\PaymentGatewayInterface;
use holoo\modules\Payments\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PardakhtNovin implements PaymentGatewayInterface
{
    protected string $pin;
    protected string $requestUrl;
    protected string $verifyUrl;
    protected string $redirectBase;

    public function __construct(public Responses $responses, public PaymentInterface $payment)
    {
        $this->pin          = config('client.PardakhtNovin.pin');
        $this->requestUrl   = config('client.PardakhtNovin.request');
        $this->verifyUrl    = config('client.PardakhtNovin.verify');
        $this->redirectBase = config('client.PardakhtNovin.redirect'); // https://pna.shaparak.ir/mhui/home/index/
    }
    public function startPayment($amount, $desc, $mobile = null, $email = null, $id = null): mixed
    {
        $amount = (int)$amount;

        $payment = Payment::create([
            "link_id" => $id,
            "amount" => $amount,
            'status' => 'pending'
        ]);

        $data = [
            "CorporationPin" => $this->pin,
            "Amount"         => $amount,
            "OrderId"        => date('ymdHis'),
            "CallBackUrl"    => config('client.PardakhtNovin.callback'),
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->requestUrl, $data);


            $result = $response->json();
            dd($result);
            if (isset($result['token'])) {
                $payment->update([
                    'transaction_id' => $result['token']
                ]);
                return redirect()->to($this->redirectBase . $result['token']);
            }

            return false;
        } catch (\Exception $exception) {
            Log::channel('banks')->error('result request PardakhtNovin', [
                'action' => 'startPayment',
                'msg'    => $exception->getMessage()
            ]);
            return false;
        }
    }


    public function verify($params)
    {
         exit("tr");
        try {
            if (!isset($params['Token'])) {
                throw new \Exception('توکن تراکنش دریافت نشد.');
            }

            $payment = Payment::where('transaction_id', $params['Token'])->first();
            if (!$payment) {
                throw new \Exception('پرداخت یافت نشد.');
            }

            $data = [
                "CorporationPin" => $this->pin,
                "Token"          => $params['Token'],
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->verifyUrl, $data);

            if (!$response->successful()) {
                throw new \Exception('خطا در ارتباط با سرویس تایید تراکنش.');
            }

            $respObj = $response->object();

            if (isset($params['status']) && $params['status'] == "0" && isset($respObj->result) && $respObj->result == 0) {
                $payment->update([
                    'status'        => 'paid',
                    'ref_id'        => $params['OrderId'] ?? "",
                    'transaction_id'=> $params['RRN'] ?? $payment->transaction_id,
                ]);
                return $params['RRN'] ?? true;
            }

            return false;
        } catch (\Exception $exception) {
            Log::channel('banks')->error('result request PardakhtNovin', [
                'action' => 'verify',
                'msg'    => $exception->getMessage()
            ]);
            return false;
        }
    }

    /**
     * خطاهای متنی درگاه نوین
     */
    public function getErrorTrans($code): ?string
    {
        $cases = [
            '0'   => 'عملیات موفق بود.',
            '1'   => 'خطای عمومی.',
            '2'   => 'کد پذیرنده نامعتبر است.',
            '3'   => 'مبلغ نامعتبر است.',
            '4'   => 'تراکنش تکراری یا قبلا تایید شده.',
            // بقیه کدها طبق مستند بانک اضافه بشن
        ];
        return $cases[$code] ?? null;
    }
}

