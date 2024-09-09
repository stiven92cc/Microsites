<?php

namespace Tests\Feature\Payments;

use App\Constants\PaymentStatus;
use App\Infrastructure\Persistence\Models\Payment;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Contracts\PaymentGatewayContract;
use App\Jobs\ResolvePaymentJob;
use App\PaymentGateway\PlacetopayGateway;
use Dnetix\Redirection\Message\RedirectInformation;
use Dnetix\Redirection\Message\RedirectResponse;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function getCreateSessionResponse($type)
    {
        $responses = json_decode(file_get_contents(__DIR__.'/../../Fixtures/createSession_responses.json'), true);

        return $responses[$type] ?? null;
    }

    protected function getQueryResponse($type)
    {
        $responses = json_decode(file_get_contents(__DIR__.'/../../Fixtures/query_responses.json'), true);
        return $responses[$type] ?? null;
    }

    public function testSuccessfulPay()
    {
        $microsite = Microsite::factory()->create();
        $data = [
            'amount' => 10000,
            'description' => 'Test Payment',
            'payer_document' => '12345678',
            'payer_email' => 'test@example.com',
        ];
        $mockPlacetoPay = Mockery::mock(PlacetoPay::class);

        $mockPlacetoPay->shouldReceive('request')
            ->andReturn(new RedirectResponse($this->getCreateSessionResponse('successful')));

        $mockGateway = Mockery::mock(PlacetopayGateway::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mockGateway->shouldAllowMockingProtectedMethods();
        $mockGateway->shouldReceive('getPlacetoPay')
            ->andReturn($mockPlacetoPay);

        $this->app->instance(PlacetopayGateway::class, $mockGateway);

        $response = $this->post(route('payment.pay', $microsite->id), $data);

        $response->assertStatus(302);
        $response->assertRedirect('https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a');

        $this->assertDatabaseHas('payments', [
            'microsite_id' => $microsite->id,
            'amount' => 10000,
            'status' => 'pending',
            'request_id' => 1,
            'process_url' => 'https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a',
        ]);
    }

    public function testFailedPay()
    {
        $microsite = Microsite::factory()->create();
        $data = [
            'amount' => 10000,
            'description' => 'Test Payment',
            'payer_document' => '12345678',
            'payer_email' => 'test@example.com',
        ];
        $mockPlacetoPay = Mockery::mock(PlacetoPay::class);

        $mockPlacetoPay->shouldReceive('request')
            ->andReturn(new RedirectResponse($this->getCreateSessionResponse('failed')));

        $mockGateway = Mockery::mock(PlacetopayGateway::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mockGateway->shouldAllowMockingProtectedMethods();
        $mockGateway->shouldReceive('getPlacetoPay')
            ->andReturn($mockPlacetoPay);

        $this->app->instance(PlacetopayGateway::class, $mockGateway);

        $response = $this->post(route('payment.pay', $microsite->id), $data);

        $response->assertStatus(500);

        $this->assertDatabaseHas('payments', [
            'microsite_id' => $microsite->id,
            'amount' => 10000,
            'status' => 'rejected',
        ]);
    }


    public function testResolvePaymentJobApproved()
    {
        $payment = Payment::factory()->create([
            'status' => 'pending',
            'request_id' => 1
        ]);

        $mockPlacetoPay = Mockery::mock(PlacetoPay::class);

        $mockPlacetoPay->shouldReceive('query')
            ->andReturn(new RedirectInformation($this->getQueryResponse('approved')));

        $mockGateway = Mockery::mock(PlacetopayGateway::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mockGateway->shouldAllowMockingProtectedMethods();
        $mockGateway->shouldReceive('getPlacetoPay')
            ->andReturn($mockPlacetoPay);

        $this->app->instance(PlacetopayGateway::class, $mockGateway);

        $job = new ResolvePaymentJob($payment);
        $job->handle();

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatus::APPROVED->value,
            'receipt' => '052617800175',
        ]);
    }


    public function testResolvePaymentJobRejected()
    {
        $payment = Payment::factory()->create([
            'status' => 'pending',
            'request_id' => 1
        ]);

        $mockPlacetoPay = Mockery::mock(PlacetoPay::class);

        $mockPlacetoPay->shouldReceive('query')
            ->andReturn(new RedirectInformation($this->getQueryResponse('rejected')));

        $mockGateway = Mockery::mock(PlacetopayGateway::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mockGateway->shouldAllowMockingProtectedMethods();
        $mockGateway->shouldReceive('getPlacetoPay')
            ->andReturn($mockPlacetoPay);

        $this->app->instance(PlacetopayGateway::class, $mockGateway);

        $job = new ResolvePaymentJob($payment);
        $job->handle();

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'REJECTED',
        ]);
    }
}
